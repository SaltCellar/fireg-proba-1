<template>
    <div class="app">
        <Board boardId="" />
        <!-- <Demo/> -->
        <ModalManager/>
    </div>
</template>

<script>
    import ModalManager from "@/components/modal/ModalManager.vue";
    import Board from "@/components/board/Board.vue";

    import Demo from "@/components/Demo.vue";

    export default {
        name: "App",
        components: { ModalManager, Board, Demo },
    }
</script>
