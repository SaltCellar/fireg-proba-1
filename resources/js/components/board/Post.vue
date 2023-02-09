<template>
    <tr class="post">
        <td>{{ this.$props.index }}</td>
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
            }

        },
        mounted() {

        },
    }
</script>

<style scoped>
    .post {
        line-height: 100px;
    }
    .post > td.ml {
    }
</style>
