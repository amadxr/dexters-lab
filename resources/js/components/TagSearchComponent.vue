<template>
    <div>
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <input type="text" class="form-control" id="inputTags" placeholder="Tags" v-model="key" @input="searchTag" v-on:keyup.enter="createTag">
                </div>
                <div class="form-group">
                    <div class="list-group" v-if="hints.length > 0">
                        <button type="button" class="list-group-item list-group-item-action" v-for="tag in hints" @click="addToTags(tag)">
                            {{ tag.name }}
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <span class="badge badge-primary tag-badge" v-for="(tag, index) in value" @click="deleteFromTags(index)">
                        {{ tag.name }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .tag-badge {
        margin-left: 0.3em;
        margin-right: 0.3em;
    }
</style>

<script>
    export default {
        props: {
            value: {
                type: Array,
                required: true
            }
        },

        data () {
            return {
                hints: [],
                key: ""
            }
        },

        methods: {
            searchTag () {
                if (this.key.length >= 3) {
                    axios.get(process.env.MIX_APP_URL + '/api/tags', {
                        params: {
                            key: this.key
                        }
                    }).then(({data}) => {
                            this.hints = data.data;
                        });
                } else {
                    this.hints.length = 0;
                }
            },

            createTag () {
                if (this.key.length >= 3) {
                    var newTags = this.value.concat([{
                        'id': null,
                        'name': this.key
                    }]);

                    this.$emit('input', newTags);
                    this.key = "";
                    this.hints.length = 0;
                }
            },

            addToTags (tag) {
                var newTags = this.value.concat([tag]);
                this.$emit('input', newTags);
                this.key = "";
                this.hints.length = 0;
            },

            deleteFromTags (index) {
                var newTags = this.value.slice(0, index).concat(this.value.slice(index + 1));
                this.$emit('input', newTags);
            }
        }
    };
</script>

