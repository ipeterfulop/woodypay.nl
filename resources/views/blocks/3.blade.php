<style>{!! \App\BlockStyledefinition::getCSSClasses($block) !!}</style>
<div class="w-full max-width-container flex items-start justify-center">
    <div class="flex flex-col md:flex-row w-full justify-between  {{ $block->getBlockCSSName() }}"  style="background-size: cover">
        <div class="w-full flex flex-col items-center justify-center py-16 px-4">
            <h1 class="w-full text-center px-3" style="">{!! $block->title !!}</h1>
            @if($block->button_label != null)
                <a href="{{ $block->button_url }}" class="button" style="" @if($block->should_open_button_url_in_new_window == 1) target="_blank" @endif>
                    {{ $block->button_label }}
                </a>
            @endif
        </div>
    </div>
</div>