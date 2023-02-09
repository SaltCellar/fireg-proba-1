<template>
    <ModalFrame @close:modal="closeModal" :actions="false" title="Bejegyzés létrehozása" size="6">
        <template #body>
            <Form @form-success="successModel" @form-dispose="closeModal" :form="getForm()" />
        </template>
    </ModalFrame>
</template>

<script>
    import ModalFrame from "@/components/modal/ModalFrame.vue";
    import Form from "@/components/form/Form.vue";

    export default {
        name: "CreatePost",
        components: { ModalFrame, Form },
        props: {
            modalId: { type: String, default() { return null; }, },
            data: { type: Object, default() { return null; }, },
        },
        data() {
            return {
                callback: null,
            };
        },
        methods: {
            successModel(response) {
                if (this.$data.callback !== undefined) { this.$data.callback(response.created); }
                this.closeModal();
            },
            openModal(callback) {
                this.$data.callback = callback;
            },
            closeModal() {
                window.vue.ModalManager.closeModal(this.$props.modalId);
            },

            // FORM
            getForm() {
                return {
                    url: '/api/posts',
                    actions: [
                        { label: 'Mégsem', neg: true, action: null, },
                        { label: 'Létrehozás', neg: false, action: 'post', },
                    ],
                    form: {
                        'site': { value: '', error: '', type: { name: 'select', label: 'Telephely', config: { fetch_url: '/api/sites?limit=100', fetch_attr: 'name' }, }, },
                        'innerid': { value: '', error: '', type: { name: 'field', label: 'Belső azonosító', config: { type: 'text', }, }, },
                        'name': { value: '', error: '', type: { name: 'field', label: 'Megnevezés (Készenléti h.)', config: { type: 'text', }, }, },
                        'extinguisher_type': { value: '', error: '', type: { name: 'select', label: 'Készülék típus', config: { fetch_url: '/api/extinguisher_types?limit=100', fetch_attr: 'name' }, }, },
                        'fa_no': { value: '', error: '', type: { name: 'field', label: 'Gyári szám', config: { type: 'text', }, }, },
                        'fa_date': { value: '', error: '', type: { name: 'field', label: 'Gyári év', config: { type: 'text', }, }, },
                        'comment': { value: '', error: '', type: { name: 'field', label: 'Megjegyzés', config: { type: 'text', }, }, },
                        'mult': { value: '', error: '', type: { name: 'select', label: 'Többszörösítés', config: { options: { '1': 'Ne', '2': '2 db', '3': '3 db', '4': '4 db', '5': '5 db', '6': '6 db', '7': '7 db' }, }, }, },
                    },
                    extend: {
                        'board': this.$props.data,
                    }
                };
            },


        },
        mounted() {

        },
    }
</script>

<style scoped>

</style>
