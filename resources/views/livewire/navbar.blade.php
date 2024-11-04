<div>
    <div class="navbar bg-base-100 flex justify-center shadow">
        <div class="flex w-full max-w-screen-xl">
            <div class="flex-1">
                <span class="block text-xs -mt-1">お問い合わせ管理システム by レクシード</span>
                <div>
                    @can('admin')
                        <select wire:model.change="organisationId" class="select select-bordered select-sm w-full max-w-sm font-bold">
                            @foreach ($organisations as $organisation)
                                <option value="{{ $organisation->id }}">{{ $organisation->name }}</option>
                            @endforeach
                        </select>
                    @else
                        <div class="text-xl font-bold normal-case">{{ auth()->user()->organisation->name ?? 'default' }}</div>
                    @endcan
                </div>
            </div>
            <div class="flex-none">
                <div class="flex justify-end items-center gap-x-3">

                    <a href="{{ route('manage.enquiry') }}" class="btn btn-ghost">お問い合わせ対応</a>

                    @can('belong-manshion-union')
                        <a href="{{ route('manage.transaction-record') }}" class="btn btn-ghost">会計管理</a>
                    @endcan

                    @can('manager')
                        <a href="{{ route('manage.organisation') }}" class="btn btn-ghost">スタッフの登録・管理</a>
                    @endcan

                    @can('admin')
                        <a href="{{ route('manage.organisation') }}" class="btn btn-ghost">組織の登録・管理</a>
                    @endcan

                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                            <div class="w-10 rounded-full">
                                <img alt="avatar" src="{{ asset(auth()->user()->avatar) }}" />
                            </div>
                        </div>
                        <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                            <li>
                                <a href="{{ route('profile') }}" class="justify-between">
                                    {{ __('Profile') }}
                                </a>
                            </li>
                            <li><button wire:click='logout'>{{ __('Logout') }}</button></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        $wire.on('organisations-updated', () => {
            $wire.fetchOrganisations();
        });
        document.addEventListener('reloadPage', function () {
            location.reload();
        });
    </script>
@endscript
