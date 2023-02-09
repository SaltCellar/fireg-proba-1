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

<style scoped>
    .inp > input {
        height: 27px;
        width: 100%;
        border: unset;
        outline: 1px solid #1a202c;
        outline-offset: -1px;
        padding: 2px 6px;
    }
</style>
