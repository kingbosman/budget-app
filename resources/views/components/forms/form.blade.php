@props([
    'method' => false,
    'button' => 'Submit',
])
@php
    $type = "GET";
    if ($method && strtolower($method) !== 'get') $type = "POST";
@endphp
<form {{ $attributes(['method' => $type]) }}>
    @csrf
    @if($method && !in_array(strtolower($method), ['get', 'post']))
        @method($method)
    @endif


    <div class="space-y-12">
        <div class="border-b border-gray-900/10 pb-12">
            {{ $slot }}
        </div>
    </div>

    <x-forms.button>{{ $button }}</x-forms.button>

</form>
