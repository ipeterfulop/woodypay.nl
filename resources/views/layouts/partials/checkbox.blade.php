<div class="relative flex items-start">
    <div class="flex items-center h-5">
        <input id="{{ $field }}" name="{{ $field }}" type="checkbox"
               class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
    </div>
    <div class="ml-3 text-sm">
        <label for="{{ $field }}" class="font-medium text-gray-700">{!! $label  !!}</label>

    </div>
</div>
@error($field)
<div class="mt-1 sm:mt-0 sm:col-span-2 text-red-600 py-3 rounded-md font-bold">
    {{ $message }}
</div>
@enderror
