<?php

namespace App\Services;
use App\Models\LineBot;
use App\Models\Client;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\Facades\Storage;
use LINE\Constants\MessageType;
use LINE\Clients\MessagingApi\Configuration;
use LINE\Clients\MessagingApi\Api\MessagingApiApi;
use LINE\Clients\MessagingApi\Model\ReplyMessageRequest;
use LINE\Clients\MessagingApi\Model\PushMessageRequest;
use LINE\Clients\MessagingApi\Model\TextMessage;
use LINE\Clients\MessagingApi\Model\ImageMessage;

class LineMessagingApi
{
    public function initMessagingApi($access_token) {
        $client = new HttpClient();
        $config = new Configuration();
        $config->setAccessToken($access_token);
        return new MessagingApiApi(
            client: $client,
            config: $config,
        );
    }

    public function sendMessageToClient($staffId, $clientId, $orgId, $message)
    {
        // dd($from,$to,$org,$message);
        $client = Client::where('line_user_id',$clientId)->firstOrFail();
        $lineBot = LineBot::where('organisation_id',$orgId)->firstOrFail();
        $channelSecret = $lineBot->channel_secret;
        $channelToken = $lineBot->access_token;
        $msgApi = $this->initMessagingApi($lineBot->access_token);

        if($client->line_reply_token){
            if ($client->line_reply_limit && $client->line_reply_limit->isFuture()) {
                $msgApi->replyMessage(new ReplyMessageRequest([
                    'replyToken' => $client->line_reply_token,
                    'messages' => [
                        (new TextMessage(['text' => $message]))->setType('text'),
                    ],
                ]));
                $client->update([
                    'line_reply_token' => null,
                    'line_reply_limit' => null,
                ]);
            } else {
                $msgApi->pushMessage(new PushMessageRequest([
                    'to' => $clientId,
                    'messages' => [
                        (new TextMessage(['text' => $message]))->setType('text'),
                    ],
                ]));
            }
        } else {
            $msgApi->pushMessage(new PushMessageRequest([
                'to' => $clientId,
                'messages' => [
                    (new TextMessage(['text' => $message]))->setType('text'),
                ],
            ]));
        }
    }

    public function sendMessagesInBulkToClient($staffId, $clientId, $orgId, $messages)
    {

        $client = Client::where('line_user_id',$clientId)->firstOrFail();
        $lineBot = LineBot::where('organisation_id',$orgId)->firstOrFail();
        $channelSecret = $lineBot->channel_secret;
        $channelToken = $lineBot->access_token;
        $msgApi = $this->initMessagingApi($lineBot->access_token);

        // create message requests
        $msgReqs = [];
        foreach ($messages as $key => $message) {
            switch ($message->type) {
                case 'text':
                    $msgReqs[] = (new TextMessage(['text' => $message->body]))->setType('text');
                    break;
                case 'image':
                    $url = Storage::disk('s3')->url($message->path);
                    $msgReqs[] = new ImageMessage([
                        'type' => MessageType::IMAGE,
                        'originalContentUrl' => $url,
                        'previewImageUrl' => $url,
                    ]);
                    break;
                case 'file':
                    $msgReqs[] = (new TextMessage(['text' => $message->body]))->setType('text');
                    break;
            }
        }

        if($client->line_reply_token && $client->line_reply_limit && $client->line_reply_limit->isFuture()){
            
            $msgApi->replyMessage(new ReplyMessageRequest([
                'replyToken' => $client->line_reply_token,
                'messages' => $msgReqs,
            ]));

            $client->update([
                'line_reply_token' => null,
                'line_reply_limit' => null,
            ]);

        } else {

            // TODO: implement
            $msgApi->pushMessage(new PushMessageRequest([
                'to' => $clientId,
                'messages' => $msgReqs,
            ]));
        }
    }

    public function sendMsgInBulk($staffId, $clientId, $orgId, $msgReqs)
    {

        $client = Client::where('line_user_id',$clientId)->firstOrFail();
        $lineBot = LineBot::where('organisation_id',$orgId)->firstOrFail();
        $channelSecret = $lineBot->channel_secret;
        $channelToken = $lineBot->access_token;
        $msgApi = $this->initMessagingApi($lineBot->access_token);

        if($client->line_reply_token && $client->line_reply_limit && $client->line_reply_limit->isFuture()){
            
            $msgApi->replyMessage(new ReplyMessageRequest([
                'replyToken' => $client->line_reply_token,
                'messages' => $msgReqs,
            ]));

            $client->update([
                'line_reply_token' => null,
                'line_reply_limit' => null,
            ]);

        } else {

            // TODO: implement
            $msgApi->pushMessage(new PushMessageRequest([
                'to' => $clientId,
                'messages' => $msgReqs,
            ]));
        }
    }
}
