<?php

namespace App\Livewire\Page\ManageEnquiry;

use App\Models\Remark;
use App\Models\Client;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use App\Services\UtilityService;

class ManageRemark extends Component
{

    use WithFileUploads;

    public $remarks = [];
    public $text = '';
    public $files = [];
    public $allFiles = []; // Additional array to track all files
    public $currentClientLineUserId = null;
    public $hasMoreRemarks = false;
    public $limitOfMessages = 20;

    #[On('event-client-selected')]
    public function handleClientSelected($clientLineUserId)
    {
        $this->currentClientLineUserId = $clientLineUserId;
        $this->remarks = Remark::where(['sender_id' => $clientLineUserId, 'organisation_id' => auth()->user()->organisation_id])->orWhere(['receiver_id' => $clientLineUserId, 'sender_id' => auth()->user()->organisation_id])->get();
        $this->dispatch('scroll-to-bottom-remark');
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

    public function storeRemark()
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
        $newRmkList = [];

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
            $newRmkList[] = Remark::create([
                'sender_id' => auth()->user()->id,
                'receiver_id' => $this->currentClientLineUserId,
                'organisation_id' => auth()->user()->organisation->id,
                'from_user' => false,
                'body' => $body,
                'type' => 'text',
            ]);
        }

        // store image
        if (!empty($imagePathList)) {
            $imageRmkList = [];
            foreach ($imagePathList as $imagePath) {
                $newRmkList[] = Remark::create([
                    'sender_id' => auth()->user()->id,
                    'receiver_id' => $this->currentClientLineUserId,
                    'organisation_id' => auth()->user()->organisation->id,
                    'from_user' => false,
                    'path' => $imagePath,
                    'type' => 'image',
                ]);
                $url = Storage::disk('s3')->url($imagePath);
            }
        }

        // store filePathsString
        if ($filePathsString) {
            $body = app(UtilityService::class)->convertUrlToLink($filePathsString);
            $newRmkList[] = Remark::create([
                'sender_id' => auth()->user()->id,
                'receiver_id' => $this->currentClientLineUserId,
                'organisation_id' => auth()->user()->organisation->id,
                'from_user' => false,
                'body' => $body,
                'type' => 'file',
            ]);
        }

        $this->remarks = $this->remarks->merge($newRmkList);

        $this->reset(['text', 'files', 'allFiles']); // Clear the input fields (text and files
        $this->dispatch('scroll-to-bottom');
    }

    public function render()
    {
        return view('livewire.page.manage-enquiry.manage-remark');
    }
}
