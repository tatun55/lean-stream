<?php

namespace App\Livewire\Page;

use App\Models\Message;
use App\Models\User;
use Livewire\Component;

class ManageEnquiry extends Component
{
    public function handleClientSelect($clientId)
    {
        $this->text = '';
        $this->resetValidation();
        $this->messages = Message::where('sender_id', $clientId)->orWhere('receiver_id', $clientId)->get();
        $this->dispatch(['scroll-to-bottom-of-message', 'scroll-to-bottom-of-remark']);
    }

    public function render()
    {
        return view('livewire.page.manage-enquiry');
    }
}
