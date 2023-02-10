<template>
    <ModalFrame @close:modal="sendModal(false)" :title="this.$props.data.title ?? 'Sure?'" size="4">
        <template #body>
            {{ this.$props.data.text ?? 'Confirm text!' }}
        </template>
        <template #actions>
            <Button @click="sendModal(false)" :neg="true" text="Mégsem" />
            <Button @click="sendModal(true)" :text="this.$props.data.confirm ?? 'Yes'" />
        </template>
    </ModalFrame>
</template>

<script>
    import ModalFrame from "@/components/modal/ModalFrame.vue";
    import Button from "@/components/ui/Button.vue";

    export default {
        name: "Confirm",
        components: { ModalFrame, Button },
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
            sendModal(event) {
                if (this.$data.callback !== undefined) { this.$data.callback(event); }
                this.closeModal();
            },
            openModal(callback) {
                this.$data.callback = callback;
            },

            closeModal() {
                window.vue.ModalManager.closeModal(this.$props.modalId);
            },
        },
    }
</script>
