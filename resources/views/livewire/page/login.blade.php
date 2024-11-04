<div class="flex min-h-screen items-center justify-center bg-base-200">
    <div class="m-4 min-h-[50vh] w-full max-w-sm lg:max-w-xl">
        <div class="flex items-center justify-center gap-2 p-8">
            <h1 class="text-lg font-bold">ログイン</h1>
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
            <form wire:submit.prevent="login" class="flex flex-col justify-center gap-4 px-10 py-10 lg:px-16">
                <div class="form-control">
                    <label class="label" for="email"><span class="label-text">Email</span></label>
                    <input wire:model='email' type="email" placeholder="email" class="input input-bordered [&:user-invalid]:input-warning [&:user-valid]:input-success" required id="email" autocomplete="email" />
                    @error('email')
                        <div class="text-sm text-error italic">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-control">
                    <label class="label" for="password"><span class="label-text">Password</span></label>
                    <input wire:model='password' type="password" placeholder="password" class="input input-bordered [&:user-invalid]:input-warning [&:user-valid]:input-success" required minlength="8" id="password" />
                    @error('password')
                        <div class="text-sm text-error italic">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex items-center justify-between gap-3">
                    <label class="flex cursor-pointer gap-3 text-xs">
                        <input wire:model.change='remenber' type="checkbox" class="toggle toggle-xs" />
                        ログインしたままにする
                    </label>
                    <div class="label">
                        <a class="link-hover link label-text-alt" href="{{ route('password.forgot') }}">パスワードを忘れましたか？</a>
                    </div>
                </div>

                <button class="btn btn-neutral" type="submit">ログイン</button>
                @if ($authError)
                    <div role="alert" class="alert alert-error">
                        <span class="text-error-content">{{ $authError }}</span>
                    </div>
                @endif

            </form>
        </main>

        @if (config('app.env') !== 'production')
            <main class="bg-base-100 mt-8">
                <div class="flex flex-col justify-center gap-4 px-10 py-10 lg:px-16">
                    <h3 class="text-cente">開発環境用メニュー</h3>
                    <div class="form-control">
                        <label class="label" for="userSelect"><span class="label-text">ログインユーザー選択</span></label>
                        <select id="userSelect" class="select select-bordered w-full max-w-lg">
                            <option disabled selected>選択してください</option>
                            <option value="user1">テスト＿マスター管理者</option>
                            <option value="user2">テスト＿管理職員</option>
                            <option value="user3">テスト＿社員</option>
                            <option value="user4">テスト＿外部スタッフ</option>
                            <option value="user5">テスト＿管理組合</option>
                        </select>
                    </div>
                </div>
            </main>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    userSelect.addEventListener('change', function() {
                        switch (userSelect.value) {
                            case 'user1':
                                email.value = 'test1@example.com';
                                password.value = 'password';
                                break;
                            case 'user2':
                                email.value = 'test2@example.com';
                                password.value = 'password';
                                break;
                            case 'user3':
                                email.value = 'test3@example.com';
                                password.value = 'password';
                                break;
                            case 'user4':
                                email.value = 'test4@example.com';
                                password.value = 'password';
                                break;
                            case 'user5':
                                email.value = 'test5@example.com';
                                password.value = 'password';
                                break;
                            default:
                                emailInput.value = '';
                                break;
                        }
                        email.dispatchEvent(new Event('input'));
                        password.dispatchEvent(new Event('input'));
                    });
                });
            </script>
        @endif

    </div>
</div>
