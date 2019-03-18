<template>
    <div class="life-cycle-row">
        <lead-status-card
            :step="1"
            :status="'Default'"
            :count="value.default">
        </lead-status-card>
        <lead-status-card
            :step="2"
            :status="'Book'"
            :count="value.book">
        </lead-status-card>
        <lead-status-card
            :step="3"
            :status="'Lead Nurturing'"
            :count="value.lead_nurturing">
        </lead-status-card>
        <lead-status-card
            :step="4"
            :status="'Call Scheduled'"
            :count="value.call_scheduled">
        </lead-status-card>
        <lead-status-card
            :step="5"
            :status="'Called - Future Follow-up'"
            :count="value.called_future_follow_up">
        </lead-status-card>
        <lead-status-card
            :step="6"
            :status="'Called - Closed/Converted'"
            :count="value.called_closed_converted">
        </lead-status-card>
    </div>
</template>

<style>
    .life-cycle-row {
        margin-top: 10px;
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
