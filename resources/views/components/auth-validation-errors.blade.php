@props(['errors'])

@if ($errors->any())
    {{-- <div {{ $attributes }}>
        <div class="font-medium text-red-600">
            {{ __('Whoops! Something went wrong.') }}
        </div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div> --}}

    @foreach ($errors->all() as $error)
        <div {{ $attributes->merge(['class' => 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative']) }} role="alert">
            <span class="block sm:inline">{{ $error }}</span>
        </div>
    @endforeach
@endif
