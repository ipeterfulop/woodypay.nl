<template>
    <div>
        <button v-on:click="initializePopup"><span v-if="loading" style="margin-right: .5rem" v-html="spinnerSrc"></span>{{ translate('Manage') }}</button>
        <popup :show-close-button="false" :visible="showPopup" v-if="loaded" v-on:close="discardChanges">
            <div style="width: 100%; display: flex; justify-content: flex-start; flex-direction: column; align-items: center">
                <h3 style="text-align: center; width: 100%; margin-bottom: 1rem; font-size: 1.5rem; font-weight: bold;" v-html="windowTitle"></h3>
                <div style="display: flex; flex-direction: column; align-items: stretch; justify-content: flex-start; height: 60vh; overflow-y: auto; max-width: 980px; width: 980px; border-bottom: 1px solid lightgray; border-top: 1px solid lightgray; padding: .5rem">
                    <div v-if="loading" v-html="spinnerSrc"></div>
                    <template v-if="!loading">
                        <div v-for="attribute in attributes">
                            <template v-for="locale in localesForAttribute(attribute)">
                            <div style="display: flex; justify-content: space-between; flex-direction: row; align-items: center; border-bottom: 1px solid lightgray; padding: .2rem">
                                <div style="width: 40%; display: flex; align-items: flex-start; justify-content: flex-start; flex-direction: column"
                                     v-html="attribute.label+locale.label"
                                     v-bind:class="{'text-danger': attribute.value == null || JSON.stringify(attribute.value) == '[]'}"></div>
                                <div style="width: 59%;" :data-locale="locale.id">
                                    <template v-if="attribute.attribute_value_set == null">
                                        <input v-if="attribute.datatype_id == 1"
                                               v-model="attribute['value'+locale.id]"
                                               class="form-control"
                                               type="number"
                                               style="width: 100%; text-align: right">
                                        <input v-if="attribute.datatype_id == 2"
                                               v-model="attribute['value'+locale.id]"
                                               class="form-control"
                                               type="number"
                                               style="width: 100%; text-align: right">
                                        <input v-if="attribute.datatype_id == 3"
                                               v-model="attribute['value'+locale.id]"
                                               class="form-control"
                                               type="text"
                                               style="width: 100%; text-align: right">
                                        <color-picker v-if="attribute.datatype_id == 8"
                                                      v-model="attribute['value'+locale.id]"
                                                      :presets="colorPickerPresets"
                                        >
                                        </color-picker>
                                        <image-picker v-if="attribute.datatype_id == 9"
                                                      :additional-file-types="['image/svg+xml']"
                                                      :fieldname="attribute.id.toString()+'value'+locale.id"
                                                      v-model="attribute['value'+locale.id]"
                                                      :upload-url="operationsUrl"></image-picker>
                                    </template>
                                    <template v-else>
                                        <select v-model="attribute.value" style="width: 100%; text-align: right">
                                            <option v-for="av in attribute.attribute_value_set.attribute_values"
                                                    v-html="av.label"
                                                    v-bind:value="av.id"></option>
                                        </select>
                                    </template>
                                </div>
                            </div>
                        </template>
                        </div>
                    </template>
                </div>
            </div>
            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%; padding-top: 1rem; font-weight: bold" v-if="statusMessage != ''">
                {{ statusMessage }}
            </div>
            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%; padding-top: 1rem">
                <button class="btn btn-primary" v-on:click="saveChanges" :ref="'savebutton'" v-html="translate('Save')"></button>
                <button class="btn btn-secondary" v-on:click="discardChanges" v-html="translate('Cancel')"></button>
            </div>
        </popup>
    </div>
</template>

<script>
    import {spinner} from './mixins/spinner';
    import {translateMixin} from './mixins/translateMixin'
    export default {
        mixins: [spinner, translateMixin],
        props: {
            operationsUrl: {type: String},
            attributegroupId: {},
            windowTitle: {type: String, default: ''},
            colorPickerPresets: {type: Array, default: () => {return []}}
        },
        data: function () {
            return {
                showPopup: false,
                statusMessage: '',
                loaded: false,
                loading: false,
                attributes: [],
                attributevalues: [],
                locales: [],
            }
        },
        mounted() {},
        methods: {
            localesForAttribute: function(attribute) {
                if (attribute.is_translatable == 1) {
                    return this.locales.map((l) => {
                        return {id: '_'+l.id, label: ' ('+l.id.toUpperCase()+')'}
                    });
                } else {
                    return [{id: '', label: ''}]
                }
            },
            saveChanges: function() {
                this.$refs.savebutton.setAttribute('disabled', true);
                window.axios.post(this.operationsUrl, {action: 'saveChanges', attributegroupId: this.attributegroupId, attributes: this.attributes})
                    .then((response) => {
                        this.value = [];
                        this.statusMessage = response.data.message;
                        window.setTimeout(() => {
                            this.showPopup = false;
                        }, 2000);
                    }).catch((error) => {
                    this.statusMessage = error.response.data;
                    this.$refs.savebutton.removeAttribute('disabled');
                });
            },
            fetchData: function() {
                window.axios.post(this.operationsUrl, {attributegroupId: this.attributegroupId, action: 'fetchData'})
                    .then((response) => {
                        this.locales = response.data.locales;
                        let attributes = response.data.attributes.map((attribute) => {
                            let newAttribute = {...attribute};
                            this.localesForAttribute(newAttribute).forEach((locale) => {
                                newAttribute['value'+locale.id] = newAttribute.attributevalue['custom_value'+locale.id];
                            })
                            return newAttribute;
                        });
                        this.attributes = attributes;
                        this.loaded = true;
                        this.loading = false;
                        Vue.nextTick(() => {
                            this.showPopup = true;
                            Vue.nextTick(() => {
                                this.$refs.savebutton.removeAttribute('disabled');
                            })
                        })

                    }).catch((error) => {
                        alert(error.response.data);
                    });
            },
            discardChanges: function() {
                this.showPopup = false;
                this.value = [];
                this.loaded = false;
            },
            initializePopup: function() {
                this.loading = true;
                this.statusMessage = '';
                this.fetchData();
            }
        },
        computed: {},
        watch: {}

    }
</script>
