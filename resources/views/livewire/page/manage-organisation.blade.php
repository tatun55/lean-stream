{{-- <div class="flex w-full justify-center px-2" x-data="{ organisations: [] }" x-init="organisations = @js($organisations);"> --}}
<div class="flex w-full justify-center px-2" x-data="{ organisations: [] }" x-init="organisations = @js($orgPagenator->getCollection()->keyBy('id'));">
    <div class="w-full max-w-screen-xl">
        <h4 class="mb-4 mt-8 text-2xl font-bold">組織一覧</h4>
        <div class="flex items-center justify-between">
            <div x-data="{ open: false }" x-on:organisations-updated.window="open = false;" class="flex justify-center">
                <button x-on:click="open = true" class="btn btn-primary">新しい組織を追加</button>

                <!-- Modal -->
                <div x-show="open" style="display: none" x-on:keydown.escape.prevent.stop="open = false" role="dialog" aria-modal="true" x-id="['create-bookmark']" :aria-labelledby="$id('create-bookmark')" class="fixed inset-0 z-10 overflow-y-auto">
                    <!-- Overlay -->
                    <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50"></div>

                    <!-- Panel -->
                    <form wire:submit='save' x-show="open" x-transition x-on:click="open = false" class="relative flex min-h-screen items-center justify-center p-4">
                        <div x-on:click.stop x-trap.noscroll.inert="open" class="modal-box w-11/12 max-w-2xl">
                            <!-- Title -->
                            <h2 class="text-2xl font-bold">新しい組織を追加<span class="text-base text-error/70">*</span> <span class="text-base text-base-content/70">は必須</span> </h2>

                            <!-- Content -->
                            <div class="mt-4 flex flex-col gap-3">

                                <div class="form-control">
                                    <label class="label" for="type"><span class="label-text">組織タイプ <span class="text-base text-error/70">*</span></span></label>
                                    <select wire:model='type' class="select select-bordered" id="type" name="type">
                                        <option value="company">企業</option>
                                        <option value="manshion_union">マンション組合</option>
                                        <option value="other">その他</option>
                                    </select>
                                    @error('type')
                                        <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-control">
                                    <label class="label" for="name"><span class="label-text">名称 <span class="text-base text-error/70">*</span></span></label>
                                    <input wire:model='name' type="text" placeholder="名称" class="input input-bordered" id="name" name="name" />
                                    @error('name')
                                        <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-control">
                                    <label class="label" for="url"><span class="label-text">URL</span></label>
                                    <input wire:model='url' type="text" placeholder="https://example.com" class="input input-bordered" id="url" name="url" />
                                    @error('url')
                                        <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-control">
                                    <label class="label" for="postal_code"><span class="label-text">郵便番号 <span class="text-basecontent/70 text-sm">(ハイフン無し)</span></span></label>
                                    <input wire:model='postal_code' type="text" placeholder="1234567" class="input input-bordered" id="postal_code" name="postal_code" />
                                    @error('postal_code')
                                        <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-control">
                                    <label class="label" for="address"><span class="label-text">Address</span></label>
                                    <input wire:model='address' type="text" placeholder="東京都中央区日本橋1-1-1 日本橋ビル101" class="input input-bordered" id="address" name="address" />
                                    @error('address')
                                        <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-control">
                                    <label class="label" for="tel"><span class="label-text">電話番号</span></label>
                                    <input wire:model='tel' type="text" placeholder="03-1234-5678" class="input input-bordered" id="tel" name="tel" />
                                    @error('tel')
                                        <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-control">
                                    <label class="label" for="note"><span class="label-text">備考 <span class="text-basecontent/70 text-sm">(1000文字以内)</span></span></label>
                                    <textarea wire:model='note' type="text" placeholder="備考" class="textarea textarea-bordered" id="note" name="note" rows="4"></textarea>
                                    @error('note')
                                        <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="mt-8 flex justify-between">
                                <button type="button" x-on:click="open = false;$wire.resetProperty();" class="btn btn-ghost">
                                    キャンセル
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    追加する
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="relative w-full max-w-lg">
                <input wire:model.live.debounce="query" type="text" placeholder="検索ワードを入力" class="input input-bordered w-full rounded-full pl-12" />
                <div class="pointer-events-none absolute bottom-0 left-1.5 top-0 flex items-center pl-2 text-gray-500">
                    <svg class="w-6" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="my-4 min-h-full overflow-x-scroll">
            <table class="table bg-base-100 p-2 shadow">
                <!-- head -->
                <thead>
                    <tr>
                        <th>追加日時</th>
                        <th>組織タイプ</th>
                        <th>名称</th>
                        <th>URL</th>
                        <th class="w-8"><span class="text-xs">メニュー</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orgPagenator as $organisation)
                        <tr wire:key='{{ $organisation->id }}' class="overflow-y-visible">
                            <th class="w-44 font-mono text-sm font-light">
                                {{ $organisation->created_at->format('Y.m.d　H:i') }}</th>
                            <th class="w-44 font-mono text-sm font-light">{{ $organisation->type_label }}</th>
                            <td>
                                <a @click="$dispatch('open-show-modal','{{ $organisation->id }}')" class="link">{{ $organisation->name }}</a>
                            </td>
                            <td> <a class="bnt btn-link" href="{{ $organisation->url }}" target="_blank" rel="noopener noreferrer">{{ $organisation->url }}</a></td>
                            <td class="w-8">
                                <div class="dropdown-left dropdown">
                                    <button tabindex="0" role="button"class="btn btn-square btn-sm btn-ghost m-1overflow-y-visible">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-5 w-5 stroke-current">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z">
                                            </path>
                                        </svg>
                                    </button>
                                    <ul tabindex="0" class="menu dropdown-content z-50 w-52 rounded-box bg-base-100 p-2 shadow">

                                        <li>
                                            <button type="button" class="text-base-content/70" @click="$dispatch('open-line-connect-modal','{{ $organisation->id }}')">
                                                <svg class="w-5 text-info" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z">
                                                    </path>
                                                </svg>
                                                LINE連携
                                            </button>
                                        </li>

                                        <li>
                                            <button type="button" class="text-base-content/70" @click="$dispatch('open-edit-modal','{{ $organisation->id }}')">
                                                <svg class="mb-1 w-5 text-success" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10">
                                                    </path>
                                                </svg>
                                                編集
                                            </button>
                                        </li>

                                        <li>
                                            <button type="button" class="text-base-content/70" @click="$dispatch('open-delete-modal','{{ $organisation->id }}')">
                                                <svg class="mb-0.5 w-5 text-error" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0">
                                                    </path>
                                                </svg>
                                                削除
                                            </button>
                                        </li>

                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                <x-pagination :paginator="$orgPagenator" template='simple-daisy-ui' color="primary" />
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div x-data="{ modalOpen: false, id: null, confirmation: '' }" x-on:open-delete-modal.window="modalOpen = true; id = $event.detail; confirmation = '';" @keydown.escape.window="modalOpen = false" @organisations-updated.window="modalOpen = false" class="relative z-50 h-auto w-auto">
        <template x-if="id !== null">
            <div x-show="modalOpen" class="fixed left-0 top-0 z-[99] flex h-screen w-screen items-center justify-center" x-cloak>
                <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="modalOpen=false" class="absolute inset-0 h-full w-full bg-black bg-opacity-40"></div>
                <div x-show="modalOpen" x-trap.inert.noscroll="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative w-full bg-white px-7 py-6 sm:max-w-lg sm:rounded-lg">
                    <div id="show_modal_content" class="flex items-center justify-between pb-2">
                        <h3 class="text-lg font-semibold">本棒に削除しますか？</h3>
                        <button @click="modalOpen=false" tabindex="-1" class="absolute right-0 top-0 mr-5 mt-5 flex h-8 w-8 items-center justify-center rounded-full text-gray-600 hover:bg-gray-50 hover:text-gray-800">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <!-- Panel -->
                    <form wire:submit="delete(id)">

                        <label class="mt-4 flex flex-col gap-2">
                            削除して良い場合のみ、"削除" と入力してください。
                            <input x-model="confirmation" class="rounded-lg border border-slate-300 px-3 py-2" placeholder="削除">
                        </label>

                        <!-- Buttons -->
                        <div class="mt-8 flex justify-between">
                            <button type="button" @click="id = null" class="btn btn-ghost">
                                キャンセル
                            </button>
                            <button type="submit" :disabled="confirmation !== '削除'" class="btn btn-error">
                                削除する
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>

    <!-- Show Modal -->
    <div x-data="{ modalOpen: false, id: null }" @open-show-modal.window="modalOpen = true; id = $event.detail;" @keydown.escape.window="modalOpen = false" class="relative z-50 h-auto w-auto">
        <template x-if="id !== null">
            <div x-show="modalOpen" class="fixed left-0 top-0 z-[99] flex h-screen w-screen items-center justify-center" x-cloak>
                <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="modalOpen=false" class="absolute inset-0 h-full w-full bg-black bg-opacity-40"></div>
                <div x-show="modalOpen" x-trap.inert.noscroll="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative w-full bg-white px-7 py-6 sm:max-w-lg sm:rounded-lg">
                    <div id="show_modal_content" class="flex items-center justify-between pb-2">
                        <h3 class="text-lg font-semibold">詳細情報</h3>
                        <button @click="modalOpen=false" tabindex="-1" class="absolute right-0 top-0 mr-5 mt-5 flex h-8 w-8 items-center justify-center rounded-full text-gray-600 hover:bg-gray-50 hover:text-gray-800">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="relative flex w-auto flex-col gap-3">
                        <div>
                            <div class="font-semibold">組織属性</div>
                            <p x-text="organisations[id].type_label"></p>
                        </div>
                        <div>
                            <div class="font-semibold">名称</div>
                            <p x-text="organisations[id].name"></p>
                        </div>
                        <div>
                            <div class="font-semibold">URL</div>
                            <a tabindex="-1" class="link" :href="organisations[id].url" target="_blank" rel="noopener noreferrer" x-text="organisations[id].url"></a>
                        </div>
                        <div>
                            <div class="font-semibold">郵便番号</div>
                            <p x-text="organisations[id].postal_code"></p>
                        </div>
                        <div>
                            <div class="font-semibold">住所</div>
                            <p x-text="organisations[id].address"></p>
                        </div>
                        <div>
                            <div class="font-semibold">電話番号</div>
                            <p x-text="organisations[id].tel"></p>
                        </div>
                        <div>
                            <div class="font-semibold">備考欄</div>
                            <p x-text="organisations[id].note"></p>
                        </div>
                    </div>
                    <!-- Buttons -->
                    <div class="mt-8 flex justify-end">
                        <button type="button" tabindex="-1" @click="modalOpen = false" class="btn btn-neutral">
                            閉じる
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Edit Modal -->
    <div x-data="{
        modalOpen: false,
        id: null,
        organisation: {
            type: '',
            name: '',
            url: '',
            postal_code: '',
            address: '',
            tel: '',
            note: ''
        }
    }" @open-edit-modal.window="
    modalOpen = true; 
    id = $event.detail;
    organisation = {
        type: organisations[id].type,
        name: organisations[id].name,
        url: organisations[id].url,
        postal_code: organisations[id].postal_code,
        address: organisations[id].address,
        tel: organisations[id].tel,
        note: organisations[id].note
    }
