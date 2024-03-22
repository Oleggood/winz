<template>
    <div>
        <div class="mb20">
            <p class="fz17 fw600">{{ this.label }}</p>
            <div class="checkbox-group__error" v-if="this.errorLocal && this.errorLocal.length">{{
                    this.errorLocal[0]
                }}
            </div>
        </div>
        <div class="checkbox-group mb20 pb20 bb1 trvl1__checkbox"
             :class="[this.errorLocal && this.errorLocal.length ? 'checkbox-group_error' : '']">
            <div class="flex1">
                <div class="col6">
                    <div class="mb20" v-for="(transport_group, i) in this.all_transports" v-if="i<2">
                        <div v-for="(transport) in transport_group['items']">
                            <label class="st-checkbox mb5" v-if="recommended.indexOf(transport['id']) >= 0">
                                <input v-model="valueLocal" type="checkbox" :value="transport['id']">
                                <span class="st-checkbox__dot"></span>
                                <span class="trvl1__ico mr5" v-html="transport['svg']"></span>
                                <span class="fz17">{{ transport['name'] }}</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col6">
                    <div class="mb20" v-for="(transport_group, i) in this.all_transports" v-if="i>=2">
                        <div v-for="(transport) in transport_group['items']">
                            <label class="st-checkbox mb5" v-if="recommended.indexOf(transport['id']) >= 0">
                                <input v-model="valueLocal" type="checkbox" :value="transport['id']">
                                <span class="st-checkbox__dot"></span>
                                <span class="trvl1__ico mr5" v-html="transport['svg']"></span>
                                <span class="fz17">{{ transport['name'] }}</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "MultuCheckbox",
    props: {
        all_transports: Array,
        label: String,
        error: Array,
        recommended: Array,
        value: [],
    },
    data() {
        return {
            valueLocal: this.value || [],
            errorLocal: this.error,
        }
    },
    watch: {
        valueLocal: function () {
            if (this.valueLocal && this.valueLocal.length)
                this.errorLocal = [];
            this.$emit('input', this.valueLocal)
        },
        error: function () {
            this.errorLocal = this.error;
        },
        value: function () {
            this.valueLocal = this.value;
        }
    }
}
</script>

<style scoped>

</style>
