<?php

namespace App\Livewire\Page\ManageEnquiry;

use App\Models\Message;
use App\Models\Client;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use App\Services\LineMessagingApi;
use App\Services\UtilityService;
use LINE\Clients\MessagingApi\Model\TextMessage;
use LINE\Clients\MessagingApi\Model\ImageMessage;
use LINE\Constants\MessageType;

class ManageMessage extends Component
{

    use WithFileUploads;

    public $messages = [];
    public $text = '';
    public $files = [];
    public $allFiles = []; // Additional array to track all files
    public $currentClientLineUserId = null;
    public $hasMoreMessages = false;
    public $limitOfMessages = 20;

    public function loadOldMessages()
    {
        if (!empty($this->messages)) {
            $oldestMessage = $this->messages->first();
        } else {
            $oldestMessage = null;
        }
        $messagesQuery = Message::where(function ($query) {
            $query->where('organisation_id', auth()->user()->organisation_id)
                ->where('receiver_id', $this->currentClientLineUserId);
        })->orWhere(function ($query) {
            $query->where('sender_id', $this->currentClientLineUserId)
                ->where('organisation_id', auth()->user()->organisation_id);
        })
            ->orderBy('created_at', 'desc')
            ->when($oldestMessage, function ($query) use ($oldestMessage) {
                $query->where('id', '<', $oldestMessage->id);
            })
            ->limit($this->limitOfMessages + 1);
        $messages = $messagesQuery->get();

        // Check if there are more messages than the limit
        $this->hasMoreMessages = $messages->count() > $this->limitOfMessages;

        if ($this->hasMoreMessages) {
            // If there are more messages, remove the last one
            $messages->pop();
        }

        // Sort the messages by created_at in ascending order
        $this->messages = collect($this->messages)->merge($messages)->sortBy('created_at')->values();
    }

    #[On('event-client-selected')]
    public function handleClientSelected($clientLineUserId)
    {
        $this->reset(['messages', 'text', 'files', 'allFiles']);
        $this->currentClientLineUserId = $clientLineUserId;
        $this->loadOldMessages();
        $this->dispatch('scroll-to-bottom');
    }

    public function loadNewMessages()
    {
        $lastMessageId = $this->messages->last()->id;
        $clientLineUserId = $this->currentClientLineUserId;
        $newMessages = Message::where(function ($query) use ($clientLineUserId) {
            $query->where('sender_id', $clientLineUserId)
                ->where('organisation_id', auth()->user()->organisation_id);
        })
            ->orWhere(function ($query) use ($clientLineUserId) {
                $query->where('receiver_id', $clientLineUserId)
                    ->where('sender_id', auth()->user()->organisation_id);
            })
            ->where('id', '>', $lastMessageId)
            ->orderBy('created_at', 'desc')
            ->limit($this->limitOfMessages)
            ->get();
        $this->messages = $this->messages->merge($newMessages)->sortBy('created_at');
    }

    public function updatedFiles()
    {
        // Limit the maximum number of upload files to 3
        $count = count($this->allFiles) + count($this->files);
        if ($count > 3) {
            $this->reset('files');
            $this->addError('files', '同時アップロードは３つまでにしてください');
            $this->files = []; // Clear the current selection to allow for new selections
            $this->dispatch('file-uploaded');
            return;
        }

        $this->allFiles = array_merge($this->allFiles, $this->files); // Merge new files with allFiles
        $this->files = []; // Clear the current selection to allow for new selections
        $this->dispatch('file-uploaded');
    }

    public function removeFile($index)
    {
        unset($this->allFiles[$index]);
        $this->allFiles = array_values($this->allFiles); // Re-index the array
    }

    public function postMsg()
    {
        $this->resetValidation();
        Validator::make(
            [
                'text' => $this->text,
                'all_files' => $this->allFiles,
            ],
            [
                'text' => [
                    // Use a custom closure to require "text" if "all_files" is present and not empty
                    function ($attribute, $value, $fail) {
                        if (!empty($this->allFiles) && empty($value)) {
                            $fail('The ' . $attribute . ' field is required when all files are present.');
                        }
                    },
                    'string',
                    'max:1000',
                ],
                'all_files.*' => 'file|max:20480',
            ]
        )->validate();

        $filePathsString = '';
        $imagePathList = [];
        $newMsgList = [];
        $msgReqs = [];

        // upload files
        if (!empty($this->allFiles)) {
            $filesFirstFlag = false;
            foreach ($this->allFiles as $file) {
                $filePath = $file->store('files', 's3');
                if (!str_starts_with($file->getMimeType(), 'image/')) {
                    if ($filesFirstFlag === true) {
                        $filePathsString .= "\n\n";
                    } else {
                        $filesFirstFlag = true;
                    }
                    $originalName = $file->getClientOriginalName();
                    $filePathsString .= $originalName . "\n" . Storage::disk('s3')->url($filePath);
                } else {
                    $imagePathList[] = $filePath;
                }
            }
        }

        // store text
        if ($this->text) {
            $body = app(UtilityService::class)->convertUrlToLink($this->text);
            $newMsgList[] = Message::create([
                'sender_id' => auth()->user()->id,
                'receiver_id' => $this->currentClientLineUserId,
                'organisation_id' => auth()->user()->organisation->id,
                'from_user' => false,
                'body' => $body,
                'type' => 'text',
            ]);
            $msgReqs[] = (new TextMessage(['text' => $this->text]))->setType('text');
        }

        // store image
        if (!empty($imagePathList)) {
            $imageMsgList = [];
            foreach ($imagePathList as $imagePath) {
                $newMsgList[] = Message::create([
                    'sender_id' => auth()->user()->id,
                    'receiver_id' => $this->currentClientLineUserId,
                    'organisation_id' => auth()->user()->organisation->id,
                    'from_user' => false,
                    'path' => $imagePath,
                    'type' => 'image',
                ]);
                $url = Storage::disk('s3')->url($imagePath);
                $msgReqs[] = new ImageMessage([
                    'type' => MessageType::IMAGE,
                    'originalContentUrl' => $url,
                    'previewImageUrl' => $url,
                ]);
            }
        }

        // store filePathsString
        if ($filePathsString) {
            $body = app(UtilityService::class)->convertUrlToLink($filePathsString);
            $newMsgList[] = Message::create([
                'sender_id' => auth()->user()->id,
                'receiver_id' => $this->currentClientLineUserId,
                'organisation_id' => auth()->user()->organisation->id,
                'from_user' => false,
                'body' => $body,
                'type' => 'file',
            ]);
            $msgReqs[] = (new TextMessage(['text' => $filePathsString]))->setType('text');
        }

        // send line message in bulk
        (new LineMessagingApi)->sendMsgInBulk(auth()->user()->id, $this->currentClientLineUserId, auth()->user()->organisation->id, $msgReqs);

        $this->messages = $this->messages->merge($newMsgList);

        $this->reset(['text', 'files', 'allFiles']); // Clear the input fields (text and files
        $this->dispatch('scroll-to-bottom');
    }

    public function render()
    {
        return view('livewire.page.manage-enquiry.manage-message');
    }
}
