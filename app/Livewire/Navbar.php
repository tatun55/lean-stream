<?php

namespace App\Livewire;

use App\Models\Organisation;
use Livewire\Component;

class Navbar extends Component
{
    public $organisations;
    public $organisationId;

    protected $listeners = ['organisation-updated' => 'fetchOrganisations'];

    public function updatedOrganisationId()
    {
        auth()->user()->update(['organisation_id' => $this->organisationId]);
        $this->dispatch('reloadPage');
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

    public function logout()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('welcome');
    }

    public function render()
    {
        return view('livewire.navbar');
    }
}
