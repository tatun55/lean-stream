<div class="gap-3 lg:col-span-1">
    <div class="bg-base-100 p-3">
        <h3 class="text-xl font-bold">お客様リスト</h3>

        <div x-data="{ tab: @entangle('tab'), openChargerModal: false, id: null }">

            <div role="tablist" class="tabs tabs-boxed my-2">
                <a wire:click="toggleTab('all')" role="tab" class="tab tab-neutral" :class="{ 'tab-active': tab === 'all' }">すべて</a>
                <a wire:click="toggleTab('new')" role="tab" class="tab tab-neutral" :class="{ 'tab-active': tab === 'new' }">新規</a>
                <a wire:click="toggleTab('byPerson')" role="tab" class="tab tab-neutral" :class="{ 'tab-active': tab === 'byPerson' }">担当者ごと</a>
            </div>

            <div class="flex-grow max-h-[calc(100vh-15rem)] overflow-y-scroll">
                <div>
                    <div class="overflow-x-auto">
                        <table class="table text-center">
                            <!-- head -->
                            <thead>
                                <tr>
                                    <th class="w-8">
                                        <label>
                                            <input type="checkbox" class="checkbox" />
                                        </label>
                                    </th>
                                    <th class="w-10">アバター</th>
                                    <th>
                                        <div class="font-bold">お名前</div>
                                        <div class="text-sm opacity-50">ニックネーム</div>
                                    </th>
                                    <th class="w-16">担当</th>
                                    @can('manager')
                                        <th class="w-8">メニュー</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clientsPaginator as $client)
                                    <tr>
                                        <th>
                                            <label>
                                                <input type="checkbox" class="checkbox" />
                                            </label>
                                        </th>
                                        <td class="cursor-pointer" wire:click="$dispatch('event-client-selected', { clientLineUserId: '{{ $client->line_user_id }}' })">
                                            <div class="avatar">
                                                <div class="w-10 rounded-full">
                                                    <img src="{{ asset($client->line_picture_url) }}" alt="Avatar Tailwind CSS Component" />
                                                </div>
                                            </div>
                                        </td>
                                        <td class="cursor-pointer" wire:click="$dispatch('event-client-selected', { clientLineUserId: '{{ $client->line_user_id }}' })">
                                            <div class="font-bold">{{ $client->fullname }}</div>
                                            <div class="text-sm opacity-50">{{ $client->line_display_name }}</div>
                                        </td>
                                        <th class="w-32">
                                        @forelse($client->staffInCharge as $staff)
                                            <div class="text-xs">{{ $staff->name }}</div>
                                        @empty
                                            <div>未定</div>
                                        @endforelse
                                        </th>
                                        @can('manager')
                                        <th class="dropdown {{ $loop->last || $loop->index === $loop->count - 2 ? 'dropdown-top' : 'dropdown-bottom' }} dropdown-end">
                                            <button tabindex="0" class="btn btn-sm btn-circle mt-1.5">
                                                <svg class="w-5" data-slot="icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M4.5 12a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Zm6 0a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Zm6 0a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z"></path>
                                                </svg>
                                            </button>
                                            <ul tabindex="0" class="dropdown-content z-[999] menu p-2 shadow bg-base-100 rounded-box w-52">
                                                <li>
                                                    <a x-on:click="$wire.showChargerModal('{{ $client->id }}'); await $nextTick(); openChargerModal = true;">
                                                        <svg class="w-5 mr-1" data-slot="icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                            <path d="M5.25 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM2.25 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM18.75 7.5a.75.75 0 0 0-1.5 0v2.25H15a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H21a.75.75 0 0 0 0-1.5h-2.25V7.5Z"></path>
                                                        </svg>
                                                        担当者変更
                                                    </a>
                                                </li>
                                            </ul>
                                        </th>
                                        @endcan
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <x-pagination :paginator="$clientsPaginator" template='simple-daisy-ui' color="primary" />
                    </div>
                </div>

                <!-- Modal -->
                @if ($selectedClient)
                    <template x-if="openChargerModal">
                        <div class="flex justify-center">

                            <div x-on:keydown.escape.prevent.stop="openChargerModal = false" role="dialog" aria-modal="true" x-id="['charge-modal']" :aria-labelledby="$id('charge-modal')" class="fixed inset-0 z-10 overflow-y-auto">
                                <!-- Overlay -->
                                <div x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50"></div>

                                <!-- Panel -->
                                <div x-transition x-on:click="openChargerModal = false" class="relative flex min-h-screen items-center justify-center p-4">
                                    <div x-on:click.stop x-trap.noscroll.inert="openChargerModal" class="relative w-full max-w-2xl overflow-y-auto rounded-xl bg-white p-12 shadow-lg">
                                        <!-- Title -->
                                        <h2 class="text-3xl font-bold mb-3" :id="$id('charge-modal')"><span>{{ $selectedClient->line_display_name ?? $selectedClient->fullname }}</span>の担当者</h2>

                                        <!-- Content -->
                                        <div class="overflow-x-auto">
                                            <table class="table text-center">
                                                <!-- head -->
                                                <thead>
                                                    <tr>
                                                        <th class="w-8">
                                                            担当
                                                        </th>
                                                        <th class="w-32">ロール</th>
                                                        <th class="w-10">アバター</th>
                                                        <th>
                                                            <div class="font-bold">名前</div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($staffList as $staffInfo)
                                                        <tr>
                                                            <td>
                                                                <label>
                                                                    <input wire:click="assignStaffInCharge('{{ $staffInfo->id }}')" tabindex="-1" type="checkbox" class="checkbox" {{ in_array($staffInfo->id, $selectedClient->staffInCharge->pluck('id')->toArray()) ? 'checked' : '' }} />
                                                                </label>
                                                            </td>
                                                            <td class="w-32">{{ App\Models\User::ROLE_LABELS[$staffInfo->role] }}</td>
                                                            <td class="cursor-pointer" wire:click="handleClientSelect('{{ $staffInfo->id }}')">
                                                                <div class="avatar">
                                                                    <div class="mask mask-squircle w-10 h-10">
                                                                        <img src="{{ asset($staffInfo->avatar) }}" alt="Avatar Tailwind CSS Component" />
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="cursor-pointer text-left" wire:click="loadMessages('{{ $staffInfo->id }}')">
                                                                <div class="font-bold">{{ $staffInfo->name }}</div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Buttons -->
                                        <div class="mt-8 flex w-full">
                                            <button type="button" x-on:click="openChargerModal = false" class="btn btn-neutral w-full">
                                                OK
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                @endif
            </div>

        </div>
    </div>


</div>
