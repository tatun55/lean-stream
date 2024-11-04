<div class="flex min-h-screen items-center justify-center bg-base-200">
    <div class="m-4 min-h-[50vh] w-full max-w-sm lg:max-w-xl">
        <div class="flex items-center justify-center gap-2 p-8">
            <h1 class="text-lg font-bold">パスワードリセット</h1>
        </div>
        <main class="bg-base-100">
            <form wire:submit.prevent="resetPassword" class="flex flex-col justify-center gap-4 px-10 py-10 lg:px-16">
                <div class="form-control">
                    <label class="label" for="input1"><span class="label-text">Email</span></label>
                    <input wire:model='email' type="email" placeholder="email" class="input input-bordered [&:user-invalid]:input-warning [&:user-valid]:input-success" required id="input1" autocomplete="email" />
                    @error('email')
                        <div class="text-sm text-error italic">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-control">
                    <label class="label" for="input2"><span class="label-text">Password</span></label>
                    <input wire:model='password' type="password" placeholder="password" class="input input-bordered [&:user-invalid]:input-warning [&:user-valid]:input-success" required minlength="8" for="input2" />
                    @error('password')
                        <div class="text-sm text-error italic">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-control">
                    <label class="label" for="input2"><span class="label-text">Password(確認用)</span></label>
                    <input wire:model='password_confirmation' type="password" placeholder="password(確認用)" class="input input-bordered [&:user-invalid]:input-warning [&:user-valid]:input-success" required minlength="8" for="input2" />
                    @error('password_confirmation')
                        <div class="text-sm text-error italic">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-neutral" type="submit">パスワードリセット</button>

            </form>
        </main>
    </div>
</div>
