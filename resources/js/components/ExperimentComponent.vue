<template>
    <div class="card mb-3">
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
</template>

<script>
    export default {
        props: {
            experiment: {
                type: Object,
                required: true
            }
        }
    }
</script>
