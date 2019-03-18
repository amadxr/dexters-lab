<template>
    <div>
        <div class="row text-center dashboard-title-row">
            <h2 class="dashboard-title">Outbound Funnel Status</h2>
        </div>
        <div class="row">
            <div class="col-md-12">
                <leads-life-cycle
                    v-model="value.leads_life_cycle">
                </leads-life-cycle>
            </div>
        </div>
        <div class="row information-dashboard-row">
            <div class="col-md-6">
                <opportunities-section
                    v-model="value.opportunities">
                </opportunities-section>
            </div>
            <div class="col-md-6">
                <call-schedule>
                </call-schedule>
            </div>
        </div>
    </div>
</template>

<style>
    .dashboard-title-row {
        margin-top: 48px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-evenly;
    }

    .dashboard-title {
        width: 442px;
        height: 43px;
        font-size: 35px;
        font-weight: 500;
        font-style: normal;
        font-stretch: normal;
        line-height: normal;
        letter-spacing: normal;
        color: #384963;
    }

    .information-dashboard-row {
        margin-top: 40px;
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
