<template>
    <tr :class="['post',this.$data.isMaintenanced ? 'maintenanced' : '']">
        <td class="id">{{ this.$props.index }}</td>
        <td class="ml">
            <Button @click="editPost" text="Szerk." style="margin-right: 5px" />
            <Button @click="addMaintenance" text="Karb." />
        </td>
        <td>{{ this.$props.post.fa_no }}</td>
        <td>{{ this.$props.post.name }}</td>
        <td>{{ this.$props.post.extinguisher_type.name }}</td>
        <td>{{ this.$props.post.fa_date }}</td>
        <td>{{ this.getHighlightedMaintenance(0) }}</td>
        <td>{{ this.getHighlightedMaintenance(1) }}</td>
        <td>{{ this.getHighlightedMaintenance(2) }}</td>
        <td>{{ this.getHighlightedMaintenance(3) }}</td>
        <td>{{ this.$props.post.comment }}</td>
    </tr>
</template>

<script>
    import Button from "@/components/ui/Button.vue";
    export default {
        name: "Post",
        components: { Button },
        props: {
            post: { type: Object, default() { return {}; }, },
            index: { type: Number, default() { return null; }, },
            smis: { type: Array, default() { return []; }, },
        },
        data() {
            return {
                isMaintenanced: false,
            };
        },
        methods: {
            editPost() {
                window.vue.ModalManager.openModal('update-post',this.$props.post,(res) => {
                    if (res) {
                        this.$emit('update-post',res);
                    }
                });
            },
            addMaintenance() {
                window.vue.ModalManager.openModal('create-post-maintenance',this.$props.post.id,(res) => {
                    if (res) {
                        this.$emit('update-maintenance',res);
                    }
                });
            },

            getHighlightedMaintenance(maintenanceId) {
                let maintenance = this.$props.post.maintenances[this.$props.smis[maintenanceId] ?? null] ?? null;
                if (maintenance) {
                    return maintenance.date;
                } else {
                    return null;
                }
            },

            maintenanced() {
                let isMaintenanced = false;
                Object.values(this.$props.post.maintenances).forEach(maintenance => {
                    if (maintenance) { isMaintenanced = true; }
                });
                this.$data.isMaintenanced = isMaintenanced;
            },

        },
        mounted() {
            this.maintenanced();
        },
        updated() {
            this.maintenanced();
        },

    }
</script>

<style lang="scss">
    @import "resources/sass/define";

    .post {
        line-height: $spaceG;
        .id {
            background-color: $postMaintenanceColorStatusNo;
        }
    }
    .post.maintenanced {
        .id {
            background-color: $postMaintenanceColorStatusYes;
        }
    }

</style>
