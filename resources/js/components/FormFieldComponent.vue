<template>
    <div>
        <div class="form-group">
            <slot name="input">
            </slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            value: {
                type: Object
            }
        }
    };
</script>
