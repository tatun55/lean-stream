<?php

namespace App\Livewire\Page;

use Livewire\Component;
use Illuminate\Support\Facades\RateLimiter;

class Login extends Component
{
    public $remenber = false;
    public $email = '';
    public $password = '';
    public $authError = '';

    public function login()
    {
        $rateLimitKey = 'login-attempt|' . request()->ip();
        $maxAttempts = 5;
        $decaySeconds = 1;

        if (RateLimiter::tooManyAttempts($rateLimitKey, $maxAttempts)) {
            $this->authError = 'ログイン試行回数が上限に達しました。しばらく時間をおいてから再度お試しください。';
            return;
        }

        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt([
            'email' => $this->email,
            'password' => $this->password,
        ], $this->remenber)) {
            session()->regenerate();
            RateLimiter::clear($rateLimitKey);
            return redirect()->route('manage.enquiry');
        }

        RateLimiter::hit($rateLimitKey, $decaySeconds);
        $this->authError = '認証できませんでした。';
        return;
    }

    public function render()
    {
        return view('livewire.page.login')
            ->layout('components.layouts.guest');
    }
}
