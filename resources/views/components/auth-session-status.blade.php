@props(['status'])

@if ($status)
    {{-- <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600']) }}>
        {{ $status }}
    </div> --}}
    <div {{ $attributes->merge(['class' => 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative']) }} role="alert">
        <span class="block sm:inline">{{ $status }}</span>
    </div>
@endif
