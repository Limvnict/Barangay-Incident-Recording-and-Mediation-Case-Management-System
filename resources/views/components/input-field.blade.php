@props(['label', 'name', 'value' => '', 'type' => 'text', 'options' => []])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium mb-1">{{ $label }}</label>

    @if ($type === 'textarea')
        <textarea id="{{ $name }}" name="{{ $name }}" rows="5"
            {{ $attributes->merge(['class' => 'w-full border border-gray-300 rounded-lg p-2']) }}>{{ old($name, $value) }}</textarea>
    @elseif ($type === 'select')
        <select id="{{ $name }}" name="{{ $name }}"
            {{ $attributes->merge(['class' => 'w-full border border-gray-300 rounded-lg p-2']) }}>
            @foreach ($options as $option)
                <option value="{{ $option }}" @selected(old($name, $value) === $option)>{{ $option }}</option>
            @endforeach
        </select>
    @else
        <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}"
            @if ($type !== 'password') value="{{ old($name, $value) }}" @endif
            {{ $attributes->merge(['class' => 'w-full border border-gray-300 rounded-lg p-2']) }}>
    @endif

    @error($name)
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>
