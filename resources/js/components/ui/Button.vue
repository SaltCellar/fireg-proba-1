<template>
    <button :class="['btn',this.$props.neg ? 'btn-neg' : '']">{{ this.$props.text }}</button>
</template>

<script>
    export default {
        name: "Button",
        props: {
            text: { type: String, default() { return "Button"; }, },
            neg: { type: Boolean, default() { return false; }, },
        },
    }
</script>

<style scoped>
    .btn {
        cursor: pointer;
        padding: 6px 20px;
        border: unset;
        background-color: #1a202c;
        color: white;
        font-weight: 600;
        font-size: 0.8em;
    }
    .btn.btn-neg {
        background-color: unset;
        color: #1a202c;
    }
</style>
