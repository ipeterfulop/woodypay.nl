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
        height: 0px !important;
    }
    .model-manager-main-body td a {
        text-decoration: underline;
        color: darkblue;
    }
    .vuecrud-internal_name-td {
        max-width: 15rem;
        overflow-x: hidden;
    }
    .vuecrud-block_type_label-td {
        max-width: 8rem;
        white-space: normal !important;
    }
    .vuecrud-content_translated-td {
        max-width: 20rem;
        overflow:hidden;
        text-overflow: ellipsis;
    }
</style>
