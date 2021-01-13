<div class="w-full max-width-container flex items-start justify-center">
    <div class="flex flex-col-reverse md:flex-row w-full justify-between {{ $block->getBlockCSSName() }}"   style="background-size: cover">
        <div class="w-full flex flex-col items-start justify-start py-8 lg:py-32 px-4 lg:px-32">
            <h1 class="w-full text-left text-3xl lg:text-5xl" style="">{!! $block->getItemsContainer()->title_translated !!}</h1>
            <div class="py-4">{!! $block->getItemsContainer()->content_translated !!}</div>
            <div class="w-full flex flex-col-reverse lg:flex-row">
                <ul class="w-full lg:w-1/2 flex items-start justify-start flex-col mt-16 opacity-0" id="list-{{ $block->id }}-container">
                    @foreach($block->getItemsContainer()->items as $index => $item)
                        <li class="flex flex-col items-stretch justify-start py-8 border-b border-gray-400 w-full"
                            data-block-id="{{ $index }}"
                            id="listitem-{{ $block->id.'-'.$index }}"
                        >
                            <h3 class="cursor-pointer text-xl font-bold leading-6"
                                data-image-url="{{ (string)$item->image_url == '' ? $item->image_url :  '/storage/attachments/'.$block->getItemsContainer()->topic_image_translated }}"                            >{{ $item->title_translated }}</h3>
                            <div class="pt-4 overflow-y-hidden"
                                 id="listitem-{{ $block->id.'-'.$index }}-content"
                                 style="transition: height 300ms ease-in-out"
                             >{!! $item->content_translated !!}</div>
                        </li>
                    @endforeach
                </ul>
                <div class="overflow-x-hidden w-full h-full flex items-center justify-end">
                    <img id="list-{{ $block->id }}-image"  class="object-contain rounded-xl">
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    function initAccordion{{ $block->id }}() {
        let container{{ $block->id }} = document.getElementById('list-{{ $block->id }}-container')
        container{{ $block->id }}.querySelectorAll('li > div').forEach((i) => {
            i.setAttribute('data-height', i.getBoundingClientRect().height);
            i.style.height = '0px';
        });
        container{{ $block->id }}.querySelectorAll('li > h3').forEach((i) => {
            i.addEventListener('click', (event) => {
                if (event.target.classList.contains('accordion-item-open')) {
                    event.target.classList.remove('accordion-item-open');
                    let d = event.target.parentNode.querySelector('div');
                    d.style.height = '0px';
                    document.getElementById('list-{{ $block->id }}-image').setAttribute(
                        'src',
                        ''
                    );
                    return;
                }
                container{{ $block->id }}.querySelectorAll('li').forEach((d) => {
                    d.querySelector('h3').classList.remove('accordion-item-open');
                    d.querySelector('div').style.height = '0px'
                });
                event.target.classList.add('accordion-item-open');
                let d = event.target.parentNode.querySelector('div');
                d.style.height = d.getAttribute('data-height')+'px';
                document.getElementById('list-{{ $block->id }}-image').setAttribute(
                    'src',
                    event.target.getAttribute('data-image-url')
                );
            });
            i.setAttribute('data-height', i.getBoundingClientRect().height);
        });

        container{{ $block->id }}.classList.remove('opacity-0');
    }

    initAccordion{{ $block->id }}()
</script>