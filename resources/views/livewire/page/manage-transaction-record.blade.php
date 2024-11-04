<div class="flex w-full justify-center px-2" x-data="{ transactions: [] }" x-init="transactions = @js($transactionRecords->getCollection()->keyBy('id'));
banks = @js($banks);">

    <div x-data="{ isShowTransactionRecord: true }" class="w-full max-w-screen-xl pt-12">

        <div x-data="{ activeTab: 1 }" role="tablist" class="tabs tabs-bordered font-semibold w-full max-w-screen-sm">
            <button @click="activeTab = 1; isShowTransactionRecord = true; $dispatch('hide-bank-account');" :aria-selected="activeTab === 1" role="tab" class="tab text-xl h-12" :class="{ 'tab-active bg-white': activeTab === 1 }" aria-label="Tab 1">会計管理</button>
            <button @click="activeTab = 2; isShowTransactionRecord = false; $dispatch('show-bank-account');" :aria-selected="activeTab === 2" role="tab" class="tab text-xl h-12" :class="{ 'tab-active bg-white': activeTab === 2 }" aria-label="Tab 2">口座管理</button>
        </div>

        {{-- transaction management --}}
        <div x-show="isShowTransactionRecord">

            <div class="mt-10 mb-8 flex items-center justify-between">
                <div class="flex gap-x-3">
                    <button @click="$dispatch('open-create-modal')" class="btn btn-neutral btn-wide">取引を登録</button>
                    <button @click="$wire.print()" class="btn btn-info !opacity-85 btn-wide">書類の出力・プリント</button>
                </div>
            </div>

            <div x-data="{ activeTab: 1 }" role="tablist" class="tabs tabs-boxed mb-6 font-semibold">
                <button @click="activeTab = 1; $wire.set('transactionType', 'all');" :aria-selected="activeTab === 1" role="tab" class="tab !h-9" :class="{ 'bg-white shadow': activeTab === 1 }" aria-label="Tab 1">一般会計・特別会計</button>
                <button @click="activeTab = 2; $wire.set('transactionType', 'general');" :aria-selected="activeTab === 2" role="tab" class="tab !h-9" :class="{ 'bg-white shadow': activeTab === 2 }" aria-label="Tab 2">一般会計</button>
                <button @click="activeTab = 3; $wire.set('transactionType', 'special')" :aria-selected="activeTab === 3" role="tab" class="tab !h-9" :class="{ 'bg-white shadow': activeTab === 3 }" aria-label="Tab 3">特別会計</button>
            </div>


            <div class="flex justify-between w-full relative mb-4" x-data="{ open: false }">

                {{-- 期間 --}}
                <div x-data="{
                    term: 'all',
                    thisMonth: new Date().getMonth() + 1,
                    thisYear: new Date().getFullYear(),
                    lastYear: new Date().getFullYear() - 1,
                    months: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
                    selectTerm(term) {
                        this.term = term;
                        let minTransactionDate = null;
                        let maxTransactionDate = null;
                
                        if (term === 'all') {
                            minTransactionDate = null;
                            maxTransactionDate = null;
                        } else if (term === 'thisMonth') {
                            minTransactionDate = new Date(this.thisYear, this.thisMonth - 1, 1).toISOString().split('T')[0];
                            maxTransactionDate = new Date(this.thisYear, this.thisMonth, 0).toISOString().split('T')[0];
                        } else if (term === 'lastMonth') {
                            let lastMonth = this.thisMonth - 1;
                            let year = this.thisYear;
                            if (lastMonth === 0) {
                                lastMonth = 12;
                                year = this.lastYear;
                            }
                            minTransactionDate = new Date(year, lastMonth - 1, 1).toISOString().split('T')[0];
                            maxTransactionDate = new Date(year, lastMonth, 0).toISOString().split('T')[0];
                        } else if (term === 'thisYear') {
                            minTransactionDate = new Date(this.thisYear, 0, 1).toISOString().split('T')[0];
                            maxTransactionDate = new Date(this.thisYear, 11, 31).toISOString().split('T')[0];
                        } else if (term === 'lastYear') {
                            minTransactionDate = new Date(this.lastYear, 0, 1).toISOString().split('T')[0];
                            maxTransactionDate = new Date(this.lastYear, 11, 31).toISOString().split('T')[0];
                        }
                
                        $wire.set('filter.minTransactionDate', minTransactionDate);
                        $wire.set('filter.maxTransactionDate', maxTransactionDate);
                        $wire.call('filterRecords');
                    },
                    termLabel(term) {
                        if (term === 'thisMonth') {
                            return `(${this.thisYear}.${this.thisMonth})`;
                        } else if (term === 'lastMonth') {
                            let lastMonth = this.thisMonth - 1;
                            let year = this.thisYear;
                            if (lastMonth === 0) {
                                lastMonth = 12;
                                year = this.lastYear;
                            }
                            return `(${year}.${lastMonth})`;
                        } else if (term === 'thisYear') {
                            return `(${this.thisYear})`;
                        } else if (term === 'lastYear') {
                            return `(${this.lastYear})`;
                        }
                        return '';
                    }
                }" class="flex items-center gap-3">
                    <label for="terms-all" class="flex items-center gap-2">
                        <input id="terms-all" type="radio" name="term" class="radio mr-1" @click="selectTerm('all')" x-model="term" value="all" />全期間
                    </label>
                    <label for="term-this-month" class="flex items-center gap-2">
                        <input id="term-this-month" type="radio" name="term" class="radio mr-1" @click="selectTerm('thisMonth')" x-model="term" value="thisMonth" />今月 <span x-text="termLabel('thisMonth')"></span>
                    </label>
                    <label for="term-last-month" class="flex items-center gap-2">
                        <input id="term-last-month" type="radio" name="term" class="radio mr-1" @click="selectTerm('lastMonth')" x-model="term" value="lastMonth" />先月 <span x-text="termLabel('lastMonth')"></span>
                    </label>
                    <label for="term-this-year" class="flex items-center gap-2">
                        <input id="term-this-year" type="radio" name="term" class="radio mr-1" @click="selectTerm('thisYear')" x-model="term" value="thisYear" />今年 <span x-text="termLabel('thisYear')"></span>
                    </label>
                    <label for="term-last-year" class="flex items-center gap-2">
                        <input id="term-last-year" type="radio" name="term" class="radio mr-1" @click="selectTerm('lastYear')" x-model="term" value="lastYear" />去年 <span x-text="termLabel('lastYear')"></span>
                    </label>
                </div>

                {{-- 詳細条件 --}}
                <div>
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-sm btn-ghost" @click="open = !open">
                            <svg class="w-5" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            詳細条件
                        </div>
                    </div>
                    <ul x-show="open" x-transition @click.outside="open = false" tabindex="0" class="dropdown-content border z-[1] menu p-4 shadow bg-base-100 rounded-box w-[99%] absolute left-[1%] top-8">
                        <div class="mb-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="label">
                                        <span class="label-text">取引日</span>
                                    </label>
                                    <div class="flex items-center gap-2">
                                        <input type="date" wire:model="filter.minTransactionDate" placeholder="最小取引日" class="input input-bordered w-full">
                                        <span>〜</span>
                                        <input type="date" wire:model="filter.maxTransactionDate" placeholder="最大取引日" class="input input-bordered w-full">
                                    </div>
                                </div>
                                <div>
                                    <label class="label">
                                        <span class="label-text">取引タイプ</span>
                                    </label>
                                    <select wire:model="filter.type" class="select select-bordered w-full">
                                        <option value="">すべてのタイプ</option>
                                        <option value="deposit">入金</option>
                                        <option value="withdrawal">出金</option>
                                        <option value="other">その他</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="label">
                                        <span class="label-text">金額</span>
                                    </label>
                                    <div class="flex items-center gap-2">
                                        <input type="number" wire:model="filter.minAmount" placeholder="最小金額" class="input input-bordered w-full">
                                        <span>〜</span>
                                        <input type="number" wire:model="filter.maxAmount" placeholder="最大金額" class="input input-bordered w-full">
                                    </div>
                                </div>
                                <div>
                                    <label class="label">
                                        <span class="label-text">登録者</span>
                                    </label>
                                    <select wire:model="filter.userId" class="select select-bordered w-full">
                                        <option value="">すべての登録者</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="label">
                                        <span class="label-text">科目</span>
                                    </label>
                                    <input type="text" wire:model="filter.purpose" placeholder="科目" class="input input-bordered w-full">
                                </div>
                                <div>
                                    <label class="label">
                                        <span class="label-text">備考</span>
                                    </label>
                                    <input type="text" wire:model="filter.note" placeholder="備考" class="input input-bordered w-full">
                                </div>
                                <div>
                                    <label class="label">
                                        <span class="label-text">支払い期限</span>
                                    </label>
                                    <div class="flex items-center gap-2">
                                        <input type="date" wire:model="filter.minPaymentDueDate" placeholder="最小支払い期限日" class="input input-bordered w-full">
                                        <span>〜</span>
                                        <input type="date" wire:model="filter.maxPaymentDueDate" placeholder="最大支払い期限日" class="input input-bordered w-full">
                                    </div>
                                </div>
                                <div>
                                    <label class="label">
                                        <span class="label-text">支払い済みステータス</span>
                                    </label>
                                    <select wire:model="filter.paidStatus" class="select select-bordered w-full">
                                        <option value="">すべて</option>
                                        <option value="1">支払済み</option>
                                        <option value="0">未払い</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-4 flex justify-end gap-4">
                                <button x-on:click="open = false; $wire.resetFilter();" class="btn btn-ghost">条件をリセット</button>
                                <button x-on:click="open = false; $wire.filterRecords();" class="btn btn-neutral">条件を適応</button>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>

            <!-- Transaction Records Table -->
            <div class="overflow-x-auto">
                <table class="table mb-12 w-full bg-base-100 p-2 shadow">
                    <thead>
                        <tr class="text-center">
                            <th>取引日</th>
                            <th>取引口座</th>
                            <th>取引タイプ</th>
                            <th>金額</th>
                            <th>登録者</th>
                            <th>科目</th>
                            <th>支払い期限</th>
                            <th>支払い済み</th>
                            <th>メニュー</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactionRecords as $record)
                            <tr wire:key='{{ $record->id }}' @click="$dispatch('open-detail-modal', '{{ $record->id }}')" class="text-center cursor-pointer hover:bg-gray-100">
                                <td>{{ $record->transaction_date->format('Y.m.d') }}</td>
                                <td>{{ $record->bank_account->management_name }}</td>
                                <td>{{ $record->type_name }}</td>
                                <td>{{ number_format($record->amount) }}</td>
                                <td>{{ $record->user->name }}</td>
                                <td>{{ $record->purpose }}</td>
                                <td>
                                    @if ($record->type === 'withdrawal')
                                        {{ $record->payment_due_date ? $record->payment_due_date->format('Y.m.d') : '未入力' }}
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>
                                    @if ($record->type === 'withdrawal')
                                        {{ $record->paid ? 'はい' : 'いいえ' }}
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown-left dropdown" @click.stop>
                                        <button tabindex="0" class="btn btn-square btn-ghost btn-sm m-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5 stroke-current" fill="none" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z">
                                                </path>
                                            </svg>
                                        </button>
                                        <ul tabindex="0" class="menu dropdown-content z-50 w-52 rounded-box bg-base-100 p-2 shadow">
                                            <li>
                                                <button @click="$dispatch('open-edit-modal', '{{ $record->id }}')" class="flex items-center gap-2">
                                                    <svg class="mb-1 w-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10">
                                                        </path>
                                                    </svg>
                                                    編集
                                                </button>
                                            </li>
                                            <li>
                                                <button @click="$dispatch('open-delete-modal', '{{ $record->id }}')" class="flex items-center gap-2">
                                                    <svg class="mb-0.5 w-5 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09 2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0">
                                                        </path>
                                                    </svg>
                                                    削除
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">取引がありません</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <x-pagination :paginator="$transactionRecords" template='simple-daisy-ui' color="neutral" />
            </div>

        </div>

        {{-- bank management --}}
        <livewire:page.manage-transaction-record.manage-bank-account />

    </div>

    <!-- Detail Transaction Modal -->
    <div x-data="{ showDetailModal: false, transactionRecordId: null }" @open-detail-modal.window="showDetailModal = true; transactionRecordId = $event.detail;" @close-detail-modal.window="showDetailModal = false; transactionRecordId = null" @keydown.escape.window="showDetailModal = false; transactionRecordId = null">

        <template x-if="transactionRecordId !== null">
            <div x-show="showDetailModal" class="fixed inset-0 z-10 overflow-y-auto" aria-modal="true" role="dialog">
                <!-- Overlay -->
                <div class="fixed inset-0 bg-black bg-opacity-50" @click="showDetailModal = false; transactionRecordId = null"></div>

                <!-- Panel -->
                <div class="flex min-h-screen items-center justify-center p-4">
                    <div class="modal-box w-11/12 max-w-2xl" @click.stop>
                        <!-- Title -->
                        <h2 class="text-2xl font-bold">取引詳細条件</h2>
                        <!-- Content -->
                        <div class="mt-4 flex flex-col gap-3">
                            <div class="form-control">
                                <label class="label">取引日</label>
                                <p class="rounded bg-gray-100 p-4" x-text="new Date(transactions[transactionRecordId].transaction_date).toLocaleDateString('ja-JP')">
                                </p>
                            </div>

                            <div class="form-control">
                                <label class="label">取引タイプ</label>
                                <p class="rounded bg-gray-100 p-4" x-text="transactions[transactionRecordId].type_name">
                                </p>
                            </div>

                            <div class="form-control">
                                <label class="label">金額</label>
                                <p class="rounded bg-gray-100 p-4" x-text="new Intl.NumberFormat('ja-JP').format(transactions[transactionRecordId].amount)">
                                </p>
                            </div>

                            <div class="form-control">
                                <label class="label">科目</label>
                                <p class="rounded bg-gray-100 p-4" x-text="transactions[transactionRecordId].purpose">
                                </p>
                            </div>

                            <div class="form-control">
                                <label class="label">備考</label>
                                <p class="rounded bg-gray-100 p-4" x-text="transactions[transactionRecordId].note">
                                </p>
                            </div>

                            <div x-show="transactions[transactionRecordId].type === 'withdrawal'">
                                <label class="label">支払い期限日</label>
                                <p class="rounded bg-gray-100 p-4" x-text="new Date(transactions[transactionRecordId].payment_due_date).toLocaleDateString('ja-JP')">
                                </p>
                            </div>

                            <div x-show="transactions[transactionRecordId].type === 'withdrawal'">
                                <label class="label">支払い済み</label>
                                <div class="toggle-switch">
                                    <input type="checkbox" :checked="transactions[transactionRecordId].paid" :class="{
                                        'bg-blue-500': transactions[transactionRecordId].paid,
                                        'bg-gray-200': !
                                            transactions[transactionRecordId].paid
                                    }" class="toggle toggle-primary cursor-pointer" style="pointer-events: none;">
                                </div>
                            </div>
                        </div>
                        <!-- Buttons -->
                        <div class="mt-8 flex justify-between">
                            <button @click="showDetailModal = false" class="btn btn-ghost">閉じる</button>
                            <button @click="$dispatch('open-edit-modal', transactionRecordId); showDetailModal = false;" class="btn btn-neutral">編集する</button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- New Transaction Modal -->
    <div x-data="{ showCreateModal: false, type: @entangle('type') }" @open-create-modal.window="showCreateModal = true" @close-create-modal.window="showCreateModal=false" @keydown.escape.window="showCreateModal = false">
        <div x-show="showCreateModal" style="display: none" @keydown.escape.prevent.stop="showCreateModal = false" role="dialog" aria-modal="true" class="fixed inset-0 z-10 overflow-y-auto">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-black bg-opacity-50" @click="showCreateModal = false">
            </div>

            <!-- Panel -->
            <form wire:submit="store" @click="showCreateModal = false" x-transition class="relative flex min-h-screen items-center justify-center p-4">
                <div @click.stop x-trap.noscroll.inert="showCreateModal" class="modal-box w-11/12 max-w-2xl">
                    <!-- Title -->
                    <h2 class="text-2xl font-bold">新規会計を追加<span class="ml-2 text-base text-error/70">*</span> <span class="text-base text-base-content/70">は必須</span></h2>

                    <!-- Content -->
                    <div class="mt-4 flex flex-col gap-3">
                        <div class="form-control">
                            <label for=transactionDate" class="label">
                                <span>取引日<span class="text-base text-error/70">*</span></span>
                            </label>
                            <input type="date" wire:model.defer="transactionDate" id="transactionDate" class="input input-bordered">
                            @error('transactionDate')
                                <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label" for="bank_account">
                                <span>口座<span class="text-base text-error/70">*</span></span>
                            </label>
                            <select wire:model="bankAccountId" class="select select-bordered" id="bank_account">
                                <option selected disabled>選択してください</option>
                                <template x-for="bank in banks" :key="bank.id">
                                    <option x-text="bank.management_name" :value="bank.id"></option>
                                </template>
                            </select>
                            @error('bankAccountId')
                                <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label" for="type">
                                <span>取引タイプ<span class="text-base text-error/70">*</span></span>
                            </label>
                            <select wire:model="type" class="select select-bordered" id="type">
                                <option value="deposit">入金</option>
                                <option value="withdrawal">出金</option>
                                <option value="other">その他</option>
                            </select>
                            @error('type')
                                <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label" for="amount">
                                <span>金額<span class="text-base text-error/70">*</span></span>
                            </label>
                            <input wire:model="amount" type="number" class="input input-bordered" id="amount">
                            @error('amount')
                                <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label" for="purpose">科目</label>
                            <input wire:model="purpose" type="text" class="input input-bordered" id="purpose">
                            @error('purpose')
                                <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label" for="note">備考</label>
                            <textarea wire:model="note" class="textarea textarea-bordered" id="note"></textarea>
                            @error('note')
                                <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div x-show="type === 'withdrawal'">
                            <label for="paymentDueDate" class="label">支払い期限日</label>
                            <input type="date" wire:model.defer="paymentDueDate" id="paymentDueDate" class="input input-bordered">
                            @error('paymentDueDate')
                                <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div x-show="type === 'withdrawal'">
                            <label for="paid" class="label">支払い済み</label>
                            <input type="checkbox" wire:model.defer="paid" id="paid" class="toggle toggle-primary">
                            @error('paid')
                                <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Recurring -->
                        <div class="flex flex-wrap items-center gap-4">
                            <div class="form-control w-1/2">
                                <label for="recurringInterval" class="label">繰り返し登録</label>
                                <select id="recurringInterval" wire:model="recurringInterval" class="select select-bordered w-full">
                                    <option value="none">繰り返しなし</option>
                                    <option value="daily">毎日</option>
                                    <option value="weekly">毎週</option>
                                    <option value="monthly">毎月</option>
                                    <option value="yearly">毎年</option>
                                </select>
                            </div>

                            <div x-data="{ selectedInterval: @entangle('recurringInterval') }" class="form-control w-1/2">
                                <div x-show="selectedInterval !== 'none'">
                                    <label for="repeatCount" class="label">繰り返す回数</label>
                                    <input wire:model="repeatCount" class="input input-bordered w-full" id="repeatCount" type="number" min="1" placeholder="回数を入力">
                                    @error('repeatCount')
                                        <span class="text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Buttons -->
                    <div class="mt-8 flex justify-between">
                        <button type="button" @click="showCreateModal = false; $wire.resetInputFields();" class="btn btn-ghost">キャンセル</button>
                        <button type="submit" class="btn btn-neutral">追加する</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Transaction Modal -->
    <div x-data="{ showEditModal: false, transactionRecordId: null, type: @entangle('type') }" @open-edit-modal.window="showEditModal = true; transactionRecordId = $event.detail; $wire.edit(transactionRecordId);" @close-edit-modal.window="showEditModal = false" @keydown.escape.window="showEditModal = false">
        <div x-show="showEditModal" style="display: none" role="dialog" aria-modal="true" class="fixed inset-0 z-10 overflow-y-auto">
            <!-- Overlay -->
            <div x-show="showEditModal" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50">
            </div>

            <!-- Panel -->
            <form wire:submit="update(transactionRecordId)" x-transition @click="showEditModal = false" class="relative flex min-h-screen items-center justify-center p-4">
                <div @click.stop x-trap.noscroll.inert="showEditModal" class="modal-box w-11/12 max-w-2xl">
                    <!-- Title -->
                    <h2 class="text-2xl font-bold">会計を編集<span class="ml-4 text-base text-error/70">*</span> <span class="text-base text-base-content/70">は必須</span></h2>

                    <!-- Content -->
                    <div class="mt-4 flex flex-col gap-3">
                        <div class="form-control">
                            <label for=transactionDate" class="label">
                                <span>
                                    取引日<span class="text-base text-error/70">*</span>
                                </span>
                            </label>
                            <input type="date" wire:model.defer="transactionDate" id="transactionDate" class="input input-bordered">
                            @error('transactionDate')
                                <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label" for="type">
                                <span>
                                    取引タイプ<span class="text-base text-error/70">*</span>
                                </span>
                            </label>
                            <select wire:model="type" class="select select-bordered" id="type">
                                <option value="deposit">入金</option>
                                <option value="withdrawal">出金</option>
                                <option value="other">その他</option>
                            </select>
                            @error('type')
                                <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label" for="amount">
                                <span>
                                    金額<span class="text-base text-error/70">*</span>
                                </span>
                            </label>
                            <input wire:model="amount" type="number" class="input input-bordered" id="amount">
                            @error('amount')
                                <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label" for="purpose">科目</label>
                            <input wire:model="purpose" type="text" class="input input-bordered" id="purpose">
                            @error('purpose')
                                <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label" for="note">備考</label>
                            <textarea wire:model="note" class="textarea textarea-bordered" id="note"></textarea>
                            @error('note')
                                <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div x-show="type === 'withdrawal'">
                            <label for="paymentDueDate" class="label">支払い期限日</label>
                            <input type="date" wire:model.defer="paymentDueDate" id="paymentDueDate" class="input input-bordered">
                            @error('paymentDueDate')
                                <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div x-show="type === 'withdrawal'">
                            <label for="paid" class="label">支払い済み</label>
                            <input type="checkbox" wire:model.defer="paid" id="paid" class="toggle toggle-primary">
                            @error('paid')
                                <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="mt-8 flex justify-between">
                        <button type="button" @click="showEditModal = false; $wire.resetInputFields();" class="btn btn-ghost">キャンセル</button>
                        <button type="submit" class="btn btn-neutral">保存する</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Transaction Modal -->
    <div x-data="{ showDeleteModal: false, transactionRecordId: null }" @open-delete-modal.window="showDeleteModal = true; transactionRecordId = $event.detail;" @close-delete-modal.window="showDeleteModal = false" @keydown.escape.window="showDeleteModal = false">

        <template x-if="transactionRecordId">
            <div x-show="showDeleteModal" class="fixed inset-0 z-50 flex min-h-screen items-center justify-center" x-cloak>
                <!-- Overlay -->
                <div class="fixed inset-0 bg-black bg-opacity-50" @click="showDeleteModal = false"></div>

                <!-- Panel -->
                <div class="relative mx-4 w-full max-w-md rounded-lg bg-white p-4 shadow-lg" @click.stop x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                    <h3 class="text-lg font-semibold">本当に削除しますか？</h3>
                    <div class="mt-4 text-sm">
                        この操作は元に戻せません。削除してもよろしいですか？
                    </div>
                    <!-- Form for delete submission -->
                    <form wire:submit="delete(transactionRecordId)" class="mt-6">
                        <div class="flex justify-end gap-4">
                            <button type="button" @click="showDeleteModal = false; transactionRecordId = null;" class="btn btn-ghost">キャンセル</button>
                            <button type="submit" class="btn btn-error">削除する</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>

</div>
