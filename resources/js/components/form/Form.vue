<template>
    <div :class="['form',this.$data.loading ? 'loading' : '']">

        <div class="form-inputs">

            <InputRow v-for="(data,name) in this.$data.modelType.field" :order="data.order" :label="data.label" :error="this.$data.model[name].error">
                <Field @send-input="sendInput" :value="this.$data.model[name].value" :type="data.type" :name="name" />
            </InputRow>

            <InputRow v-for="(data,name) in this.$data.modelType.select" :order="data.order" :label="data.label" :error="this.$data.model[name].error">
                <Select @send-input="sendInput" :value="this.$data.model[name].value" :options="data.options" :name="name" />
            </InputRow>

        </div>

        <div class="form-actions">

            <Button v-for="action in this.$data.actions" @click="sendAction(action.action)" :text="action.label" :neg="action.neg" />

        </div>

    </div>
</template>

<script>
    import InputRow from "@/components/ui/InputRow.vue";

    import Button from "@/components/ui/Button.vue";

    import Field from "@/components/ui/input/Field.vue";
    import Select from "@/components/ui/input/Select.vue";

    export default {
        name: "Form",
        components: { InputRow, Button, Field, Select },
        props: {
            form: { type: Object, default() { return {}; }, },
            url: { type: String, default() { return null; }, },
        },
        data() {
            return {
                loading: false,
                loadcap: 0,
                actions: {},
                modelType: {
                    field:  {},
                    select: {},
                },
                model: {
                },
            };
        },
        methods: {
            sendInput(data) {
                this.$data.model[data.name].value = data.value;
                //console.log({'name': data.name, 'value': data.value});
            },
            sendAction(action) {
                switch (action) {
                    case 'post' : { this.actionPost(); break; }
                    case 'reset' : { this.actionReset(); break; }
                    default : {
                        if (action) {
                            // Custom Action
                            this.actionCustom(action);
                        } else {
                            this.actionDispose();
                        }
                    }
                }
            },

            // ACTIONS

            actionPost() {
                this.startLoading();
                this.clearErrors();
                let payload = this.getPayload();

                if (this.$props.form.update) {
                    axios.put(this.$props.form.url,payload).then(res => {
                        this.stopLoading();
                        this.actionPostCore(res);
                    });
                } else {
                    axios.post(this.$props.form.url,payload).then(res => {
                        this.stopLoading();
                        this.actionPostCore(res);
                    });
                }

            },
            actionPostCore(res) {
                if (res.data.error !== undefined) {
                    if (res.data.error === false) {
                        this.$emit('form-success',res.data);
                        this.clearForm();
                    } else {
                        if (res.data.error.params !== undefined) {
                            Object.entries(res.data.error.params).forEach(([name,errorMessageArray],i) => {
                                this.$data.model[name].error = errorMessageArray[0];
                            });
                        }
                    }
                }
            },

            actionCustom(action) {
                this.$emit('form-custom-action',action);
            },

            actionReset() {
                this.clearForm();
            },
            actionDispose() {
                this.$emit('form-dispose',true);
            },

            // LOADING

            startLoading() {
                this.$data.loadcap++;
                if (!this.loading) {
                    this.loading = true;
                }
            },
            stopLoading() {
                if (this.$data.loadcap > 0) {
                    this.$data.loadcap--;
                }
                if (this.loadcap < 1) {
                    this.loading = false;
                }
            },

            // OPTIONS

            loadOptions(name,url,attribute) {
                this.startLoading();
                axios.get(url).then(res => {
                    if (res.status === 200 && res.data.error === false) {
                        let options = {};
                        Object.values(res.data.results).forEach(item => {
                            options [ item.id ] = item[attribute];
                        });
                        this.$data.modelType.select[name]['options'] = options;
                    }
                    this.stopLoading();
                });
            },

            // FORM MANAGEMENT

            getPayload() {
                let payload = this.$props.form.extend ? this.$props.form.extend : {};
                Object.entries(this.$data.model).forEach(([name,value],i) => {
                    payload[name] = value.value;
                });
                return payload;
            },

            clearErrors() {
                Object.keys(this.$data.model).forEach(name => {
                    this.$data.model[name].error = null;
                });
            },
            clearForm() {
                Object.keys(this.$data.model).forEach(name => {
                    this.$data.model[name].error = null;
                    this.$data.model[name].value = null;
                });
            },
        },
        mounted() {
            // Register Actions
            if (this.$props.form.actions) {
                Object.values(this.$props.form.actions).forEach((action,index) => {
                    this.$data.actions[index] = action;
                });
            }
            // Register Inputs
            if (this.$props.form.form) {
                Object.entries(this.$props.form.form).forEach(([formName,formItem],index) => {

                    switch (formItem.type.name) {

                        case 'field': {
                            this.$data.model[formName] = { value: formItem.value, error: formItem.error };
                            this.$data.modelType.field[formName] = {
                                order: index,
                                label: formItem.type.label,
                                type: formItem.type.config.type
                            };
                            break;
                        }

                        case 'select': {
                            this.$data.model[formName] = { value: formItem.value, error: formItem.error };
                            this.$data.modelType.select[formName] = {
                                order: index,
                                label: formItem.type.label,
                                options: {},
                            };

                            // Options from FORM props
                            if (formItem.type.config.options !== undefined) {
                                this.$data.modelType.select[formName]['options'] = formItem.type.config.options;
                            } else {

                                // Options from API
                                if (formItem.type.config.fetch_url !== undefined) {
                                    let fetchAttribute = formItem.type.config.fetch_attr ? formItem.type.config.fetch_attr : 'name';
                                    this.loadOptions(formName,formItem.type.config.fetch_url,fetchAttribute);
                                }
                            }

                            break;
                        }
                    }

                });
            }

        },
    }
</script>

<style scoped>
    .form.loading {
        opacity: 0.5;
        pointer-events: none;
    }
    .form > .form-inputs {
        display: flex;
        flex-direction: column;
        padding-top: 10px;
    }
    .form > .form-actions {
        display: flex;
        justify-content: flex-end;
    }
</style>
