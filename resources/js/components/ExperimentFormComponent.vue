<template>

    <div>
        <div class="alert alert-success" v-if="saved">
            <strong>Success!</strong> Your experiment has been saved successfully.
        </div>
        <div class="alert alert-success" v-if="assigned">
            <strong>Success!</strong> Your experiment will now be able to track results automatically!
        </div>
        <div class="alert alert-success" v-if="updated">
            <strong>Success!</strong> Your experiment's results have been updated!
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
                            <tag-search-component 
                                v-model="experiment.tags">
                            </tag-search-component>
                            <span v-if="errors.tags" class="help-block text-danger">{{ errors.tags[0] }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form-field-component 
                            v-model="experiment.results">
                            <div slot="input" class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Results</h5>
                                    <div v-if="experiment.results" class="card-text">
                                        <p>Number of Leads: {{ experiment.results.leads_count }}</p>
                                        <p>Number of Opportunities: {{ experiment.results.opportunities_count }}</p>
                                        <p>Value per month: ${{ experiment.results.opportunities_value }}</p>
                                    </div>
                                </div>
                            </div>
                        </form-field-component>
                        <div class="form-group">
                            <textarea rows="6" class="form-control" id="inputValidatedLearning" placeholder="Validated Learning" v-model="experiment.validated_learning" :disabled="!detail"></textarea>
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
                    <button type="submit" disabled style="display: none" class="btn btn-primary btn-lg">Submit</button>
                    <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                </div>
            </form>
        </div>

        <modal-component v-if="showModal" @submit="onAssign" @close="showModal = false">
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
                updated: false,
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
                    tags: [],
                    results: {
                        id: null,
                        experiment_id: null,
                        leads_count: null,
                        opportunities_count: null,
                        opportunities_value: null
                    },
                    validated_learning: null,
                    next_action: null,
                    parent_id: null,
                    smart_view_id: null,
                    smart_view_query: null,
                    created_at: null,
                    updated_at: null
                },
                showModal: false,
            };
        },

        methods: {
            initiateFormData () {
                if (this.detail) {
                    if (this.detail.results) {
                        var request = {
                            id: this.detail.id
                        };

                        axios.post(process.env.MIX_APP_URL + '/api/experiments/update-results', request)
                            .then(({data}) => this.setUpdateSuccessMessage(data));

                        axios.get(process.env.MIX_APP_URL + '/api/smart-views')
                            .then(({data}) => {
                                this.smartViews = data;
                            });
                    } else {
                        this.experiment = this.detail;
                    }
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
                    tags: [],
                    results: {
                        id: null,
                        experiment_id: null,
                        leads_count: null,
                        opportunities_count: null,
                        opportunities_value: null
                    },
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
                var request = {
                    id: this.experiment.id,
                    smart_view_id: this.selected.id,
                    smart_view_query: this.selected.query
                };

                axios.post(process.env.MIX_APP_URL + '/api/experiments/assign-smart-view', request)
                    .then(({data}) => this.setAssignSuccessMessage({data}.data))
                    .catch(({response}) => this.setErrors(response));

                this.showModal = false;
            },

            setAssignSuccessMessage (data) {
                this.assigned = true;
                this.experiment.results = data.data.results;
            },

            setUpdateSuccessMessage (data) {
                this.updated = true;
                this.experiment = data.data;
            }
        }
    }
</script>
