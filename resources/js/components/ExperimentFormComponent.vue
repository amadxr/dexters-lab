<template>

    <div>

        <div class="alert alert-success" v-if="saved">
            <strong>Success!</strong> Your experiment has been saved successfully.
        </div>

        <div class="alert alert-success" v-if="assigned">
            <strong>Success!</strong> Your experiment will now be able to track results automatically!
        </div>

        <div>
            <form method="post" @submit.prevent="onSubmit">
                <div class="form-row">
                    <div class="col-md-3">
                        <h2 class="text-left mb-3">Experiment Report</h2>
                    </div>
                    <div class="col-md-3 form-group">
                        <input type="text" class="form-control" id="inputTitle" placeholder="Title" v-model="experiment.title">
                        <span v-if="errors.title" class="help-block text-danger">{{ errors.title[0] }}</span>
                    </div>
                    <div class="col-md-3 form-group">
                        <input type="text" class="form-control" id="inputOwner" placeholder="Owner">
                    </div>
                    <div class="col-md-3 form-group">
                        <input type="text" class="form-control" id="inputDate" placeholder="Date">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea rows="3" class="form-control" id="inputBackground" placeholder="Background" v-model="experiment.background"></textarea>
                            <span v-if="errors.background" class="help-block text-danger">{{ errors.background[0] }}</span>
                        </div>
                        <div class="form-group">
                            <textarea rows="8" class="form-control" id="inputHypothesis" placeholder="Falsifiable Hypothesis" v-model="experiment.falsifiable_hypothesis"></textarea>
                            <span v-if="errors.falsifiable_hypothesis" class="help-block text-danger">{{ errors.falsifiable_hypothesis[0] }}</span>
                        </div>
                        <div class="form-group">
                            <textarea rows="6" class="form-control" id="inputDetails" placeholder="Details" v-model="experiment.details"></textarea>
                            <span v-if="errors.details" class="help-block text-danger">{{ errors.details[0] }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea rows="8" class="form-control" id="inputResults" placeholder="Results" v-model="experiment.results"></textarea>
                        </div>
                        <div class="form-group">
                            <textarea rows="6" class="form-control" id="inputValidatedLearning" placeholder="Validated Learning" v-model="experiment.validated_learning"></textarea>
                        </div>
                        <div class="form-group">
                            <textarea rows="3" class="form-control" id="inputNextAction" placeholder="Next Action" v-model="experiment.next_action"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-right" v-if="detail">
                    <button type="button" id="show-modal" @click="showModal = true" class="btn btn-secondary btn-lg">Advanced Config</button>
                </div>
                <div class="col-md-12 text-right" v-else>
                    <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                </div>
            </form>
        </div>

        <modal-component v-if="showModal" @close="onAssign">
            <h3 slot="header">Advanced Configuration</h3>

            <div slot="body">
                <h5>Select the smart view you wish to connect with this experiment</h5>

                <select id="smartViewSelect" v-model="selected">
                    <option v-for="smartView in smartViews" :value="smartView">
                        {{ smartView.title }}
                    </option>
                </select>
            </div>
        </modal-component>

    </div>

</template>

<script>
    export default {
        props: {
            detail: {
                type: Object,
                required: false
            }
        },

        mounted () {
            this.initiateFormData()
        },

        data () {
            return {
                errors: [],
                smartViews: [],
                saved: false,
                assigned: false,
                selected: {
                    id: null,
                    title: null,
                    query: null
                },
                experiment: {
                    id: null,
                    title: null,
                    background: null,
                    falsifiable_hypothesis: null,
                    details: null,
                    results: null,
                    validated_learning: null,
                    next_action: null,
                    parent_id: null,
                    smart_view_id: null,
                    smart_view_query: null,
                    created_at: null,
                    updated_at: null
                },
                showModal: false
            };
        },

        methods: {
            initiateFormData () {
                if (this.detail) {
                    this.experiment = this.detail;

                    axios.get(process.env.MIX_APP_URL + '/api/smart-views')
                        .then(({data}) => {
                            this.smartViews = data;
                        });
                }
            },

            onSubmit () {
                this.saved = false;

                axios.post(process.env.MIX_APP_URL + '/api/experiments', this.experiment)
                    .then(({data}) => this.setSubmitSuccessMessage())
                    .catch(({response}) => this.setErrors(response));
            },

            setErrors (response) {
                this.errors = response.data.errors;
            },

            setSubmitSuccessMessage () {
                this.reset();
                this.saved = true;
            },

            reset () {
                this.errors = [];
                this.experiment = {
                    id: null,
                    title: null,
                    background: null,
                    falsifiable_hypothesis: null,
                    details: null,
                    results: null,
                    validated_learning: null,
                    next_action: null,
                    parent_id: null,
                    smart_view_id: null,
                    smart_view_query: null,
                    created_at: null,
                    updated_at: null
                };
            },

            onAssign () {
                this.showModal = false;

                var request = {
                    id: this.experiment.id,
                    smart_view_id: this.selected.id,
                    smart_view_query: this.selected.query
                };

                axios.post(process.env.MIX_APP_URL + '/api/experiments/assign-smart-view', request)
                    .then(({data}) => this.setAssignSuccessMessage())
                    .catch(({response}) => this.setErrors(response));
            },

            setAssignSuccessMessage () {
                this.assigned = true;
            }
        }
    }
</script>