" @keydown.escape.window="modalOpen = false" @organisations-updated.window="modalOpen = false" class="relative z-50 h-auto w-auto">
        <template x-if="id !== null">
            <div x-show="modalOpen" class="fixed left-0 top-0 z-[99] flex h-screen w-screen items-center justify-center" x-cloak>
                <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="modalOpen=false" class="absolute inset-0 h-full w-full bg-black bg-opacity-40"></div>
                <div x-show="modalOpen" x-trap.inert.noscroll="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative w-full bg-white px-7 py-6 sm:max-w-lg sm:rounded-lg">
                    <div id="show_modal_content" class="flex items-center justify-between pb-2">
                        <h3 class="text-lg font-semibold">詳細情報</h3>
                        <button @click="modalOpen=false" tabindex="-1" class="absolute right-0 top-0 mr-5 mt-5 flex h-8 w-8 items-center justify-center rounded-full text-gray-600 hover:bg-gray-50 hover:text-gray-800">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="edit(id,organisation)" class="relative flex w-auto flex-col gap-3">
                        <div class="form-control">
                            <label class="label" for="type"><span class="label-text">組織タイプ <span class="text-base text-error/70">*</span></span></label>
                            <select x-model="organisation.type" class="select select-bordered" id="type" name="type">
                                <option value="company">企業</option>
                                <option value="manshion_union">マンション組合</option>
                                <option value="other">その他</option>
                            </select>
                            @error('type')
                                <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-control">
                            <label class="label" for="name"><span class="label-text">名称 <span class="text-base text-error/70">*</span></span></label>
                            <input x-model="organisation.name" type="text" placeholder="名称" class="input input-bordered" id="name" name="name" />
                            @error('name')
                                <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-control">
                            <label class="label" for="url"><span class="label-text">URL</span></label>
                            <input x-model="organisation.url" type="text" placeholder="https://example.com" class="input input-bordered" id="url" name="url" />
                            @error('url')
                                <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-control">
                            <label class="label" for="postal_code"><span class="label-text">郵便番号 <span class="text-basecontent/70 text-sm">(ハイフン無し)</span></span></label>
                            <input x-model="organisation.postal_code" type="text" placeholder="1234567" class="input input-bordered" id="postal_code" name="postal_code" />
                            @error('postal_code')
                                <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-control">
                            <label class="label" for="address"><span class="label-text">Address</span></label>
                            <input x-model="organisation.address" type="text" placeholder="東京都中央区日本橋1-1-1 日本橋ビル101" class="input input-bordered" id="address" name="address" />
                            @error('address')
                                <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-control">
                            <label class="label" for="tel"><span class="label-text">電話番号</span></label>
                            <input x-model="organisation.tel" type="text" placeholder="03-1234-5678" class="input input-bordered" id="tel" name="tel" />
                            @error('tel')
                                <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-control">
                            <label class="label" for="note"><span class="label-text">備考 <span class="text-basecontent/70 text-sm">(1000文字以内)</span></span></label>
                            <textarea x-model="organisation.note" type="text" placeholder="備考" class="textarea textarea-bordered" id="note" name="note" rows="4"></textarea>
                            @error('note')
                                <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="mt-8 flex justify-between">
                            <button type="button" x-on:click="modalOpen = false; id = null" class="btn btn-ghost">
                                キャンセル
                            </button>
                            <button type="submit" class="btn btn-success">
                                編集する
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>

    <!-- Line Connect Modal -->
    <div x-data="{ modalOpen: false, id: null }" @open-line-connect-modal.window="modalOpen = true; id = $event.detail; " @keydown.escape.window="modalOpen = false" class="relative z-50 h-auto w-auto">
        <template x-if="id !== null">
            <div x-show="modalOpen" class="fixed left-0 top-0 z-[99] flex h-screen w-screen items-center justify-center" x-cloak>
                <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="modalOpen=false" class="absolute inset-0 h-full w-full bg-black bg-opacity-40"></div>
                <div x-show="modalOpen" x-trap.inert.noscroll="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative w-full bg-white px-7 py-6 sm:max-w-lg sm:rounded-lg">

                    <h3 class="text-lg font-semibold">LINE公式アカウントとの連携</h3>
                    <button @click="modalOpen=false" tabindex="-1" class="absolute right-0 top-0 mr-5 mt-5 flex h-8 w-8 items-center justify-center rounded-full text-gray-600 hover:bg-gray-50 hover:text-gray-800">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- Content -->
                    <div class="mt-4 flex flex-col gap-3">
                        <div class="form-control">
                            <label class="label" for="destination"><span class="label-text">Destination</span></label>
                            <input wire:model='destination' type="text" placeholder="xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx" class="input input-bordered" id="destination" name="destination" />
                            @error('destination')
                                <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-control">
                            <label class="label" for="channel_secret"><span class="label-text">チャネルシークレット</span></label>
                            <input wire:model='channel_secret' type="text" placeholder="xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx" class="input input-bordered" id="channel_secret" name="channel_secret" />
                            @error('channel_secret')
                                <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-control">
                            <label class="label" for="basic_id"><span class="label-text">ベーシックID</span></label>
                            <input wire:model='basic_id' type="text" placeholder="@xxxxxxxx" class="input input-bordered" id="basic_id" name="basic_id" />
                            @error('basic_id')
                                <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-control">
                            <label class="label" for="access_token"><span class="label-text">アクセストークン</span></label>
                            <input wire:model='access_token' type="text" placeholder="+AXYQ2AYsfT5StPbDv7hfrHi2t+Swa4PzMR+dorDIO+xDYnPOAhN3r3evWQBfyMb4N3P9YHeyqj0PXxY8JZ7do/L24222acOQd/yd7EvPIxHJmGfzJb2cNVASsVr+HeY6d7m87Or2KhwJOXxaX8AMAdB04t89/1O/w1cDnyilFU=" class="input input-bordered" id="access_token" name="access_token" />
                            @error('access_token')
                                <div class="mt-1 text-sm italic text-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="mt-8 flex justify-between">
                        <button type="button" @click="modalOpen = false" class="btn btn-ghost">
                            キャンセル
                        </button>
                        <button x-on:click="$wire.lineConnect(id);$wire.resetProperty();" type="button" class="btn btn-primary">
                            連携する
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>

</div>
