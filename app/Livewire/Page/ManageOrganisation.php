<?php

namespace App\Livewire\Page;

use App\Livewire\SelectOrganisation;
use App\Models\LineBot;
use App\Models\Organisation;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class ManageOrganisation extends Component
{
    use WithPagination;

    #[Url(as: 'q', history: true)]
    public $query = '';

    #[Validate('string|in:company,manshion_union,other')]
    public $type = 'company';

    #[Validate('required|between:1,32')]
    public $name = '';

    #[Validate('url|between:1,1024')]
    public $url = '';

    #[Validate('string|size:7|regex:/^[0-9]{7}$/')]
    public $postal_code = '';

    #[Validate('string|max:255')]
    public $address = '';

    #[Validate('string|between:10,15|regex:/^[0-9-]+$/')]
    public $tel = '';

    #[Validate('string|max:1024')]
    public $note = '';

    public $destination = '';

    public $channel_secret = '';

    public $basic_id = '';

    public $access_token = '';

    public function delete($id)
    {
        # check auth
        auth()->user()->can('admin') or abort(403);
        // Organisation::findOrFail($id)->delete();
        Organisation::destroy($id);
        // $this->dispatch('deleted');
        $this->dispatch('notify', content: "削除しました", type: "success");
    }

    public function edit($id, $organisation)
    {
        $this->type = $organisation['type'];
        $this->name = $organisation['name'];
        $this->url = $organisation['url'];
        $this->postal_code = $organisation['postal_code'] ?? '';
        $this->address = $organisation['address'];
        $this->tel = $organisation['tel'];
        $this->note = $organisation['note'];

        $this->validate();

        Organisation::findOrFail($id)->update([
            'type' => $this->type,
            'name' => $this->name,
            'url' => $this->url,
            'postal_code' => $this->postal_code,
            'address' => $this->address,
            'tel' => $this->tel,
            'note' => $this->note,
        ]);
        $this->reset(['type', 'name', 'url', 'postal_code', 'address', 'tel', 'note']);

        $this->dispatch('organisations-updated');
        $this->dispatch('notify', content: "編集しました", type: "success");
    }

    public function lineConnect($id)
    {
        // dd(strlen($this->basic_id));

        $this->validate([
            'destination' => 'required|string|size:33',
            'channel_secret' => 'required|string|size:32',
            'basic_id' => 'required|string|size:9',
            'access_token' => 'required|string|size:172',
        ]);
        LineBot::create([
            'organisation_id' => $id,
            'destination' => $this->destination,
            'channel_secret' => $this->channel_secret,
            'basic_id' => $this->basic_id,
            'access_token' => $this->access_token,
        ]);
        $this->dispatch('line-bot-connected');
        $this->dispatch('notify', content: "連携しました", type: "success");
    }

    public function save()
    {
        $this->validate();

        $organisation = new Organisation();
        $organisation->type = $this->type;
        $organisation->name = $this->name;
        $organisation->url = $this->url;
        $organisation->postal_code = $this->postal_code;
        $organisation->address = $this->address;
        $organisation->tel = $this->tel;
        $organisation->note = $this->note;
        $organisation->save();

        $this->reset(['type', 'name', 'url', 'postal_code', 'address', 'tel', 'note']);
        $this->dispatch('organisations-updated');
        $this->dispatch('organisations-updated')->to(SelectOrganisation::class);
        $this->dispatch('notify', content: "保存しました", type: "success");
    }

    public function resetProperty()
    {
        $this->reset(['type', 'name', 'url', 'postal_code', 'address', 'tel', 'note']);
        $this->resetErrorBag();
    }

    public function render()
    {
        $q = Organisation::orderBy('created_at', 'asc');
        $this->query && $q->where('name', 'like', "%{$this->query}%");
        $orgPagenator = $q->with('line_bot')->paginate(10);

        return view('livewire.page.manage-organisation', [
            'orgPagenator' => $orgPagenator,
        ]);
    }
}
