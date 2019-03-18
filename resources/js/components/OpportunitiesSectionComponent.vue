<template>
    <div>
        <div class="text-center">
            <h5 class="opportunities-section-title">
                Opportunities
            </h5>
        </div>
        <div class="opportunities-section-body">
            <opportunity-info-card
                :title="'Active Opportunities'"
                :value="value.count">
            </opportunity-info-card>
            <opportunity-info-card
                :title="'Annual Value'"
                :value="value.annual_value">
            </opportunity-info-card>
        </div>
    </div>
</template>

<style>
    .opportunities-section-title {
        width: 156px;
        height: 20px;
        font-size: 16px;
        font-weight: normal;
        font-style: normal;
        font-stretch: normal;
        line-height: normal;
        letter-spacing: 3px;
        display: inline-block;
        color: #aeb9cd;
        text-transform: uppercase;
    }

    .opportunities-section-body {
        margin-top: 40px;
        display: flex;
        justify-content: space-between;
    }
</style>

<script>
    export default {
        props: {
            value: {
                type: Object,
                required: true
            }
        }
    }
</script>
