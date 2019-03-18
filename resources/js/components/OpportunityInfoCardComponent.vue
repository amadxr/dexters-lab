<template>
    <div class="card text-center opportunity-info-card">
        <div class="card-body">
            <h5 class="card-title opportunity-info-title">
                {{ title }}
            </h5>
        </div>
        <div class="opportunity-info-value">
            {{ value }}
        </div>
    </div>
</template>

<style>
    .opportunity-info-card {
        width: 200px;
        border: none;
    }

    .opportunity-info-title {
        width: 102px;
        height: 40px;
        font-size: 16px;
        font-weight: bold;
        font-style: normal;
        font-stretch: normal;
        line-height: normal;
        letter-spacing: normal;
        text-align: center;
        color: #384963;
    }

    .opportunity-info-value {
        height: 39px;
        font-size: 32px;
        font-weight: bold;
        font-style: normal;
        font-stretch: normal;
        line-height: normal;
        letter-spacing: normal;
        text-align: center;
        color: #4587f6;
    }
</style>

<script>
    export default {
        props: {
            title: {
                type: String,
                required: true
            },
            value: {
                type: String,
                required: true
            }
        }
    }
</script>
