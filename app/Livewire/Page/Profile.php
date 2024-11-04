<?php

namespace App\Livewire\Page;

use App\Models\User;
use App\Services\GenerateAvatar;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class Profile extends Component
{

    use WithFileUploads;

    public User $user;
    public $name = '';
    public $email = '';
    public $avatar = '';
    public $new_avatar = '';
    public $message = '';

    public function mount()
    {
        $this->user = auth()->user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->avatar = asset($this->user->avatar);
        $this->message = $this->user->message;
    }

    public function delete()
    {
        if ($this->new_avatar) {
            $this->new_avatar = null;
        } else {
            Storage::delete($this->avatar);
            $this->avatar = 'img/default-avatar.png';
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|between:2,32',
            'email' => 'required|email|unique:users,email,' . $this->user->id . ',id',
            'new_avatar' => 'image|max:10240',
            'message' => 'string|max:144',
        ]);

        if ($this->new_avatar) { // 画像がアップロードされた場合
            $filename = (string) Str::uuid() . '.png';
            $this->new_avatar->storeAs('public/avatars/', $filename);
            $this->user->avatar = '/avatars/' . $filename;
        } else { // 画像がアップロードされなかった場合
            if ($this->user->avatar !== $this->avatar) { // 画像が変更された場合
                $this->user->avatar = $this->avatar;
            } else { // 画像が変更されなかった場合
                if ($this->user->name !== $this->name) { // 名前が変更された場合
                    $this->user->avatar = '/avatars/' . (new GenerateAvatar)->generate($this->name);
                    $this->avatar = $this->user->avatar;
                }
            }
        }

        $this->user->name = $this->name;
        $this->user->email = $this->email;
        $this->user->message = $this->message;
        $this->user->save();
    }

    public function render()
    {
        return view('livewire.page.profile')
            ->layout('components.layouts.app');
    }
}
