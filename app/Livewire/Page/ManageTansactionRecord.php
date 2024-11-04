<?php

namespace App\Livewire\Page;

use App\Models\BankAccount;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use App\Models\TransactionRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class ManageTansactionRecord extends Component
{
    use WithPagination;

    // Input 
    #[Validate('nullable|string')]
    public $transactionRecordId = null;
    #[Validate('date')]
    public $transactionDate;
    #[Validate('required|string|in:deposit,withdrawal,other')]
    public $type = 'deposit';
    #[Validate('required|numeric')]
    public $amount;
    #[Validate('nullable|string')]
    public $purpose;
    #[Validate('nullable|string')]
    public $note;
    #[Validate('required|numeric')]
    public $bankAccountId;
    #[Validate('nullable|date')]
    public $paymentDueDate;
    #[Validate('nullable|boolean')]
    public $paid = false;

    // Recurring Option
    #[Validate('required|string|in:none,daily,weekly,monthly,yearly')]
    public $recurringInterval = 'none';
    public $repeatCount = 2;

    // Others
    public $users;
    public $filter = [
        'minTransactionDate' => null,
        'maxTransactionDate' => null,
        'type' => null,
        'minAmount' => null,
        'maxAmount' => null,
        'userId' => null,
        'purpose' => null,
        'note' => null,
        'minPaymentDueDate' => null,
        'maxPaymentDueDate' => null,
        'paidStatus' => null,
    ];
    public $banks;
    public $transactionType = 'all';

    private function incrementDate($date, $interval)
    {
        return match ($interval) {
            'daily' => $date->addDay(),
            'weekly' => $date->addWeek(),
            'monthly' => $date->addMonth(),
            'yearly' => $date->addYear(),
            default => $date,
        };
    }

    public function store()
    {
        // TODO: Validationメッセージ https://livewire.laravel.com/docs/validation
        $this->validate();

        if ($this->recurringInterval !== 'none') {
            $this->validate([
                'repeatCount' => 'required|integer|min:1'
            ]);

            $currentDate = Carbon::parse($this->transactionDate);
            for ($i = 0; $i < $this->repeatCount; $i++) {
                TransactionRecord::create([
                    'transaction_date' => $currentDate,
                    'type' => $this->type,
                    'amount' => $this->amount,
                    'purpose' => $this->purpose,
                    'note' => $this->note,
                    'payment_due_date' => $this->type === 'withdrawal' && $this->paymentDueDate ? new Carbon($this->paymentDueDate) : null,
                    'paid' => $this->type === 'withdrawal' ? $this->paid : null,
                    'user_id' => Auth::id(),
                ]);

                $currentDate = $this->incrementDate($currentDate, $this->recurringInterval);
            }
        } else {
            $transactionRecord = new TransactionRecord([
                'transaction_date' => $this->transactionDate,
                'type' => $this->type,
                'amount' => $this->amount,
                'purpose' => $this->purpose,
                'note' => $this->note,
                'payment_due_date' => $this->type === 'withdrawal' && $this->paymentDueDate ? new Carbon($this->paymentDueDate) : null,
                'paid' => $this->type === 'withdrawal' ? $this->paid : null,
                'user_id' => Auth::id(),
                'organisation_id' => Auth::user()->organisation_id,
                'bank_account_id' => $this->bankAccountId,
            ]);
            $transactionRecord->save();
        }

        $this->resetInputFields();
        $this->reset(['recurringInterval', 'repeatCount']);
        $this->dispatch('close-create-modal');
        $this->dispatch('notify', content: '保存しました', type: 'success');
    }

    public function edit($id)
    {
        $record = TransactionRecord::findOrFail($id);
        $this->transactionRecordId = $id;
        $this->transactionDate = $record->transaction_date->format('Y-m-d');
        $this->type = $record->type;
        $this->amount = $record->amount;
        $this->purpose = $record->purpose;
        $this->note = $record->note;
        $this->paymentDueDate = $record->payment_due_date ? $record->payment_due_date->format('Y-m-d') : null;
        $this->paid = $record->paid;
    }

    public function update($id)
    {
        $this->validate();
        $transactionRecord = TransactionRecord::findOrFail($id);

        $transactionRecord->update([
            'transaction_date' => new Carbon($this->transactionDate),
            'type' => $this->type,
            'amount' => $this->amount,
            'purpose' => $this->purpose,
            'note' => $this->note,
            'payment_due_date' => $this->type === 'withdrawal' && $this->paymentDueDate ? new Carbon($this->paymentDueDate) : null,
            'paid' => $this->type === 'withdrawal' ? $this->paid : null,
        ]);

        $this->resetInputFields();

        $this->dispatch('close-edit-modal');
        $this->dispatch('notify', content: '更新しました', type: 'success');
    }

    public function delete($id)
    {
        TransactionRecord::find($id)->delete();
        $this->dispatch('close-delete-modal');
        $this->dispatch('notify', content: "削除しました", type: "success");
    }


    public function resetInputFields()
    {
        $this->reset(['transactionRecordId', 'transactionDate', 'type', 'amount', 'purpose', 'note', 'paymentDueDate', 'paid']);
        $this->resetValidation();
    }

    public function filterRecords()
    {
        $this->resetPage();
    }

    public function resetFilter()
    {
        $this->reset('filter');
        $this->resetPage();
    }

    public function print()
    {
        $query = TransactionRecord::query();
        $query->when($this->transactionType !== 'all', fn ($q) => $q->whereHas('bank_account', fn ($q2) => $q2->where('transaction_type', $this->transactionType)));
        $query->when($this->filter['minTransactionDate'], fn ($q) => $q->whereDate('transaction_date', '>=', $this->filter['minTransactionDate']));
        $query->when($this->filter['maxTransactionDate'], fn ($q) => $q->whereDate('transaction_date', '<=', $this->filter['maxTransactionDate']));
        $query->when($this->filter['type'], fn ($q) => $q->where('type', $this->filter['type']));
        $query->when($this->filter['minAmount'], fn ($q) => $q->where('amount', '>=', $this->filter['minAmount']));
        $query->when($this->filter['maxAmount'], fn ($q) => $q->where('amount', '<=', $this->filter['maxAmount']));
        $query->when($this->filter['userId'], fn ($q) => $q->where('user_id', $this->filter['userId']));
        $query->when($this->filter['purpose'], fn ($q) => $q->where('purpose', 'like', '%' . $this->filter['purpose'] . '%'));
        $query->when($this->filter['note'], fn ($q) => $q->where('note', 'like', '%' . $this->filter['note'] . '%'));
        $query->when($this->filter['minPaymentDueDate'], fn ($q) => $q->whereDate('payment_due_date', '>=', $this->filter['minPaymentDueDate']));
        $query->when($this->filter['maxPaymentDueDate'], fn ($q) => $q->whereDate('payment_due_date', '<=', $this->filter['maxPaymentDueDate']));
        $query->when($this->filter['paidStatus'] !== null, fn ($q) => $q->where('paid', $this->filter['paidStatus']));
        $transactionRecords = $query->orderBy('transaction_date', 'asc')->orderBy('created_at', 'asc')->get();
        $totalAmount = 0;
        foreach ($transactionRecords as $transactionRecord) {
            if ($transactionRecord->type === 'deposit') {
                $totalAmount += $transactionRecord->amount;
            } elseif($transactionRecord->type === 'withdrawal') {
                $totalAmount -= $transactionRecord->amount;
            }
        }

        $pdf = PDF::loadView('pdfs.transactions-001', compact('transactionRecords', 'totalAmount'));
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'name.pdf');
    }

    public function mount()
    {
        $this->users = User::select('users.id', 'users.name')
            ->join('transaction_records', 'transaction_records.user_id', '=', 'users.id')
            ->distinct()
            ->get();
        $this->banks = BankAccount::where('organisation_id', auth()->user()->organisation_id)->get();
        $this->bankAccountId = $this->banks->first()?->id;
    }

    public function render()
    {
        $query = TransactionRecord::query();

        $query->when($this->transactionType !== 'all', fn ($q) => $q->whereHas('bank_account', fn ($q2) => $q2->where('transaction_type', $this->transactionType)));
        $query->when($this->filter['minTransactionDate'], fn ($q) => $q->whereDate('transaction_date', '>=', $this->filter['minTransactionDate']));
        $query->when($this->filter['maxTransactionDate'], fn ($q) => $q->whereDate('transaction_date', '<=', $this->filter['maxTransactionDate']));
        $query->when($this->filter['type'], fn ($q) => $q->where('type', $this->filter['type']));
        $query->when($this->filter['minAmount'], fn ($q) => $q->where('amount', '>=', $this->filter['minAmount']));
        $query->when($this->filter['maxAmount'], fn ($q) => $q->where('amount', '<=', $this->filter['maxAmount']));
        $query->when($this->filter['userId'], fn ($q) => $q->where('user_id', $this->filter['userId']));
        $query->when($this->filter['purpose'], fn ($q) => $q->where('purpose', 'like', '%' . $this->filter['purpose'] . '%'));
        $query->when($this->filter['note'], fn ($q) => $q->where('note', 'like', '%' . $this->filter['note'] . '%'));
        $query->when($this->filter['minPaymentDueDate'], fn ($q) => $q->whereDate('payment_due_date', '>=', $this->filter['minPaymentDueDate']));
        $query->when($this->filter['maxPaymentDueDate'], fn ($q) => $q->whereDate('payment_due_date', '<=', $this->filter['maxPaymentDueDate']));
        $query->when($this->filter['paidStatus'] !== null, fn ($q) => $q->where('paid', $this->filter['paidStatus']));

        $transactionRecords = $query->orderBy('transaction_date', 'desc')->orderBy('created_at', 'desc')->paginate(10);
        $banks = $this->banks;
        return view('livewire.page.manage-transaction-record', compact('transactionRecords', 'banks'));
    }
}
