<script>
    window.laravelLocale = '{{ \App::getLocale() }}'
    window.laravelLocales = {'hu': {}};
    window.laravelTranslations = JSON.parse(atob('{!! str_replace('\\"','\\\\"', app()->make('translation')->getCachedJSONTranslations(\App::getLocale()))  !!}'))
</script>
<style>
    .form-group label {
        margin-top: 2rem;
    }
    .hidden-important {
        visibility: hidden !important;
    }
    .model-manager-main-body td a {
        text-decoration: underline;
        color: darkblue;
    }
</style>
