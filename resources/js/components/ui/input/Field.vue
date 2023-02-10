<template>
    <div class="inp inp-field">
        <input @input="sendInput" :type="this.$props.type" :value="this.$props.value" />
    </div>
</template>

<script>
export default {
    name: "Field",
    props: {
        value: { type: String, default() { return ""; }, },
        name: { type: String, default() { return "input"; }, },
        type: { type: String, default() { return "text"; }, },
    },
    methods: {
        sendInput() {
            this.$emit('send-input',{
                name: this.$props.name,
                value: this.$el.querySelector('input').value,
            });
        }
    },
    mounted() {
        this.sendInput();
    }
}
</script>

<style lang="scss">
    @import "resources/sass/define";

    .inp {
        input {
            height: $inputHeight;
            width: 100%;
            border: unset;
            outline: 1px solid $buttonColor;
            outline-offset: -1px;
            padding: $inputPadding;
        }
    }
</style>
