@push('buttonstyle-'.$block->id)
    z-20 absolute top-0 h-full bg-gray-700 bg-opacity-0 hover:bg-opacity-75 text-3xl font-bold text-white flex flex-col items-center justify-center focus:outline-none rounded-none
@endpush
    <div class="slider relative w-full flex flex-row relative  {{ $block->blocktype->getCSSName() }}  {{ $block->getBlockCSSName() }}"
         style="{{ $block->styledefinitions->getStyleString() }}"
         id="slider-{{ $block->id }}"
         data-display-duration="{{ ($block->slide_display_duration * 1000) }}"
         data-pagination-duration="{{ ($block->slide_pagination_duration * 1000) }}"
         data-translate="0"
    >
        <div class="slider-inner"
             style="flex-shrink: 1; flex-grow: 1; position: relative "
             id="slider-inner-{{ $block->id  }}"
        >
            <button class="left-0 @stack('buttonstyle-'.$block->id)"
                    onclick="slider{{ $block->id }}.prevSlide()"
                    style="width: 2rem;">&lt;</button>
            @foreach($block->slides as $index => $slide)
                <div class="slider-slide absolute top-0 left-0 w-full flex items-start justify-start flex-grow px-8"
                     id="slider-{{ $block->id }}-slide-{{ $index }}"
                     data-slide-index="{{ $index }}"
                     style="transition: opacity {{ $block->slide_pagination_duration }}s ease-in-out; opacity: {{ $index == 0 ? 1 : 0 }}"
                >
                    @include('blocks.'.$slide->blocktype_id, ['block' => $slide])
                </div>
                @push('sliderbuttons')
                    <span class="slider-button"
                          id="slider-{{ $block->id }}-slider-button-{{ $index }}"
                          data-index="{{ $index }}"
                          onclick="slider{{ $block->id }}.showSlide({{ $index }})"
                          style="padding: .5rem; font-size: 3rem; color: #333745; transition: opacity 200ms ease-in-out; cursor:pointer ">●</span>
                @endpush
            @endforeach
            <button class="right-0 @stack('buttonstyle-'.$block->id)"
                    onclick="slider{{ $block->id }}.prevSlide()"
                    style="width: 2rem;">&gt;</button>

                @if($block->slides->count() > 1)
                    <div style="position: absolute; bottom: 0px; left: 0px; height: 2rem; width: 100%; background-color: transparent; display: flex; align-items: center; justify-content: center; z-index:50; padding-bottom: .5rem">
                        @stack('sliderbuttons')
                    </div>
                @endif
        </div>
    </div>
<script>
    slider{{ $block->id }} = {
        position: 0,
        hovering: false,
        slideCount: {{ $block->slides->count() }},
        sliderNode: document.getElementById('slider-{{ $block->id }}'),
        innerContainer: document.getElementById('slider-inner-{{ $block->id }}'),
        firstSlide: document.getElementById('slider-{{ $block->id }}-slide-0'),
        showSlide: function (position) {
            this.position = position;
            let currentSlide = document.getElementById('slider-{{ $block->id }}-slide-' + position);
            let previousSlide = null;
            if (position > 0) {
                previousSlide = document.getElementById('slider-{{ $block->id }}-slide-' + (position - 1).toString());
            } else {
                previousSlide = document.getElementById('slider-{{ $block->id }}-slide-' + (this.slideCount - 1).toString());
            }
            if (previousSlide != null) {
                previousSlide.style.opacity = 0;
                previousSlide.style.zIndex = 0;
            }
            currentSlide.style.opacity = 1;
            currentSlide.style.zIndex = 10;
            Array.from(this.sliderNode.querySelectorAll('.slider-button')).forEach((button) => {
                if (button.getAttribute('data-index') == position) {
                    button.style.opacity = 1;
                } else {
                    button.style.opacity = .4
                }
            });
        },
        nextSlide: function () {
            this.position++;
            if (this.position == this.slideCount) {
                this.position = 0;
                this.showSlide(0);
            } else {
                this.showSlide(this.position);
            }
        },
        nextSlideNoRollover: function () {
            this.position++;
            if (this.position > this.slideCount) {
                this.position = this.slideCount;
            }
            this.showSlide(this.position);
        },
        prevSlide: function () {
            this.position--;
            if (this.position < 0) {
                this.position =  this.slideCount - 1;
            }
            this.showSlide(this.position);
        },
        resizeSlides: function () {
            let maxHeight = 0;
            Array.from(this.innerContainer.querySelectorAll('.slider-slide')).forEach((slide) => {
                let width = this.sliderNode.getBoundingClientRect().width
                    - parseInt(window.getComputedStyle(this.sliderNode).marginLeft)
                    - parseInt(window.getComputedStyle(this.sliderNode).marginRight);
                slide.style.width = width + 'px';
                slide.style.maxWidth = width + 'px';
                if (slide.getBoundingClientRect().height > maxHeight) {
                    maxHeight = slide.getBoundingClientRect().height;
                }
            });
            Array.from(this.innerContainer.querySelectorAll('.slider-slide')).forEach((slide) => {
                slide.style.height = maxHeight+'px';
            });
            this.sliderNode.style.height = maxHeight+'px';
            this.showSlide(0);
        },
        start: function () {
            this.sliderNode.addEventListener('mouseenter', () => {
                this.hovering = true;
            })
            this.sliderNode.addEventListener('mouseleave', () => {
                this.hovering = false;
            })
            this.resizeSlides();
            if (this.slideCount > 1) {
                window.setInterval(() => {
                    if (!this.hovering) {
                        this.nextSlide();
                    }
                }, {{ (($block->slide_display_duration + $block->slide_pagination_duration) * 1000  ) }});
            }
            window.addEventListener('resize', () => {
                this.resizeSlides();
            })

        }
    }
    slider{{ $block->id }}.start();
</script>

