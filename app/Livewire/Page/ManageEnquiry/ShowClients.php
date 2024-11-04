<?php

namespace App\Livewire\Page\ManageEnquiry;

use App\Models\Message;
use App\Models\Client;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class ShowClients extends Component
{
    use WithPagination;

    public $staffList = [];
    public $openChargerModal = false;
    public $selectedClient = null;
    public $tab = 'all';

    public function showChargerModal($clientId)
    {
        $this->openChargerModal = true;
        $this->selectedClient = Client::where('id', $clientId)->with(['staffInCharge'])->first();
    }

    public function assignStaffInCharge($staffId)
    {
        $this->selectedClient->staffInCharge()->toggle([$staffId]);
        $this->dispatch('notify', content: "変更しました", type: "success");
    }

    public function toggleTab($tab)
    {
        $this->tab = $tab;
    }

    public function mount()
    {
        $this->staffList = User::where('organisation_id', auth()->user()->organisation_id)->get();
    }

    public function render()
    {
        switch ($this->tab) {
            case 'all':
                $clientsPaginator = Client::where('organisation_id', auth()->user()->organisation_id)->paginate(10);
                return view('livewire.page.manage-enquiry.show-clients', [
                    'clientsPaginator' => $clientsPaginator,
                ]);
            case 'new':
                $clientsPaginator =Client::where('organisation_id', auth()->user()->organisation_id)->doesntHave('staffInCharge')->paginate(10);
                return view('livewire.page.manage-enquiry.show-clients', [
                    'clientsPaginator' => $clientsPaginator,
                ]);
            case 'byPerson':
                $clientsPaginator = auth()->user()->clients()->paginate(10);
                return view('livewire.page.manage-enquiry.show-clients', [
                    'clientsPaginator' => $clientsPaginator,
                ]);
        }

    }
}
