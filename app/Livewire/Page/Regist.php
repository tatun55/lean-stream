<?php

namespace App\Livewire\Page;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Laravolt\Avatar\Avatar;

class Regist extends Component
{
    public $remenber = false;
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $authError = '';

    public function regist()
    {
        $this->validate([
            'name' => 'required|string|between:2,32',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
        ], [
            'email.unique' => 'This email is already registered. Please use another email or login.',
        ]);

        try {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);
            auth()->login($user, $this->remenber);
            $this->redirect(route('dashboard'));
        } catch (\Exception $e) {
            $this->authError = '登録失敗: ' . $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.page.regist')
            ->layout('components.layouts.guest');
    }
}
