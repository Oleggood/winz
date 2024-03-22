<i18n>
{
    "ru": {
        "ct_tx5": "Выбрать все"
    },
    "en": {
        "ct_tx5": "Select all"
    }
}


</i18n>
<template>
    <div class="form-item form-item_checkbox" :class="[this.errorLocal && this.errorLocal.length ? 'checkbox-group__error' : '']">
        <div class="mb10">
            <p class="fz17 fw600">{{ this.label }}</p>
            <div class="checkbox-group__error" v-if="this.errorLocal && this.errorLocal.length">{{ this.errorLocal[0] }}</div>
        </div>
        <div class="flex1 mb10">
            <div class="flex-full">
                <div v-if="selected.length < 24" @click="selectAll" class="link link-blue fz14">{{ $t('ct_tx5') }}</div>
            </div>
            <div>
                <div v-if="selected.length > 0" @click="clear" class="link link-blue fz14">{{ $t('text.clear') }}</div>
            </div>
        </div>
        <div class="flex1 flex-wrap form-item__checkbox">
            <div class="relative form-item__checkbox-wrap" v-for="i in 12">
                <p class="form-item__checkbox-name fz14">{{ $t('travel.availabilities')[i-1]['name'] }}</p>
                <div @click="changeArray" class="form-item__checkbox-elem" :data-index="i + '_' +j" v-for="j in 2"
                     :class="[selected.indexOf(i + '_' +j) > -1 ? 'form-item__checkbox-elem_selected' : '']">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "BlockCalendar",
    props: {
        label: String,
        error: Array,
        default_values: {
            type: Array,
            default() {
                return [
                    "1_1",
                    "1_2",
                    "2_1",
                    "2_2",
                    "3_1",
                    "3_2",
                    "4_1",
                    "4_2",
                    "5_1",
                    "5_2",
                    "6_1",
                    "6_2",
                    "7_1",
                    "7_2",
                    "8_1",
                    "8_2",
                    "9_1",
                    "9_2",
                    "10_1",
                    "10_2",
                    "11_1",
                    "11_2",
                    "12_1",
                    "12_2"
                ]
            }
        }
    },
    mounted() {
        this.selected = this.$attrs['selected'] || [];
        this.changeValue();
    },
    data() {
        return {
            selected: [],
            errorLocal: this.error,
        }
    },
    watch: {
        error: function () {
            this.errorLocal = this.error;
        }
    },
    methods: {
        changeArray(el) {
            let index = $(el.target).data('index');
            if (this.selected.indexOf(index) > -1)
                this.removeItem(this.selected, index);
            else
                this.selected.push(index);
            this.changeValue();
        },
        clear() {
            this.selected = [];
            this.changeValue();
        },
        removeItem(arr, value) {
            var index = arr.indexOf(value);
            if (index > -1) {
                arr.splice(index, 1);
            }
            return arr;
        },
        selectAll() {
            this.selected = Array.from(this.default_values);
            this.changeValue();
        },
        changeValue() {
            if (this.selected && this.selected.length)
                this.errorLocal = [];
            this.$emit('input', this.selected)
        }
    }
}
</script>

<style scoped>

</style>
