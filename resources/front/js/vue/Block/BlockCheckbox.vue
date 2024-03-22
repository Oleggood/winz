<template>
    <div>
        <label class="st-checkbox">
            <input v-model="valueLocal" type="checkbox" class="input-checkbox">
            <span class="st-checkbox__dot"></span>
            <span class="fz17" v-html="label"></span>
        </label>
        <div class="st-input1__error" v-if="this.errorLocal">{{ this.errorLocal[0] }}</div>
    </div>
</template>

<script>
export default {
    name: "BlockCheckbox",
    props: {
        label: String,
        error: Array,
        value: {Number, Boolean}
    },
    mounted() {
        this.valueLocal = !!this.value
    },
    data() {
        return {
            valueLocal: '',
            errorLocal: this.error,
        }
    },
    watch: {
        valueLocal: function () {
            if (this.valueLocal)
                this.errorLocal = [];
            this.$emit('input', this.valueLocal ? 1 : 0)
        },
        value: function (){
            this.valueLocal = !!this.value;
        },
        error: function () {
            this.errorLocal = this.error;
        }
    }
}
</script>

<style scoped>

</style>
