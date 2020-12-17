<label for="{{ $field }}" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 @error($field) text-red-700 @enderror">
    {{ $label }}
</label>
<div class="mt-1 sm:mt-0 sm:col-span-2">
    <input type="{{ $type ?? 'text' }}"
           name="{{ $field }}"
           id="{{ $field }}"
           value="{{ $value ?? '' }}"
           class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 @error($field) border-red-700 @enderror rounded-md"
    >
</div>
@error($field)
    <div class="mt-1 sm:mt-0 sm:col-span-2 text-red-600 py-3 rounded-md font-bold">
        {{ $message }}
    </div>
@enderror
