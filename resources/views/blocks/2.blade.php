<style>{!! \App\BlockStyledefinition::getCSSClasses($block) !!}</style>
<div class="w-full max-width-container flex items-start justify-center">
    <div class="flex flex-col-reverse @if($block->positioning->code == 'left') md:flex-row-reverse @else md:flex-row @endif  w-full justify-between  {{ $block->getBlockCSSName() }}"  style="background-size: cover">
        <div class="w-full md:w-1/2 flex flex-col items-center justify-center py-16 px-4">
            <h1 class="w-full text-center px-3" style="">{!! $block->title !!}</h1>
            <div class="py-4">{!! $block->content !!}</div>
            @if($block->button_label != null)
                <a href="{{ $block->button_url }}" class="button" style=""  @if($block->should_open_button_url_in_new_window == 1) target="_blank" @endif>
                    {{ $block->button_label }}
                </a>
            @endif
        </div>
        <div class="w-full md:w-1/2 flex-col items-end justify-center py-16">
            <div class="overflow-x-hidden w-full h-full flex items-center justify-end" >
                <img src="/images{{ $block->topic_image }}" class="object-contain rounded-xl">
            </div>
        </div>
    </div>
</div>