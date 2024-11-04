<?php

namespace App\Livewire;

use App\Models\Organisation;
use Livewire\Component;

class SelectOrganisation extends Component
{
    public $organisations;
    public $organisationId;

    protected $listeners = ['organisation-updated' => 'fetchOrganisations'];

    // public function change($organisationId)
    // {
    //     // session(['organisation_id' => $organisationId]);
    //     auth()->user()->update(['organisation_id' => $organisationId]);
    // }

    public function updatedOrganisationId()
    {
        auth()->user()->update(['organisation_id' => $this->organisationId]);
        auth()->user()->refresh();
    }

    public function mount()
    {
        $this->organisationId = auth()->user()->organisation_id;
        $this->fetchOrganisations();
    }

    public function fetchOrganisations()
    {
        $this->organisations = Organisation::orderBy('created_at', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.select-organisation');
    }
}
