<div>
    @can('admin')
        <select wire:model.change="organisationId" class="select select-bordered select-sm w-full max-w-sm font-bold">
            @foreach ($organisations as $organisation)
                <option value="{{ $organisation->id }}">{{ $organisation->name }}</option>
            @endforeach
        </select>
    @else
        <a href="{{ route('dashboard') }}" class="text-xl font-bold normal-case hover:underline">{{ auth()->user()->organasation()->name }}</a>
    @endcan
</div>

@script
    <script>
        $wire.on('organisations-updated', () => {
            $wire.fetchOrganisations();
        });
    </script>
@endscript
