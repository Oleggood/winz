<template>
    <div>
        <div class="st-input1 st-input1_date" :class="classObject">
            <label class="st-input1__label">{{ label }}</label>
            <date-picker
                v-model="valueLocal"
                :type="type"
                :value-type="this.value_type"
                :format="this.format"
                :disabled-date="disabledBeforeToday"
                :minute-step="5"
                :disabled-time="disabledBeforeNow" :lang="lang"
                :editable="false"
            ></date-picker>
            <div class="form-item__clear" v-if="this.valueLocal"
                 @click="clearValue">
                <svg>
                    <use xlink:href="#ico-close"></use>
                </svg>
            </div>

        </div>
        <div class="st-input1__error" v-if="this.errorLocal">{{ this.errorLocal[0] }}</div>
    </div>
</template>

<script>
import DatePicker from 'vue2-datepicker';

export default {
    components: {DatePicker},
    name: "BlockDateTime",
    props: {
        label: String,
        value: String,
        format: String,
        value_type: String,
        formattedValue: String,
        type: String,
        error: Array,
        now: new Date(new Date().setHours(new Date().getHours(), 0, 0, 0))
    },
    mounted() {
        this.valueLocal = this.formattedValue || '';
    },
    watch: {
        valueLocal: function () {
            if (this.valueLocal)
                this.errorLocal = [];
            this.$emit('input', this.valueLocal)
        },
        error: function () {
            this.errorLocal = this.error;
        }
    },
    data() {
        return {
            valueLocal: new Date(this.value) || '',
            errorLocal: this.error,
            lang: {
                formatLocale: {
                    firstDayOfWeek: 1,
                },
            },
        }
    },
    computed: {
        classObject: function () {
            return {
                'st-input1_error': (this.errorLocal && this.errorLocal.length),
                'st-input1_focused': this.focused,
                'st-input1_filled': this.valueLocal || this.focused
            }
        }
    },
    methods: {
        disabledBeforeToday(date) {
            return date < new Date(new Date().setHours(0, 0, 0, 0));
        },
        disabledBeforeNow(date) {
            return date < new Date(new Date().setHours(new Date().getHours(), 0, 0, 0));
        },
        clearValue() {
            this.valueLocal = '';
        },
    }
}
</script>

<style scoped>

</style>
