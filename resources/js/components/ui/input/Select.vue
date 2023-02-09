<template>
    <div class="inp inp-select">
        <select @change="sendInput" >
            <option v-for="(optionLabel,optionValue) in this.$props.options" :value="optionValue">{{ optionLabel }}</option>
        </select>
    </div>
</template>

<script>
export default {
    name: "Select",
    props: {
        value: { type: String, default() { return ""; }, },
        value_setted: false,
        name: { type: String, default() { return "input"; }, },
        options: { type: Object, default() { return {}; }, },
    },
    methods: {
        sendInput() {
            if (this.$el.querySelector('select').options.length > 0){
                this.$emit('send-input',{
                    name: this.$props.name,
                    value: this.$el.querySelector('select').value,
                });
            }
        },
    },
    data() {
        return {
            setted: false,
        };
    },
    mounted() {
        if (this.$props.value === "") {
            this.$data.setted = true;
        }
        this.sendInput();
    },
    updated() {
        this.sendInput();
        if (this.$data.setted === false && this.$props.value !== "" && this.$el.querySelector('select').options.length > 0) {
            this.$el.querySelector('select').value = this.$props.value;
            this.$data.setted = true;
        }
    },
}
</script>

<style scoped>
    .inp > select {
        cursor: pointer;
        height: 27px;
        width: 100%;
        border: unset;
        outline: 1px solid #1a202c;
        outline-offset: -1px;
        padding: 2px 6px;
    }
</style>
