<style>{!! \App\BlockStyledefinition::getCSSClasses($block) !!}</style>
<div class="w-full max-width-container flex items-start justify-center">
    <div class="flex flex-col items-center justify-start py-16 px-4 {{ $block->getBlockCSSName() }}" style="background-size: cover">
        <div class="flex items-start justify-start">
            <img src="/storage/attachments/{{ $block->site_logo_translated }}">
        </div>
        <div class="flex flex-col md:flex-row items-start justify-start w-full">
            <div class="w-full md:w1/4">{!! $block->row_2_content_1_translated !!}</div>
            <div class="w-full md:w1/4">{!! $block->row_2_content_2_translated !!}</div>
            <div class="w-full md:w1/4">{!! $block->row_2_content_3_translated !!}</div>
            <div class="w-full md:w1/4">{!! $block->row_2_content_4_translated !!}</div>
        </div>
        <div class="flex flex-col md:flex-row items-start justify-start w-full">
            <div class="w-full md:w1/4">{!! $block->row_3_content_1_copyright_translated !!}</div>
            <div class="w-full md:w1/4">{!! $block->row_3_content_2_imprint_translated !!}</div>
            <div class="w-full md:w1/4">{!! $block->row_3_content_3_terms_of_use_translated !!}</div>
            <div class="w-full md:w1/4">{!! $block->row_3_content_4_privacy_translated !!}</div>
        </div>

    </div>
</div>