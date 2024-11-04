<?php

namespace App\Livewire;

use Livewire\Component;

class LogoutLink extends Component
{
    public function logout()
    {
        dd('logout');
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('welcome');
    }

    public function render()
    {
        return view('livewire.logout-link');
    }
}
