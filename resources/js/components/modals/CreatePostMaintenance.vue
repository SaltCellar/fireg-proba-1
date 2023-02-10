<template>
    <ModalFrame @close:modal="closeModal" :actions="false" title="Karbantartás felvétele" size="6">
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
                boardPost: null,
                callback: null,
            };
        },
        methods: {
            successModel(response) {
                if (this.$data.callback !== undefined) { this.$data.callback(response.created[0]); }
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
                    url: '/api/maintenances',
                    actions: [
                        { label: 'Mégsem', neg: true, action: null, },
                        { label: 'Létrehozás', neg: false, action: 'post', },
                    ],
                    form: {
                        'type': { value: '', error: '', type: { name: 'select', label: 'Karbantartás Típusa', config: { fetch_url: '/api/maintenance_types?limit=100', fetch_attr: 'name' }, }, },
                        'date': { value: window.getDate(), error: '', type: { name: 'field', label: 'Dátum', config: { type: 'text', }, }, },
                        'comment': { value: '', error: '', type: { name: 'field', label: 'Megjegyzés', config: { type: 'text', }, }, },
                    },
                    extend: {
                        'parent': this.$props.data,
                    }
                };
            },

        },
        mounted() {

        },
    }
</script>
