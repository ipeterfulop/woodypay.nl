<template>
    <div>
        <button v-on:click="initializePopup"><span v-if="loading" style="margin-right: .5rem" v-html="spinnerSrc"></span>{{ translate('Manage') }}</button>
        <popup :show-close-button="false" :visible="showPopup" v-if="loaded" v-on:close="discardChanges">
            <child-item-manager :title="translate('Items')"
                                :operations-url="operationsUrl"
                                :edit-form-props="editFormProps"

            ></child-item-manager>
            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%; padding-top: 1rem; font-weight: bold" v-if="statusMessage != ''">
                {{ statusMessage }}
            </div>
            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%; padding-top: 1rem">
                <button class="btn btn-primary" v-on:click="showPopup = false" :ref="'savebutton'">{{ translate('Close') }}</button>
            </div>
        </popup>
    </div>
</template>

<script>
    import {spinner} from './mixins/spinner'
    import {translateMixin} from './mixins/translateMixin'
    export default {
        mixins: [spinner, translateMixin],
        props: {
            operationsUrl: {type: String},
            subjectId: {},
        },
        data: function () {
            return {
                showPopup: false,
                editFormProps: () => {return {}},
                value: [],
                statusMessage: '',
                loaded: false,
                loading: false,
            }
        },
        mounted() {
        },
        methods: {
            initializePopup: function() {
                this.loading = true;
                this.statusMessage = '';
                window.axios.post(this.operationsUrl, {action: 'getChildItemProps', subjectId: this.subjectId})
                    .then((response) => {
                        this.editFormProps = response.data.props;
                        this.loaded = true;
                        this.loading = false;
                        Vue.nextTick(() => {
                            this.showPopup = true;
                            Vue.nextTick(() => {
                                this.$refs.savebutton.removeAttribute('disabled');
                            })
                        })
                    })

            }
        },
        computed: {},
        watch: {}

    }
</script>
