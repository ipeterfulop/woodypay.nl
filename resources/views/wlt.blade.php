@extends('layouts.app')
@section('content')
    <style>
        .max-width-container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .max-width-container>:first-child{
            width: 100%;
            max-width: 1430px;
        }
        .slider-slide > div {
            height: 100%;
            flex-grow: 1;
        }
        .form-slide {
            overflow-x: hidden;
            transition: width 300ms ease-in-out, opacity 300ms ease-in-out;
        }
    </style>
        <div class="block-container mt-64" style="background-color: white"
        >
            <div class="w-full max-width-container flex items-start justify-center container ">
                <form method="post" class="flex flex-row items-start justify-start" >
                    @csrf
                    <div class="form-slide" style="width: 100%" data-step="1">
                        <div class="flex items-start justify-start flex-col p-4">
                        <input type="text" placeholder="Stage 1 input" class="my-4">
                        <input type="text" placeholder="Stage 1 input" class="my-4">
                        <input type="text" placeholder="Stage 1 input" class="my-4">
                        <div class="w-full my-4 flex items-center justify-end">
                            <button type="button" onclick="proceedTo(2)" class="bg-lightblue py-2 px-4">Next</button>
                        </div>
                        </div>
                    </div>
                    <div class="form-slide" style="width: 0px" data-step="2">
                        <div class="flex items-start justify-start flex-col p-4">
                        <input type="text" placeholder="Stage 2 input" class="my-4">
                        <input type="text" placeholder="Stage 2 input" class="my-4">
                        <input type="text" placeholder="Stage 2 input" class="my-4">
                        <div class="w-full my-4 flex items-center justify-end">
                            <button type="button" onclick="proceedTo(3)" class="bg-lightblue py-2 px-4">Next</button>
                        </div>
                        </div>
                    </div>
                    <div class="form-slide" style="width: 0px" data-step="3">
                        <div class="flex items-start justify-start flex-col p-4">
                        All done, thank you!
                    </div>
                    </div>
                </form>
            </div>
        </div>
    <script>
        function getStep(index) {
            let prev = (index - 1).toString();
            let prevSlide = document.querySelector('.form-slide[data-step="'+prev+'"]');
            if (prevSlide != null) {
                prevSlide.style.width = '0px';
                prevSlide.style.opacity = '0';
            }
            let slide = document.createElement('div');
            slide.classList.add('form-slide');
            slide.style.width = '0px';
            slide.setAttribute('data-step', index);

            document.querySelector('.form-slide[data-step="'+index.toString()+'"]').style.width = '100%';
        }
    </script>
@endsection
