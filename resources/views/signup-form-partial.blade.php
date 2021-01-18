@foreach($form->getStep($step) as $field => $data)
    <label class="mt-8 mb-2 font-bold">{{ $data['label'] }}</label>
    @if($data['type'] == 'text')
        <input type="{{ $data['subtype'] }}" name="{{ $field }}" id="{{ $field }}" value="{{ $data['value'] }}">
    @endif

@endforeach