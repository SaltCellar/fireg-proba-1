<template>
    <div :class="['modal-backdrop', this.$props.loading ? 'loading' : '']">
        <div :class="['modal','w'+this.$props.size]">
            <div class="head">
                <Title :text="this.$props.title" />
                <p @click="this.$emit('close:modal')" class="close">✖</p>
            </div>
            <div class="body">
                <slot name="body" />
            </div>
            <div v-if="this.$props.actions" class="actions">
                <slot name="actions" />
            </div>
        </div>
    </div>
</template>

<script>
    import Title from "@/components/ui/Title.vue";
    export default {
        name: "ModalFrame",
        components: { Title },
        props: {
            loading: { type: Boolean, default() { return false; }, },
            actions: { type: Boolean, default() { return true; }, },
            title: { type: String, default() { return 'Modal Title!'; }, },
            size: { type: Number, default() { return 6; }, },
        },
    }
</script>

<style scoped>
    .modal-backdrop {
        position: fixed;
        width: 100%; height: 100vh;
        top: 0; left: 0;
        background-color: #1a202c20;
        backdrop-filter: blur(1px);
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .modal-backdrop > .modal p {
        margin: 0;
    }
    .modal-backdrop > .modal {
        background-color: white;
        border: 1px solid #1a202c;
        width: 100%;
        padding: 10px;
    }
    .modal-backdrop > .modal.w4 { max-width: 400px; }
    .modal-backdrop > .modal.w6 { max-width: 600px; }
    .modal-backdrop > .modal.w8 { max-width: 800px; }
    .modal-backdrop > .modal.w10 { max-width: 1000px; }
    .modal-backdrop > .modal.w12 { max-width: 1200px; }

    .modal-backdrop.loading > .modal {
        pointer-events: none;
        background-color: red;
    }

    .modal-backdrop > .modal > .head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 10px;
    }
    .modal-backdrop > .modal > .head > .close {
        padding: 5px;
        cursor: pointer;
        font-size: 1.4em;
    }
    .modal-backdrop > .modal > .head > .title {
        font-weight: 600;
    }
    .modal-backdrop > .modal > .actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding-top: 10px;
    }
</style>
