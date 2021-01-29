<div class="flex items-center justify-start flex-col p-4 form-slide" data-step="{{ $currentStep }}">
    <h2 class="text-center w-full font-bold text-2xl">{{ $step->title }}</h2>
    <p class="text-center my-4">{{ $step->description }}</p>
    @foreach($step->fields as $field => $data)
        <label class="mt-2 mb-2 font-bold">{{ $data['label'] }}</label>
        @if($data['type'] == 'text')
            <input type="{{ $data['subtype'] }}"
                   name="{{ $field }}"
                   id="{{ $field }}"
                   class="multipart-formelement border border-gray-300 focus:shadow-md p-1 text-center"
                   value="{{ $data['value'] ?? '' }}"
            >
        @endif
        @if($data['type'] == 'hidden')
            <input type="hidden"
                   name="{{ $field }}"
                   id="{{ $field }}"
                   value="{{ $data['value'] ?? '' }}"
            >
        @endif
        @if($data['type'] == 'select')
            <select
                   name="{{ $field }}"
                   id="{{ $field }}"
                   class="multipart-formelement border border-gray-300 focus:shadow-md p-1 bg-white"
            >
                @foreach($data['valueset'] as $id => $label)
                    <option value="{{ $id }}"
                    @if($data['value'] == $id) selected @endif
                    >{{ $label }}</option>
                @endforeach
        @endif

        <label class="text-red-500 w-full text-sm multipart-error-field mb-4 text-center" id="{{ $field }}-error"></label>

    @endforeach
    <div class="w-full my-4 flex items-center justify-end">
        <button type="button" onclick="getStep({{ $nextIndex }})" class="bg-lightblue py-2 px-4 multistep-next-button">Next</button>
    </div>
</div>
