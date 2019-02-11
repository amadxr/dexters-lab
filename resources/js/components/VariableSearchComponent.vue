<template>
    <div>
        <div class="card">
            <div class="card-body">
                <input type="text" class="form-control" id="inputDetail" placeholder="Details" v-model="inputText" @input="search">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                variables: [],
                inputText: ""
            }
        },

        methods: {
            search () {
                console.log(this.inputText.length);
                if (this.inputText.length >= 3) {
                    axios.get(process.env.MIX_APP_URL + '/api/experiment-variables')
                        .then(({data}) => {
                            this.variables = data.data;
                        });
                }
            }
        }
    };
</script>

