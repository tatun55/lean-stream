<div>
    <h2 class="font-semibold text-xl text-center pt-16">
        プロフィール
    </h2>
    <form wire:submit='save' class="py-12 w-full md:flex justify-center">
        <div class="mx-2 max-w-2xl p-4 sm:p-8 shadow sm:rounded-lg bg-base-100 ">
            <div class="grid grid-cols-12 gap-3">
                <div class="col-span-12 md:col-span-5 h-full flex flex-col gap-4">
                    <div class="flex justify-center w-full">
                        <div class="w-32 h-32 overflow-hidden relative">
                            <img src="{{ $new_avatar ? $new_avatar->temporaryUrl() : $avatar }}" x-ref="avatarInput" class="object-cover w-full h-full absolute">
                            <button @click="$refs.avatarInput.value = ''; $wire.delete()" class="btn btn-circle btn-xs btn-error absolute top-0 right-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex justify-center w-full">
                        <input name="avatar" type="file" wire:model="new_avatar" class="file-input file-input-bordered file-input-xs w-full max-w-xs">
                        @error('avatar')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 md:col-span-7 flex flex-col gap-4">
                    <label class="w-full max-w-md mx-auto md:mx-0">
                        <div class="ml-1 text-base-content text-lg font-medium">ニックネーム（表示名）</div>
                        <input wire:model='name' name="name" type="text" placeholder="ニックネーム（表示名）" class="input input-bordered w-full max-w-md" />
                        @error('name')
                            <div class="text-sm text-error italic">{{ $message }}</div>
                        @enderror
                    </label>
                    <label class="w-full max-w-md mx-auto md:mx-0">
                        <div class="ml-1 text-base-content text-lg font-medium">Email</div>
                        <input wire:model='email' name="email" type="email" placeholder="Email" class="input input-bordered w-full max-w-md" />
                        @error('email')
                            <div class="text-sm text-error italic">{{ $message }}</div>
                        @enderror
                    </label>
                    <label class="w-full max-w-md mx-auto md:mx-0">
                        <div class="ml-1 text-base-content text-lg font-medium">Message</div>
                        <textarea rows="2" wire:model='message' name="message" placeholder="message" class="textarea textarea-bordered w-full"></textarea>
                        @error('message')
                            <div class="text-sm text-error italic">{{ $message }}</div>
                        @enderror
                    </label>
                </div>
            </div>
            <div class="mt-4 flex w-full justify-center">
                <button class="btn btn-primary w-full max-w-md md:max-w-full">更新</button>
            </div>
        </div>
    </form>
</div>
