<template>
    <div>
        <div class="jumbotron" v-if="experiments.length === 0">
            <h1 class="display-4">There are no experiments yet!</h1>
            <p class="lead">To create your first experiment click the button below.</p>
            <a class="btn btn-primary btn-lg" href="create" role="button">Start experimenting!</a>
        </div>
        <div class="card mb-3" v-for="experiment in experiments">
            <div class="card-header">
                <div class="float-left">
                    <h5>{{ experiment.title }}</h5>
                </div>
                <div class="float-right">
                    <a href="#" class="btn btn-primary">Details</a>
                </div>
            </div>
            <div class="card-body">
                <label id="started">Hypothesis: </label> {{ experiment.falsifiable_hypothesis }}
            </div>
            <div class="card-footer text-muted text-right">
                {{ experiment.created_at }}
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                experiments: [],
                pageCount: 1,
                endpoint: 'api/experiments?page='
            };
        },

        created() {
            this.fetch();
        },

        methods: {
            fetch(page = 1) {
                axios.get(this.endpoint + page)
                    .then(({data}) => {
                        this.experiments = data.data;
                        this.pageCount = data.meta.last_page;
                    });
            }
        }
    }
</script>
