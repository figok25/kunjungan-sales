@props(['name', 'value' => null, 'required' => false])

<div x-data="{
        raw: {{ $value !== null && $value !== '' ? (int) $value : 0 }},
        display: '{{ $value !== null && $value !== '' ? number_format((float) $value, 0, ',', '.') : '' }}',
        onInput(e) {
            const digits = e.target.value.replace(/\D/g, '');
            this.raw = digits ? parseInt(digits, 10) : 0;
            this.display = this.raw ? this.raw.toLocaleString('id-ID') : '';
        }
     }">
    <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 text-sm">Rp</span>
        <input
            type="text"
            inputmode="numeric"
            autocomplete="off"
            :value="display"
            @input="onInput($event)"
            {{ $attributes->merge(['class' => 'w-full border-gray-300 rounded-md shadow-sm pl-9']) }}
            @if ($required) required @endif
        >
    </div>
    <input type="hidden" name="{{ $name }}" :value="raw">
</div>
