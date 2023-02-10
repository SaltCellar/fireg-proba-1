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

<style lang="scss">
    @import "resources/sass/define";

    .btn {
        cursor: pointer;
        padding: $buttonPadding;
        border: unset;
        background-color: $buttonColor;
        color: $buttonColorInverse;
        font-weight: $weightHeavy;
        font-size: $fontAlter;
    }
    .btn.btn-neg {
        background-color: $buttonColorInverse;
        color: $buttonColor;
    }
</style>
