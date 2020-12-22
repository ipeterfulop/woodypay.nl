<template>
    <div class="w-full flex flex-col">
        <div class="text-xl font-bold w-full py-4"
             v-html="title"></div>
    </div>
</template>

<script>
    export default {
        props: {
            operationsUrl: {type: String},
            title: {type: String}
        },
        data: function () {
            return {}
        },
        mounted() {
        },
        methods: {},
        computed: {},
        watch: {}

    }
</script>
