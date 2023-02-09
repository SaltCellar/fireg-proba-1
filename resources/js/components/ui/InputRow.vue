<template>
    <div class="input-row">
        <div class="row-label">
            <p>{{ this.$props.label }}</p>
        </div>
        <div class="row-input">
            <slot/>
        </div>
        <p class="row-error" v-if="this.$props.error">{{ this.$props.error }}</p>
    </div>
</template>

<script>
    export default {
        name: "InputRow",
        props: {
            order: { type: Number, default() { return null; }, },
            label: { type: String, default() { return "Input Row Label" }, },
            error: { type: String, default() { return null; }, },
        },
        mounted() {
            if (this.$props.order) {
                this.$el.style.order = this.$props.order;
            }
        }
    }
</script>

<style scoped>
    .input-row {
        width: 100%;
        display: flex;
        flex-wrap: wrap;

        margin-bottom: 20px;
    }
    .input-row > .row-label,
    .input-row > .row-input {
        width: 50%;
    }
    .input-row > .row-error {
        width: 100%;
        color: orangered;
    }
</style>
