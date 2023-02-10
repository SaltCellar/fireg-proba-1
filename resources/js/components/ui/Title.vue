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

<style lang="scss">
    @import "resources/sass/define";

    .title {
        width: 100%;

        p {
            font-size: $fontHead;
            border-bottom: 2px solid $buttonColor;
            padding-right: $spaceC;
            padding-bottom: $spaceA;
            font-weight: $weightHeavy;
            display: inline-block;
        }
    }

</style>
