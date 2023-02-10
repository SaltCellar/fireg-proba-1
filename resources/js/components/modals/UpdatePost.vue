<template>
    <ModalFrame @close:modal="closeModal" :actions="false" title="Bejegyzés szerkesztése" size="6">
        <template #body>
            <Form @form-success="successModel" @form-dispose="closeModal" @form-custom-action="actionModal" :form="this.getForm()" :url="this.$data.url" />
        </template>
    </ModalFrame>
</template>

<script>
    import ModalFrame from "@/components/modal/ModalFrame.vue";
    import Form from "@/components/form/Form.vue";

    export default {
        name: "UpdatePost",
        components: { ModalFrame, Form },
        props: {
            modalId: { type: String, default() { return null; }, },
            data: { type: Object, default() { return null; }, },
        },
        data() {
            return {
                form: {},
                url: null,
                callback: null,
            };
        },
        methods: {
            successModel(response) {
                if (this.$data.callback !== undefined) { this.$data.callback(response.updated); }
                this.closeModal();
            },
            openModal(callback) {
                this.$data.callback = callback;
            },
            closeModal() {
                window.vue.ModalManager.closeModal(this.$props.modalId);
            },

            actionModal(action) {
                if (action === 'delete') {

                    window.vue.ModalManager.openModal('confirm',{
                        title: 'Törlés',
                        text: 'Biztos törölni szeretné a "' + this.$props.data.name + '" nevü bejegyzést ?',
                        confirm: 'Törlés',
                    },(res) => {
                        if (res) {
                            axios.delete('/api/post/'+this.$props.data.id).then(res => {
                                if (res.status === 200 && res.data.error === false) {
                                    if (this.$data.callback !== undefined) {
                                        this.$data.callback({
                                            'DELETED': true,
                                            'ID': this.$props.data.id,
                                        });
                                    }
                                }
                                this.closeModal();
                            });
                        }
                    });

                } else {
                    this.closeModal();
                }
            },

            // FORM
            getForm() {
                return {
                    url: '/api/post/' + this.$props.data.id,
                    update: true,
                    actions: [
                        { label: 'Mégsem', neg: true, action: null, },
                        { label: 'Törlés', neg: true, action: 'delete', },
                        { label: 'Mentés', neg: false, action: 'post', },
                    ],
                    form: {
                        'site': { value: this.$props.data.site.id, error: '', type: { name: 'select', label: 'Telephely', config: { fetch_url: '/api/sites?limit=100', fetch_attr: 'name' }, }, },
                        'innerid': { value: this.$props.data.innerid, error: '', type: { name: 'field', label: 'Belső azonosító', config: { type: 'text', }, }, },
                        'name': { value: this.$props.data.name, error: '', type: { name: 'field', label: 'Megnevezés (Készenléti h.)', config: { type: 'text', }, }, },
                        'extinguisher_type': { value: this.$props.data.extinguisher_type.id, error: '', type: { name: 'select', label: 'Készülék típus', config: { fetch_url: '/api/extinguisher_types?limit=100', fetch_attr: 'name' }, }, },
                        'fa_no': { value: this.$props.data.fa_no, error: '', type: { name: 'field', label: 'Gyári szám', config: { type: 'text', }, }, },
                        'fa_date': { value: this.$props.data.fa_date, error: '', type: { name: 'field', label: 'Gyári év', config: { type: 'text', }, }, },
                        'comment': { value: this.$props.data.comment, error: '', type: { name: 'field', label: 'Megjegyzés', config: { type: 'text', }, }, },
                    },
                    extend: {}
                };
            },

        },
        mounted() {

        },
    }
</script>
