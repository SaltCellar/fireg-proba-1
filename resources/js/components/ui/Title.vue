<template>
    <div class="title">
        <p>{{ this.$props.text }}</p>
    </div>
</template>

<script>
export default {
    name: "Title",
    props: {
        text: { type: String, default() { return 'Title'; }, },
    }
}
</script>

<style scoped>
    .title {
        width: 100%;
    }
    .title > p {
        font-size: 1.3em;
        border-bottom: 2px solid #1a202c;
        padding-right: 20px;
        padding-bottom: 2px;
        font-weight: 600;
        display: inline-block;
    }
</style>
