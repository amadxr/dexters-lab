<template>
    <div>
        <div class="jumbotron" v-if="experiments.length === 0">
            <h1 class="display-4">There are no experiments yet!</h1>
            <p class="lead">To create your first experiment click the button below.</p>
            <a class="btn btn-primary btn-lg" href="create" role="button">Start experimenting!</a>
        </div>
        <experiment-component v-for="experiment in experiments" :key="experiment.id"/>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                experiments: [],
                endpoint: 'api/experiments'
            };
        },

        created() {
            this.fetch();
            console.log(this.experiments);
        },

        methods: {
            fetch() {
                axios.get(this.endpoint)
                    .then(({data}) => {
                        this.experiments = data.data;
                    });
            }
        }
    }
</script>
