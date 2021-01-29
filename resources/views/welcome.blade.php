@extends('layouts.app')
@section('content')
    <style>
        .max-width-container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .max-width-container>:first-child {
            width: 100%;
            max-width: 970px;
        }
        .slider-slide > div {
            height: 100%;
            flex-grow: 1;
        }
    </style>
    <form method="post" class="mt-64">
        @csrf
        <button type="submit">posztolj</button>
    </form>
    <script>!function(){var a=window.VL=window.VL||{};return a.instances=a.instances||{},a.invoked?void(window.console&&console.error&&console.error("VL snippet loaded twice.")):(a.invoked=!0,void(a.load=function(b,c,d){var e={};e.publicToken=b,e.config=c||{};var f=document.createElement("script");f.type="text/javascript",f.id="vrlps-js",f.defer=!0,f.src="https://app.viral-loops.com/client/vl/vl.min.js";var g=document.getElementsByTagName("script")[0];return g.parentNode.insertBefore(f,g),f.onload=function(){a.setup(e),a.instances[b]=e},e.identify=e.identify||function(a,b){e.afterLoad={identify:{userData:a,cb:b}}},e.pendingEvents=[],e.track=e.track||function(a,b){e.pendingEvents.push({event:a,cb:b})},e.pendingHooks=[],e.addHook=e.addHook||function(a,b){e.pendingHooks.push({name:a,cb:b})},e.$=e.$||function(a){e.pendingHooks.push({name:"ready",cb:a})},e}))}();var campaign=VL.load("uaylZ3Ta8l5tzjBKzhd00YBLyN8",{autoLoadWidgets:!0});</script>
    @if(isset($dataset))
        <div data-vl-widget="embedForm"></div>
        <script>
            campaign.identify({
                firstname: '{{ $dataset['firstname'] }}',
                lastname: '{{ $dataset['lastname'] }}',
                email: '{{ $dataset['email'] }}',
                "extraData": '{!! json_encode($dataset['extraData']) !!}'
            }, function() {
                //optional callback
            });
        </script>
        {!! print_r($dataset) !!}
    @endif
@endsection
