<?php

namespace App\Http\Controllers;

use App\Models\LineBot;
use App\Models\LineBotDestination;
use App\Models\Client;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client as HttpClient;
use LINE\LINEBot\Event\FollowEvent;
use LINE\LINEBot\Event\FollowEventAllof;
use LINE\LINEBot\Event\ActivatedEvent;
use LINE\LINEBot\Event\UnfollowEvent;
use LINE\Clients\MessagingApi\Configuration;
use LINE\Clients\MessagingApi\Api\MessagingApiApi;
use LINE\Clients\MessagingApi\Api\MessagingApiBlobApi;
use LINE\Clients\MessagingApi\Model\ReplyMessageRequest;
use LINE\Clients\MessagingApi\Model\TextMessage;
use LINE\Constants\HTTPHeader;
use LINE\Parser\EventRequestParser;
use LINE\Webhook\Model\MessageEvent;
use LINE\Parser\Exception\InvalidEventRequestException;
use LINE\Parser\Exception\InvalidSignatureException;
use LINE\Webhook\Model\TextMessageContent;

class LineEventController extends Controller
{

    private $api = null;
    private $blobApi = null;

    public function handleEvent(Request $request)
    {

        // get distination
        $req = json_decode($request->getContent());
        $destination = $req->destination;

        // check events
        if (empty($req->events)) {
            logger()->channel('destinations')->info($destination);
            LineBotDestination::create(['destination' => $destination]);
            abort(200);
        }

        // check signature if empty
        $signature = $request->header('X-Line-Signature');
        if (empty($signature)) return;

        // load token etc.
        $lineBot = LineBot::where('destination',$destination)->first();
        $channelSecret = $lineBot->channel_secret;
        $channelToken = $lineBot->access_token;

        // for debugs
        logger()->channel('line')->debug(json_encode(['request' => $request->getContent()], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        // parse request
        try {
            $events = EventRequestParser::parseEventRequest($request->getContent(), $channelSecret, $signature)->getEvents();
        } catch (InvalidSignatureException $e) {
            logger()->channel('line')->error('Invalid Signature: ' . $e->getMessage());
            return;
        } catch (InvalidEventRequestException $e) {
            logger()->channel('line')->error('Invalid Event Request: ' . $e->getMessage());
            return;
        }


        foreach ($events as $event) {
            // log events for debug
            logger()->channel('line')->debug(json_encode(['event' => $event], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

            logger()->channel('line')->debug(['type' => $event->getType()]);

            switch ($event->getType()) {

                case 'follow':
                    logger()->channel('line')->debug('followed.');
                    $lineUserId = $event->getSource()->getUserId();
                    
                    // Check if client exists
                    $client = Client::where('line_user_id', $lineUserId)->first();

                    if ($client === null) {
                        // Client does not exist, fetch the profile
                        $this->initMessagingApi($lineBot->access_token);
                        $profile = $this->api->getProfile($lineUserId);
                        logger()->channel('line')->debug(json_encode(['profile' => $profile], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
                        logger()->channel('line')->debug($profile->getDisplayName());
                        logger()->channel('line')->debug($profile->getPictureUrl());

                        // Create the client with all details in one query
                        $client = Client::create([
                            'organisation_id' => $lineBot->organisation_id,
                            'line_user_id' => $lineUserId,
                            'line_display_name' => $profile->getDisplayName(),
                            'line_picture_url' => $profile->getPictureUrl(),
                            'line_reply_token' => $event->getReplyToken(),
                            'line_reply_limit' => now()->addSeconds(29),
                        ]);

                        logger()->channel('line')->debug('Client profile saved.');
                    } else {
                        $client->update([
                            'line_reply_token' => $event->getReplyToken()
                        ]);
                    }

                    break;

                case 'message':

                    $message = $event->getMessage();

                    switch ($message->getType()) {

                        case 'text':
                            $message = Message::create([
                                'from_user' => true,
                                'sender_id' => $event->getSource()->getUserId(),
                                'receiver_id' => null,
                                'organisation_id' => $lineBot->organisation->id,
                                'body' => $message->getText(),
                            ]);
                            $message->sender->update([
                                'line_reply_token' => $event->getReplyToken(),
                                'line_reply_limit' => now()->addSeconds(29),
                            ]);
                            break;

                        case 'image':
                            $this->initMessagingApi($lineBot->access_token);
                            $sfo = $this->blobApi->getMessageContent($event['message']['id']);
                            $extension = $this->getExtensionFromFileObject($sfo);
                            $imageData = $sfo->fread($sfo->getSize());
                            if ($imageData) {
                                // implement store the image
                                $filepath = 'images/' . uniqid() . '.' . $extension;

                                // Store the image in the S3 bucket
                                Storage::disk('s3')->put($filepath, $imageData);

                                $message = Message::create([
                                    'from_user' => true,
                                    'type' => 'image',
                                    'sender_id' => $event->getSource()->getUserId(),
                                    'receiver_id' => null,
                                    'organisation_id' => $lineBot->organisation->id,
                                    'path' => $filepath,
                                ]);
                                $message->sender->update([
                                    'line_reply_token' => $event->getReplyToken(),
                                    'line_reply_limit' => now()->addSeconds(29),
                                ]);

                            } else {
                                logger()->channel('line')->debug($response->getHTTPStatus());
                            }

                            break;

                        case 'sticker':
                            // スタンプが送信された場合
                            break;
                        
                    }

                    break;

            }
        }

        return response()->json('', 200);
    }

    private function initMessagingApi($access_token) {
        $client = new HttpClient();
        $config = new Configuration();
        $config->setAccessToken($access_token);

        $this->api = new MessagingApiApi(
            client: $client,
            config: $config,
        );
        $this->blobApi = new MessagingApiBlobApi(
            client: $client,
            config: $config,
        );

        return;
    }


    private function getExtensionFromFileObject($sfo)
    {
        // Open fileinfo
        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        // Get the MIME type directly from the file object
        $mimeType = finfo_file($finfo, $sfo->getRealPath());
        finfo_close($finfo);

        // Map the MIME type to a file extension
        $extension = null;
        switch ($mimeType) {
            case 'image/jpeg':
                $extension = 'jpg';
                break;
            case 'image/png':
                $extension = 'png';
                break;
            case 'image/gif':
                $extension = 'gif';
                break;
            case 'image/webp':
                $extension = 'webp';
                break;
            // Add other MIME types and extensions as needed
            default:
                throw new Exception("Unsupported image type: $mimeType");
        }

        return $extension;
    }

}
