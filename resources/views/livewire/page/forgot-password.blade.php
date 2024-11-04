<div class="flex min-h-screen items-center justify-center bg-base-200">
    <div class="m-4 min-h-[50vh] w-full max-w-sm lg:max-w-xl">
        <div class="flex items-center justify-center gap-2 p-8">
            <h1 class="text-lg font-bold">パスワードリセット</h1>
        </div>
        @if (session('status'))
            <div role="alert" class="alert alert-success text-sm mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif
        <main class="bg-base-100">

            <form wire:submit.prevent="sendPasswordResetLink" class="flex flex-col justify-center gap-4 px-10 py-10 lg:px-16">
                <div class="text-sm text-base-content/60">
                    パスワードをお忘れですか？ メールアドレスをお知らせいただければ、パスワード再設定用のリンクをメールでお送りします。
                </div>
                <div class="form-control">
                    <label class="label" for="email"><span class="label-text">Email</span></label>
                    <input wire:model='email' type="email" placeholder="email" class="input input-bordered [&:user-invalid]:input-warning [&:user-valid]:input-success" required id="email" autocomplete="email" />
                    @error('email')
                        <div class="text-sm text-error italic">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-neutral" type="submit">メール送信</button>
                @if ($authError)
                    <div role="alert" class="alert alert-error">
                        <span class="text-error-content">{{ $authError }}</span>
                    </div>
                @endif

            </form>
        </main>
    </div>
</div>
