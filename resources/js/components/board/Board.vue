<template>
    <div :class="['board',this.$data.loading ? 'loading' : '']">
        <div class="head">
            <Title :text="this.$data.boardName" />
            <Button @click="createPost" text="Új Bejegyzés létrehozása" />
        </div>
        <table>
            <tr>
                <th></th>
                <th colspan="4">Készülék</th>
                <th>Gyártás</th>
                <th colspan="4">Ellenörzések</th>
                <th>Megjegyzés</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th>Gyári száma</th>
                <th>Készenlét helye</th>
                <th>Tpusa</th>
                <th></th>
                <th>I.</th>
                <th>II.</th>
                <th>III.</th>
                <th>IV.</th>
                <th></th>
            </tr>
            <BoardPost v-for="(post,index) in this.posts" @update-maintenance="this.updateMaintenance" @update-post="this.updatePost" :post="post" :index="index" :smis="this.$data.spottedMaintenanceTypes" />
        </table>
        <div class="footer">
            <Button @click="openPdf" text="PDF Létrehozása" />
        </div>
    </div>
</template>

<script>
    import Title from "@/components/ui/Title.vue";
    import Button from "@/components/ui/Button.vue";
    import BoardPost from "@/components/board/Post.vue";
    export default {
        name: "Board",
        components: { Button, BoardPost, Title },
        data() {
            return {
                loading: true,
                boardId: null,
                boardName: null,
                postPage: 0,
                postNext: true,
                posts: {},
                spottedMaintenanceTypes: [],
            };
        },
        methods: {
            createPost() {
                window.vue.ModalManager.openModal('create-post',this.$props.boardId,(res) => {
                    if (res) {
                        res.forEach(post => {
                            this.$data.posts[post.id] = post;
                        });
                    }
                });
            },

            loadPosts() {
                this.$data.loading = true;
                this.$data.postPage += 1;
                let url = '/api/posts?page='+ this.$data.postPage +'&limit=10&board=' + this.$props.boardId;
                axios.get(url).then(res => {
                    if (res.status === 200 && res.data.error === false) {
                        this.$data.postNext = res.data.next;
                        Object.values(res.data.results).forEach(post => {
                            // this.appendPost(post);
                            this.$data.posts[post.id] = post;
                        });
                    }
                    this.$data.loading = false;
                });
            },

            reloadPost(postId) {
                axios.get('/api/post/' + postId).then(res => {
                    if (res.status === 200 && res.data.error === false) {
                        this.$data.posts[postId] = res.data.result;
                    }
                });
            },
            updatePost(post) {
                if (post.DELETED === true) {
                    delete this.$data.posts[post.ID];
                } else {
                    if (this.$data.posts[post.id] !== undefined) {
                        this.$data.posts[post.id] = post;
                    }
                }
            },
            updateMaintenance(maintenance) {
                if (this.$data.posts[maintenance.parent].maintenances[maintenance.type] !== undefined) {
                    this.$data.posts[maintenance.parent].maintenances[maintenance.type] = {
                        id: maintenance.id,
                        date: maintenance.date,
                        comment: maintenance.comment,
                    };
                }
            },


            openPdf() {
                window.open('/pdf/board/'+this.$props.boardId, '_blank');
            },

        },
        props: {
            boardId: { type: Number, default() { return null; }, },
            boardName: { type: String, default() { return 'Board Name!'; }, },
        },
        mounted() {

            // Board Exist check!

            if (this.$props.boardId !== null) {
                this.$data.boardId = this.$props.boardId;

                // Load Posts
                axios.get('/api/board/' + this.$data.boardId).then(res => {
                    if (res.status === 200 && res.data.error === false) {
                        this.$data.boardName = res.data.result.name;
                        this.loadPosts();
                    }
                });

                // Available Services (TOP 4)
                if (this.$data.spottedMaintenanceTypes.length < 1) {
                    axios.get('/api/maintenance_types?limit=4').then(res => {
                        if (res.status === 200 && res.data.error === false) {
                            let maintenanceTypes = [];
                            Object.values(res.data.results).forEach(maintenanceType => {
                                maintenanceTypes.push(maintenanceType.id);
                            });
                            this.$data.spottedMaintenanceTypes = maintenanceTypes;
                        }
                    });
                }

            }


        },
    }
</script>

<style lang="scss">
    @import "resources/sass/define";

    .board.loading {
        opacity: $opacityLoading;
        pointer-events: none;
    }

    .board {
        max-width: 1400px;
        width: 100%;
        margin: $spaceC auto;

        .head {
            height: 100px;
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            align-items: flex-start;
        }

        table {
            width: 100%;
            background-color: $tableBackground;

            tr {
                th {
                    border: 1px solid $tableBorder;
                    height: $spaceD;
                    line-height: $spaceD;
                }
                td, th {
                    align-items: center;
                    text-align: center;
                    border: 1px solid $tableBorder;
                }
            }

        }

        .footer {
            padding-top: $spaceC;
            display: flex;
            justify-content: flex-end;
        }

    }

</style>
