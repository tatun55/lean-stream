<div x-data="{ scrollToBottomOfRemark: () => { $nextTick(() => { $refs.endOfRemark.scrollIntoView() }) } }" @scroll-to-bottom.window="scrollToBottomOfRemark();" x-init="scrollToBottomOfRemark()" class="p-3 gap-3 lg:col-span-1 bg-base-100">
    <h3 class="text-xl font-bold">内部メモ・データ</h3>
    <div class="px-2 flex flex-col" data-theme="winter">
        <div class="flex-grow max-h-[calc(100vh-12.5rem)] overflow-y-scroll">
            @empty($remarks)
                <div class="h-[calc(100vh-12.5rem)] flex flex-col justify-center text-center">
                    <div>お客様を選択してください</div>
                </div>
            @else
                @foreach ($remarks as $remark)
                    <div class="flex justify-center flex-row my-2">
                        @if ($hasMoreRemarks)
                            <button class="btn rounded-full btn-ghost" wire:click="loadOldMessages()">
                                <svg class="w-8" data-slot="icon" fill="none" stroke-width="1.5" stroke="#BBBBBB" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                                </svg>
                                <span class="text-base-content/70">過去メッセージ</span>
                            </button>
                        @endif
                    </div>
                    <div class="chat {{ $remark->from_user ? 'chat-start' : 'chat-end' }}">
                        <div class="chat-image avatar">
                            <div class="w-10 rounded-full">
                                <img class="object-cover" src="{{ asset($remark->sender->avatar) }}">
                            </div>
                        </div>
                        <div class="chat-header">
                            {{ $remark->sender->display_name }}
                            <time class="text-xs opacity-50">{{ $remark->created_at_label }}</time>
                        </div>

                        @if ($remark->type === 'text' || $remark->type === 'file')
                            <div class="chat-bubble break-words">{!! nl2br($remark->body) !!}</div>
                        @else
                            <div class="chat-bubble">
                                <div class="pswp-gallery" id="my-gallery">
                                    <div class="grid grid-cols-1 gap-4 pswp-gallery">
                                        <a href="{{ Storage::disk('s3')->url($remark->path) }}" target="_blank" class="w-full h-48 bg-gray-200 overflow-hidden">
                                            <img src="{{ Storage::disk('s3')->url($remark->path) }}" alt="Image 1" class="object-cover w-full h-full">
                                        </a>
                                        {{-- <a href="{{ Storage::disk('s3')->url($remark->path) }}" target="_blank" class="w-full h-48 bg-gray-200 overflow-hidden">
                                            <img src="{{ Storage::disk('s3')->url($remark->path) }}" alt="Image 1" class="object-cover w-full h-full">
                                        </a> --}}
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="chat-footer opacity-50">
                            既読
                        </div>
                    </div>
                @endforeach
                <div class="flex justify-center flex-row">
                    <button wire:click="handleClientSelected('{{ $currentClientLineUserId }}')" class="btn btn-circle btn-ghost">
                        <svg class="w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="redo">
                            <path fill="#BBBBBB" d="M21,11a1,1,0,0,0-1,1,8.05,8.05,0,1,1-2.22-5.5h-2.4a1,1,0,0,0,0,2h4.53a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4.77A10,10,0,1,0,22,12,1,1,0,0,0,21,11Z"></path>
                        </svg>
                    </button>
                </div>
            @endempty

            <div x-ref="endOfRemark"></div>
        </div>
    </div>
    @empty(!$remarks)
        <div x-data="{ inputText: '', fileSelected: false, isLoading: false }" @file-uploaded.window="isLoading = false" class="flex w-full py-2 gap-2 relative">
            @if ($allFiles)
                <a x-on:click="$dispatch('open-upload-remark-files-modal');">
                    <svg class="w-8 my-2" data-slot="icon" fill="black" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-11.25a.75.75 0 0 0-1.5 0v2.5h-2.5a.75.75 0 0 0 0 1.5h2.5v2.5a.75.75 0 0 0 1.5 0v-2.5h2.5a.75.75 0 0 0 0-1.5h-2.5v-2.5Z"></path>
                    </svg>
                </a>
            @else
                <a onclick="inputRemarkFiles.click()">
                    <svg class="w-8 my-2" data-slot="icon" fill="black" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-11.25a.75.75 0 0 0-1.5 0v2.5h-2.5a.75.75 0 0 0 0 1.5h2.5v2.5a.75.75 0 0 0 1.5 0v-2.5h2.5a.75.75 0 0 0 0-1.5h-2.5v-2.5Z"></path>
                    </svg>
                </a>
            @endif
            <div class="form-control w-full">
                <textarea rows="3" wire:model.lazy="text" x-model="inputText" type="text" placeholder="メモ" class="w-full resize-none input input-bordered pt-1 px-1.5"></textarea>
                @error('text')
                    <div class="text-sm text-error">{{ $message }}</div>
                @enderror
                @error('files')
                    <div class="text-sm text-error">{{ $message }}</div>
                @enderror
            </div>

            @if ($allFiles)
                <div class="absolute -top-5">
                    <span class="badge badge-ghost badge-lg gap-2">
                        <svg class="w-5" data-slot="icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z"></path>
                            <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z"></path>
                        </svg>
                        <span class="max-w-64 truncate">追加済ファイル</span>
                        <span class="badge badge-primary">
                            {{ count($allFiles) }}
                        </span>
                    </span>
                </div>
            @endif

            <button wire:click='storeRemark()' type="button" :disabled="(inputText.trim() === '' && !fileSelected) || isLoading" class="btn btn-primary"><span x-show="!isLoading">送信</span><span x-show="isLoading" class="loading loading-spinner loading-md"></span></button>

            <div x-data="{ modalOpen: false }" x-on:open-upload-remark-files-modal.window="modalOpen = true;" @keydown.escape.window="modalOpen = false" @organisations-updated.window="modalOpen = false" class="relative z-50 w-auto h-auto">
                <div x-show="modalOpen" class="fixed top-0 left-0 z-[99] flex items-center justify-center w-screen h-screen" x-cloak>
                    <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="modalOpen=false" class="absolute inset-0 w-full h-full bg-black bg-opacity-40"></div>
                    <div x-show="modalOpen" x-trap.inert.noscroll="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative w-full py-6 bg-base-100 px-7 sm:max-w-4xl sm:rounded-lg">
                        <div id="show_modal_content" class="flex items-center justify-between pb-2">
                            <button @click="modalOpen=false" tabindex="-1" class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 mt-5 mr-5 text-gray-600 rounded-full hover:text-gray-800 hover:bg-gray-50">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="w-full">
                            <button tabindex="-1" @click="inputRemarkFiles.click()" class="btn btn-neutral" wire:loading.attr="disabled">ファイルを追加する</button>
                            <input id="inputRemarkFiles" wire:model="files" type="file" @change="fileSelected = $event.target.files.length > 0; isLoading = true;" multiple style="display:none;" tabindex="-1" />
                            @if ($allFiles)
                                <div class="flex flex-wrap w-full max-w-4xl gap-4 mt-8">
                                    @foreach ($allFiles as $index => $file)
                                        <span class="badge badge-ghost badge-lg gap-2">
                                            <svg class="w-5" data-slot="icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z"></path>
                                                <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z"></path>
                                            </svg>
                                            <span class="max-w-64 truncate">{{ $file->getClientOriginalName() }}</span>
                                            <a wire:click="removeFile({{ $index }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-5 h-5 stroke-current">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </a>
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endempty

</div>
