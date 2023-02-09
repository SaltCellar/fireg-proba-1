<template>
    <div class="modals">

    </div>
</template>

<script>

    import CreatePostModal from "@/components/modals/CreatePost.vue";
    import CreatePostMaintenanceModel from "@/components/modals/CreatePostMaintenance.vue";
    import UpdatePostModal from "@/components/modals/UpdatePost.vue";
    import ConfirmModal from "@/components/modals/Confirm.vue";

    import {createApp} from "vue";

    export default {
        name: "ModalManager",
        components: {
            CreatePostModal, CreatePostMaintenanceModel, UpdatePostModal,
            ConfirmModal
        },
        methods: {
            openModal(type,data,callback) {

                let Component = null;
                switch (type) {
                    case 'create-post' : { Component = CreatePostModal; break; }
                    case 'create-post-maintenance' : { Component = CreatePostMaintenanceModel; break; }
                    case 'update-post' : { Component = UpdatePostModal; break; }
                    case 'confirm' : { Component = ConfirmModal; break; }
                    default: { Component = null; }
                }

                if (Component === null) return;

                let modalId = btoa(Math.random()).substring(0,12);

                this.$data.modals [ modalId ] = { component: null, instance: null, };

                this.$data.modals [ modalId ].component = createApp(Component,{ modalId: modalId, data: data });

                let modalFrame = document.createElement('div');
                modalFrame.classList.add('modal-container');
                this.$el.append(modalFrame);

                this.$data.modals [ modalId ].instance = this.$data.modals [ modalId ].component.mount(modalFrame);
                this.$data.modals [ modalId ].instance.openModal(callback);

            },
            closeModal(modalId) {
                if ( this.$data.modals [ modalId ] !== undefined ) {
                    let backdropSelector = this.$data.modals [ modalId ].instance.$el.parentNode;
                    this.$data.modals [ modalId ].component.unmount();
                    backdropSelector.remove();
                    delete this.$data.modals [ modalId ];
                }
            },
        },
        data() {
            return {
                modals: {},
            };
        },
        mounted() {
            if (window.vue === undefined) { window.vue = {}; }
            window.vue['ModalManager'] = this;
        }
    }
</script>

<style scoped>

</style>
