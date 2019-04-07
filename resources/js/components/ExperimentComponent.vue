<template>
    <div class="card mb-3">
        <div class="card-header">
            <div class="float-left">
                <h5>{{ experiment.title }}</h5>
            </div>
            <div class="float-right">
                <button type="button" class="btn btn-primary" v-on:click="showDetails">Details</button>
                <button type="button" class="btn btn-danger" v-on:click="deleteExperiment">Delete</button>
            </div>
        </div>
        <div class="card-body">
            <label id="started">Hypothesis: </label> {{ experiment.falsifiable_hypothesis }}
        </div>
        <div class="card-footer text-muted text-right">
            {{ experiment.created_at }}
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            experiment: {
                type: Object,
                required: true
            }
        },

        methods: {
            showDetails () {
                window.location.href = "show/" + this.experiment.id;
            },

            deleteExperiment () {
                var request = {
                    id: this.experiment.id
                };

                axios.post(process.env.MIX_APP_URL + '/api/experiments/delete', request)
                    .then(({data}) => window.location.reload(true));
            }
        }
    }
</script>
