<template>
    <div class="w-full flex flex-col items-start justify-start">
        <h3 class="font-bold">
            <span v-html="translate('Link block to another page')"></span>:&nbsp;<span v-html="subject.internal_name"></span>
        </h3>
        <select v-model="page" class="form-control my-6">
            <option v-for="p in filteredPages"
                    v-html="p.name_en"
                    :value="p.id"></option>
        </select>
        <div v-if="error != ''" v-html="error" class="py-4 text-red-700"></div>
        <div class="w-full flex space-between">
            <button v-on:click="copyBlock" v-html="translate('Link')"></button>
            <button v-on:click="$emit('component-canceled')" v-html="translate('Cancel')"></button>
        </div>
    </div>

</template>

<script>
    import {translateMixin} from "./mixins/translateMixin";

    export default {
        mixins: [translateMixin],
        props: {
            operationsUrl: {},
            pages: {type: Array},
            subject: {},
        },
        data: function () {
            return {
                page: 0,
                error: '',
            }
        },
        mounted() {
        },
        methods: {
            copyBlock: function() {
                this.error = '';
                if (this.page > 0) {
                    window.axios.post(this.operationsUrl, {block: this.subject.id, page: this.page})
                        .then((response) => {
                            this.$emit('submit-success');
                        }).catch((error) => {
                            this.error = error.response.data;
                        });
                } else {
                    this.error = this.translate('Please select a page to copy to');
                }
            }
        },
        computed: {
            filteredPages: function() {
                return this.pages.filter((item) => {
                    return item.id != this.subject.page_id;
                })
            }
        },
        watch: {}

    }
</script>
