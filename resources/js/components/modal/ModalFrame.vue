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

<style lang="scss">
    @import "resources/sass/define";

    .modal-backdrop {
        position: fixed;
        width: 100%; height: 100vh;
        top: 0; left: 0;
        background-color: $backdrop;
        backdrop-filter: blur(1px);
        display: flex;
        justify-content: center;
        align-items: center;

        .modal p {
            margin: 0;
        }

        .modal {
            background-color: white;
            border: 1px solid $buttonColor;
            width: 100%;
            padding: $spaceC;

            .head {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding-bottom: $spaceB;

                .close {
                    padding: $spaceA;
                    cursor: pointer;
                    font-size: $fontHead;
                }

                .title {
                    font-weight: $weightHeavy;
                }

            }

            .actions {
                display: flex;
                align-items: center;
                justify-content: flex-end;
                padding-top: $spaceB;
            }

        }

        .modal.w4 { max-width: 400px; }
        .modal.w6 { max-width: 600px; }
        .modal.w8 { max-width: 800px; }
        .modal.w10 { max-width: 1000px; }
        .modal.w12 { max-width: 1200px; }

    }

    .modal-backdrop.loading {
        .modal {
            pointer-events: none;
            background-color: $loadingBackgroundDev;
        }
    }


</style>
