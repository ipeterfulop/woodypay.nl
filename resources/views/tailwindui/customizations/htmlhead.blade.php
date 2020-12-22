<script>
    window.laravelLocale = '{{ \App::getLocale() }}'
    window.laravelLocales = {'hu': {}};
    window.laravelTranslations = JSON.parse(atob('{!! str_replace('\\"','\\\\"', app()->make('translation')->getCachedJSONTranslations(\App::getLocale()))  !!}'))
</script>
<style>
    .form-group label {
        margin-top: 2rem;
    }
</style>
