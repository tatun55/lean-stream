<div x-data="{ isShowBankAccount: false }" x-on:show-bank-account.window="isShowBankAccount = true;" x-on:hide-bank-account.window="isShowBankAccount = false;">
    <div x-show="isShowBankAccount">
        <div class="flex items-center justify-between mt-10">
            <button @click="$dispatch('open-create-bank-account-modal');" class="btn btn-neutral btn-wide">口座を登録</button>
        </div>
        <div class="mt-8">
            <div class="overflow-x-auto">
                <table class="table mb-12 w-full bg-base-100 p-2">
                    <thead>
                        <tr class="text-center">
                            <th class="w-24">会計タイプ</th>
                            <th class="w-96">管理名</th>
                            <th>銀行名</th>
                            <th>支店名</th>
                            <th>口座種類</th>
                            <th>口座番号</th>
                            <th>口座名義</th>
                            <th class="w-12">メニュー</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bankAccounts as $bankAccount)
                            <tr wire:key='{{ $bankAccount->id }}' @click="$dispatch('open-bank-detail-modal', '{{ $bankAccount->id }}')" class="text-center cursor-pointer hover:bg-gray-100">
                                <td>{{ $bankAccount->transaction_type_label }}</td>
                                <td>{{ $bankAccount->management_name }}</td>
                                <td>{{ $bankAccount->bank_name }}</td>
                                <td>{{ $bankAccount->branch_name }}</td>
                                <td>{{ $bankAccount->account_type_label }}</td>
                                <td>{{ $bankAccount->account_number }}</td>
                                <td>{{ $bankAccount->account_holder }}</td>
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
                                                <button @click="$dispatch('open-edit-bank-account-modal', '{{ $bankAccount->id }}')" class="flex items-center gap-2">
                                                    <svg class="mb-1 w-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10">
                                                        </path>
                                                    </svg>
                                                    編集
                                                </button>
                                            </li>
                                            <li>
                                                <button @click="$dispatch('open-delete-bank-account-modal', '{{ $bankAccount->id }}')" class="flex items-center gap-2">
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
                                <td colspan="9" class="text-center">口座がありません</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- New Manage Bank Modal -->
            <div x-data="{ showCreateBankAccountModal: false }" x-on:open-create-bank-account-modal.window="showCreateBankAccountModal = true" @close-create-bank-acount-modal.window="showCreateBankAccountModal = false" @keydown.escape.window="showCreateBankAccountModal = false">
                <div x-show="showCreateBankAccountModal" style="display: none" @keydown.escape.prevent.stop="showCreateBankAccountModal = false" role="dialog" aria-modal="true" class="fixed inset-0 z-10 overflow-y-auto">

                    <!-- Overlay -->
                    <div class="fixed inset-0 bg-black bg-opacity-50" @click="showCreateBankAccountModal = false">
                    </div>

                    <!-- Panel -->
                    <form wire:submit="storeBank" @click="showCreateBankAccountModal = false" class="relative flex min-h-screen items-center justify-center p-4">
                        <div @click.stop x-trap.noscroll.inert="showCreateBankAccountModal" class="modal-box w-11/12 max-w-2xl">

                            <!-- Title -->
                            <h2 class="text-2xl font-bold">新しい口座の登録<span class="ml-2 text-base text-error/70">*</span> <span class="text-base text-base-content/70">は必須</span></h2>

                            <!-- Content -->
                            <div class="mt-4 flex flex-col gap-3">

                                <div class="form-control">
                                    <label for="transaction_type" class="label"><span>会計タイプ<span class="ml-1 text-base text-error/70">*</span></span></label>
                                    <select name="transaction_type" wire:model="newBankAccount.transaction_type" class="select select-bordered" id="transaction_type">
                                        <option value="general">一般会計</option>
                                        <option value="special">特別会計</option>
                                    </select>
                                    @error('transaction_type')
                                        <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-control">
                                    <label for="management_name" class="label"><span>管理名<span class="ml-1 text-base text-error/70">*</span></span></label>
                                    <input placeholder="〇〇用" type="text" name="management_name" wire:model.defer="newBankAccount.management_name" id="management_name" class="input input-bordered">
                                    @error('management_name')
                                        <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-control">
                                    <label for="note" class="label">備考</label>
                                    <textarea name="note" wire:model="newBankAccount.note" class="textarea textarea-bordered" id="note"></textarea>
                                    @error('note')
                                        <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- details --}}
                                <div class="join join-vertical w-full bg-base-100">
                                    <div class="collapse collapse-arrow join-item border border-base-300">
                                        <input type="checkbox">
                                        <div class="collapse-title text-xl font-medium">
                                            詳細を入力<span class="ml-2 text-base text-error/70">*</span> <span class="text-base text-base-content/70">オプション</span>
                                        </div>
                                        <div class="collapse-content">
                                            <div class="form-control">
                                                <label for="account_holder" class="label">
                                                    <span>
                                                        口座名義
                                                    </span>
                                                </label>
                                                <input type="text" name="account_holder" wire:model.defer="newBankAccount.account_holder" id="account_holder" class="input input-bordered">
                                                @error('account_holder')
                                                    <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-control">
                                                <label for="account_number" class="label">
                                                    <span>
                                                        口座番号
                                                    </span>
                                                </label>
                                                <input type="text" name="account_number" wire:model.defer="newBankAccount.account_number" id="account_number" class="input input-bordered">
                                                @error('account_number')
                                                    <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-control">
                                                <label for="bank_name" class="label">
                                                    <span>
                                                        銀行名
                                                    </span>
                                                </label>
                                                <input type="text" name="bank_name" wire:model.defer="newBankAccount.bank_name" id="bank_name" class="input input-bordered">
                                                @error('bank_name')
                                                    <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-control">
                                                <label for="branch_name" class="label">
                                                    <span>
                                                        支店名
                                                    </span>
                                                </label>
                                                <input type="text" name="branch_name" wire:model.defer="newBankAccount.branch_name" id="branch_name" class="input input-bordered">
                                                @error('branch_name')
                                                    <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-control">
                                                <label for="account_type" class="label">
                                                    <span>
                                                        口座種類
                                                    </span>
                                                </label>
                                                <select name="account_type" wire:model="newBankAccount.account_type" class="select select-bordered" id="account_type">
                                                    <option value="">選んでください</option>
                                                    <option value="savings">普通預金</option>
                                                    <option value="checking">当座預金</option>
                                                    <option value="other">その他</option>
                                                </select>
                                                @error('account_type')
                                                    <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="mt-8 flex justify-between">
                                    <button type="button" @click="showCreateBankAccountModal = false; $wire.resetInputFields();" class="btn btn-ghost">キャンセル</button>
                                    <button type="submit" class="btn btn-neutral">追加する</button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit Bank Modal -->
            <div x-data="{ showEditBankAccountModal: false, bankAccountId: null, currentBankAccount: $wire.entangle('currentBankAccount') }" x-on:open-edit-bank-account-modal.window="bankAccountId = $event.detail; $wire.getCurrentAccount(bankAccountId);" x-on:show-edit-bank-account-modal.window="showEditBankAccountModal = true;" @close-edit-bank-acount-modal.window="showEditBankAccountModal = false" @keydown.escape.window="showEditBankAccountModal = false">
                <div x-show="showEditBankAccountModal" style="display: none" @keydown.escape.prevent.stop="showEditBankAccountModal = false" role="dialog" aria-modal="true" class="fixed inset-0 z-10 overflow-y-auto">

                    <!-- Overlay -->
                    <div class="fixed inset-0 bg-black bg-opacity-50" @click="showEditBankAccountModal = false">
                    </div>

                    <!-- Panel -->
                    <form wire:submit="updateBank" @click="showEditBankAccountModal = false" class="relative flex min-h-screen items-center justify-center p-4">
                        <div @click.stop x-trap.noscroll.inert="showEditBankAccountModal" class="modal-box w-11/12 max-w-2xl">

                            <!-- Title -->
                            <h2 class="text-2xl font-bold">新しい口座の登録<span class="ml-2 text-base text-error/70">*</span> <span class="text-base text-base-content/70">は必須</span></h2>

                            <!-- Content -->
                            <div class="mt-4 flex flex-col gap-3">

                                <div class="form-control">
                                    <label for="transaction_type" class="label"><span>会計タイプ<span class="ml-1 text-base text-error/70">*</span></span></label>
                                    <select name="transaction_type" wire:model="currentBankAccount.transaction_type" class="select select-bordered" id="transaction_type">
                                        <option value="general">一般会計</option>
                                        <option value="special">特別会計</option>
                                    </select>
                                    @error('transaction_type')
                                        <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-control">
                                    <label for="management_name" class="label"><span>管理名<span class="ml-1 text-base text-error/70">*</span></span></label>
                                    <input placeholder="〇〇用" type="text" name="management_name" wire:model.defer="currentBankAccount.management_name" id="management_name" class="input input-bordered">
                                    @error('management_name')
                                        <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-control">
                                    <label for="note" class="label">備考</label>
                                    <textarea name="note" wire:model="currentBankAccount.note" class="textarea textarea-bordered" id="note"></textarea>
                                    @error('note')
                                        <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- details --}}
                                <div class="join join-vertical w-full bg-base-100">
                                    <div class="collapse collapse-arrow join-item border border-base-300">
                                        <input type="checkbox">
                                        <div class="collapse-title text-xl font-medium">
                                            詳細を入力<span class="ml-2 text-base text-error/70">*</span> <span class="text-base text-base-content/70">オプション</span>
                                        </div>
                                        <div class="collapse-content">
                                            <div class="form-control">
                                                <label for="account_holder" class="label">
                                                    <span>
                                                        口座名義
                                                    </span>
                                                </label>
                                                <input type="text" name="account_holder" wire:model.defer="currentBankAccount.account_holder" id="account_holder" class="input input-bordered">
                                                @error('account_holder')
                                                    <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-control">
                                                <label for="account_number" class="label">
                                                    <span>
                                                        口座番号
                                                    </span>
                                                </label>
                                                <input type="text" name="account_number" wire:model.defer="currentBankAccount.account_number" id="account_number" class="input input-bordered">
                                                @error('account_number')
                                                    <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-control">
                                                <label for="bank_name" class="label">
                                                    <span>
                                                        銀行名
                                                    </span>
                                                </label>
                                                <input type="text" name="bank_name" wire:model.defer="currentBankAccount.bank_name" id="bank_name" class="input input-bordered">
                                                @error('bank_name')
                                                    <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-control">
                                                <label for="branch_name" class="label">
                                                    <span>
                                                        支店名
                                                    </span>
                                                </label>
                                                <input type="text" name="branch_name" wire:model.defer="currentBankAccount.branch_name" id="branch_name" class="input input-bordered">
                                                @error('branch_name')
                                                    <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-control">
                                                <label for="account_type" class="label">
                                                    <span>
                                                        口座種類
                                                    </span>
                                                </label>
                                                <select name="account_type" wire:model="currentBankAccount.account_type" class="select select-bordered" id="account_type">
                                                    <option value="">選んでください</option>
                                                    <option value="savings">普通預金</option>
                                                    <option value="checking">当座預金</option>
                                                    <option value="other">その他</option>
                                                </select>
                                                @error('account_type')
                                                    <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="mt-8 flex justify-between">
                                    <button type="button" @click="showEditBankAccountModal = false; $wire.resetInputFields();" class="btn btn-ghost">キャンセル</button>
                                    <button type="submit" class="btn btn-neutral">更新する</button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Transaction Modal -->
            <div x-data="{ showBankDeleteModal: false, bankAccountId: null }" @open-delete-bank-account-modal.window="showBankDeleteModal = true; bankAccountId = $event.detail;" @close-delete-bank-account-modal.window="showBankDeleteModal = false" @keydown.escape.window="showBankDeleteModal = false">

                <template x-if="showBankDeleteModal">
                    <div x-show="showBankDeleteModal" class="fixed inset-0 z-50 flex min-h-screen items-center justify-center" x-cloak>
                        <!-- Overlay -->
                        <div class="fixed inset-0 bg-black bg-opacity-50" @click="showBankDeleteModal = false"></div>

                        <!-- Panel -->
                        <div class="relative mx-4 w-full max-w-md rounded-lg bg-white p-4 shadow-lg" @click.stop x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                            <h3 class="text-lg font-semibold">本当に削除しますか？</h3>
                            <div class="mt-4 text-sm">
                                この操作は元に戻せません。削除してもよろしいですか？
                            </div>
                            <!-- Form for delete submission -->
                            <form wire:submit="deleteBank(bankAccountId)" class="mt-6">
                                <div class="flex justify-end gap-4">
                                    <button type="button" @click="showBankDeleteModal = false; bankAccountId = null;" class="btn btn-ghost">キャンセル</button>
                                    <button type="submit" class="btn btn-error">削除する</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </template>
            </div>

        </div>
    </div>
</div>
