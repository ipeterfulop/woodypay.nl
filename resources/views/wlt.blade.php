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
            overflow: hidden;
            transition: width 300ms ease-in-out, opacity 300ms ease-in-out, height 300ms ease-in-out;
        }
    </style>
        <div class="block-container mt-64" style="background-color: white"
        >
            <div class="w-full max-width-container flex items-start justify-center container overflow-x-hidden ">
                <div class="flex flex-row items-start justify-start w-full" style="max-width: 100%; overflow-x: hidden" id="{{ $formId }}">
                </div>
            </div>
        </div>
    <script>
        function getStep(index) {
            Array.from(document.querySelectorAll('.multistep-next-button')).forEach((b) => {
                b.setAttribute('disabled', true);
                b.classList.add('animate-pulse');
            });
            let prev = (index - 1).toString();
            let form = document.getElementById('{{ $formId }}');
            let prevSlide = document.querySelector('.form-slide[data-step="'+prev+'"]');
            let formdata = {};
            Array.from(form.querySelectorAll('.multipart-formelement')).forEach((item) => {
                formdata[item.id] = item.value;
            })
            Array.from(form.querySelectorAll('.multipart-error-field')).forEach((item) => {
                item.innerHTML = '';
            })
            formdata['step'] = index;
            formdata['currentStep'] = prev;
            fetch('{{ $endpoint }}', {
                method: 'POST',
                mode: 'same-origin',
                cache: 'no-cache',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify(formdata),
            }).then((response) => {
                if (response.status == 200) {
                    response.text().then((text) => {
                        let slide = document.createElement('div');
                        slide.classList.add('form-slide', 'flex-shrink-0', 'w-full');
                        slide.style.width = '0px';
                        slide.setAttribute('data-step', index);
                        slide.innerHTML = text;
                        form.appendChild(slide);
                        if (prevSlide != null) {
                            prevSlide.style.height = '0px';
                            prevSlide.style.opacity = '0';
                            prevSlide.style.width = '0px';
                        }
                        slide.style.width = '100%';
                    })
                }
                if (response.status == 422) {
                    response.json().then((data) => {
                        Object.keys(data.errors).forEach((field) => {
                            document.getElementById(field+'-error').innerHTML = data.errors[field];
                        });
                        Array.from(document.querySelectorAll('.multistep-next-button')).forEach((b) => {
                            b.removeAttribute('disabled');
                            b.classList.remove('animate-pulse');
                        })

                    })
                }

            })
            //document.querySelector('.form-slide[data-step="'+index.toString()+'"]').style.width = '100%';
        }

        getStep(1);
    </script>
@endsection
