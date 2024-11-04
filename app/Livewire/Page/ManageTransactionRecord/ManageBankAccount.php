<?php

namespace App\Livewire\Page\ManageTransactionRecord;

use App\Models\BankAccount;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class ManageBankAccount extends Component
{
    public $bankAccounts = [];
    public $newBankAccount = [
        'transaction_type' => 'general', // general or special
        'management_name' => null,
        'note' => null,
        'bank_name' => null,
        'branch_name' => null,
        'account_type' => null,
        'account_number' => null,
        'account_holder' => null,
    ];
    public $currentBankAccount = [];

    public function storeBank()
    {
        $this->resetValidation();
        $validatedData = Validator::make($this->newBankAccount, [
            'transaction_type' => 'required|in:general,special',
            'management_name' => 'required|string|max:255',
            'note' => 'nullable|string|max:1000',
            'bank_name' => 'nullable|string|max:255',
            'branch_name' => 'nullable|string|max:255',
            'account_type' => 'nullable|in:savings,checking,other',
            'account_number' => 'nullable|string|max:50',
            'account_holder' => 'nullable|string|max:255',
        ])->validate();

        $validatedData['organisation_id'] = auth()->user()->organisation_id;
        $createdBankAccount = BankAccount::create($validatedData);
        $this->bankAccounts->prepend($createdBankAccount);

        $this->reset(['newBankAccount']);
        $this->dispatch('close-create-bank-acount-modal');
        $this->dispatch('notify', content: '保存しました', type: 'success');
    }

    public function updateBank()
    {
        $this->resetValidation();
        // dd($this->currentBankAccount);
        $validatedData = Validator::make($this->currentBankAccount, [
            'transaction_type' => 'required|in:general,special',
            'management_name' => 'required|string|max:255',
            'note' => 'nullable|string|max:1000',
            'bank_name' => 'nullable|string|max:255',
            'branch_name' => 'nullable|string|max:255',
            'account_type' => 'nullable|in:savings,checking,other',
            'account_number' => 'nullable|string|max:50',
            'account_holder' => 'nullable|string|max:255',
        ])->validate();

        $validatedData['organisation_id'] = auth()->user()->organisation_id;
        BankAccount::find($this->currentBankAccount['id'])->update($validatedData);

        $this->reset(['currentBankAccount']);
        $this->dispatch('close-edit-bank-acount-modal');
        $this->dispatch('notify', content: '更新しました', type: 'success');
    }

    public function deleteBank($id)
    {
        BankAccount::destroy($id);
        $this->bankAccounts = $this->bankAccounts->reject(function ($bankAccount) use ($id) {
            return $bankAccount->id == $id;
        });
        $this->dispatch('close-delete-bank-modal');
        $this->dispatch('notify', content: '削除しました', type: 'success');
    }

    public function resetInputFields()
    {
        $this->resetValidation();
        $this->reset(['newBankAccount']);
    }

    public function getCurrentAccount($bankAccountId)
    {
        $this->currentBankAccount = $this->bankAccounts->firstWhere('id', $bankAccountId)->toArray();
        $this->dispatch('show-edit-bank-account-modal');
    }

    public function mount()
    {
        $this->bankAccounts = BankAccount::where('organisation_id', auth()->user()->organisation_id)->orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.page.manage-transaction-record.manage-bank-account');
    }
}
