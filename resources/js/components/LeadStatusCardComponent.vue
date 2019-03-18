<template>
    <div class="card text-center lead-status-card">
        <div class="lead-status-step-container">
            <div class="lead-status-step">
                {{ step }}
            </div>
        </div>
        <div class="card-body">
            <h5 class="card-title lead-status-name">
                {{ status }}
            </h5>
        </div>
        <div class="lead-status-count">
            {{ count }}
        </div>
    </div>
</template>

<style>
    .lead-status-card {
        width: 10rem;
        border: none;
    }

    .lead-status-step-container {
        display: flex;
        justify-content: center;
    }

    .lead-status-step {
        width: 23px;
        height: 23px;
        border-radius: 50%;
        background: #498dff;
        font-size: 10px;
        font-weight: normal;
        font-style: normal;
        font-stretch: normal;
        line-height: normal;
        letter-spacing: 0.5px;
        text-align: center;
        color: #ffffff;
        padding-top: 5px;
        padding-left: 1px;
    }

    .lead-status-name {
        height: 20px;
        font-size: 15px;
        font-weight: bold;
        font-style: normal;
        font-stretch: normal;
        line-height: normal;
        letter-spacing: normal;
        text-align: center;
        color: #384963;
    }

    .lead-status-count {
        height: 73px;
        font-size: 50px;
        font-weight: 100;
        font-style: normal;
        font-stretch: normal;
        line-height: normal;
        letter-spacing: normal;
        text-align: center;
        color: #384963;
    }
</style>

<script>
    export default {
        props: {
            step: {
                type: Number,
                required: true
            },
            status: {
                type: String,
                required: true
            },
            count: {
                type: Number,
                required:true
            }
        }
    }
</script>
