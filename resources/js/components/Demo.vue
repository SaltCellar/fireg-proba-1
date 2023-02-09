<template>
    <div class="demo">
        <p>Demo Component!</p>
        <Form @form-success="formSuccess" :form="this.createForm()" />
    </div>
</template>

<script>
    import Form from "@/components/form/Form.vue";
    import Field from "@/components/ui/input/Field.vue";
    export default {
        name: "Demo",
        components: { Form, Field },
        methods: {
            formSuccess(event) {
                console.log(event);
            },
            createForm() {
                return {
                    url: '/api/sites',
                    actions: [
                        { label: 'Mégsem', neg: true, action: null, },
                        { label: 'Létrehozás', neg: false, action: 'post', },
                    ],
                    form: {
                        'name': { value: '', error: '', type: { name: 'field', label: 'Megnevezés', config: { type: 'text', }, }, },
                        'details': { value: '', error: '', type: { name: 'field', label: 'Leírás', config: { type: 'text', }, }, },
                        //'site': { value: '', error: '', type: { name: 'select', label: 'Telephely', config: { fetch_url: '/api/sites?limit=100', fetch_attr: 'name' }, }, },
                    },
                    extend: {
                        'board': 2,
                    }
                };
            },
        },
    }
</script>

<style scoped>

</style>
