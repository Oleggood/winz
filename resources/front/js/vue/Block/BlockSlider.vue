<i18n>
{
    "ru": {
        "text1": "от",
        "text2": "до"
    },
    "en": {
        "text1": "from",
        "text2": "to"
    }
}

</i18n>
<template>
    <div class="form-item form-item_slider">
        <div class="fz17 fw600 mb20">{{ this.title }}</div>
        <div class="flex flex_5">
            <div class="col6 col_5">
                <div class="st-input1" :class="classObjectMin">
                    <div class="form-item__clear" v-if="this.input_min != this.min" @click="setMinDefault">
                        <svg>
                            <use xlink:href="#ico-close"></use>
                        </svg>
                    </div>
                    <label class="st-input1__label">{{ $t('text1') }}</label>
                    <input type="text" class="st-input1__input form-item__silder-min js-input-number" v-model="input_min">
                </div>
            </div>
            <div class="col6 col_5">
                <div class="st-input1" :class="classObjectMax">
                    <div class="form-item__clear" v-if="this.input_max != this.max" @click="setMaxDefault">
                        <svg>
                            <use xlink:href="#ico-close"></use>
                        </svg>
                    </div>
                    <label class="st-input1__label">{{ $t('text2') }}</label>
                    <input type="text" class="st-input1__input form-item__silder-max js-input-number" v-model="input_max">
                </div>
            </div>
        </div>
        <div ref="form-item__silder"></div>
    </div>
</template>

<script>
export default {
    name: "BlockSlider",
    props: {
        min: Number,
        max: Number,
        step: Number,
        title: String
    },
    watch: {
        input_min: function (val) {
            if (!$('.noUi-active').length) {
                this.slider.set([val, null]);
            }
            this.changeValue();

        },
        input_max: function (val) {
            if (!$('.noUi-active').length) {
                this.slider.set([null, val]);
            }
            this.changeValue();
        }
    },
    data() {
        return {
            input_min: this.$attrs['value']['min'] || this.min,
            input_max: this.$attrs['value']['max'] || this.max,
            slider: null,
            focused_min: false,
            focused_max: false,
        }
    },
    computed: {
        classObjectMin: function () {
            return {
                'st-input1_focused': this.focused_min,
                'st-input1_filled': this.input_min || this.focused_min
            }
        },
        classObjectMax: function () {
            return {
                'st-input1_focused': this.focused_max,
                'st-input1_filled': this.input_max || this.focused_max
            }
        }
    },
    mounted() {
        this.initSlider();
    },
    methods: {
        initSlider() {
            let vue = this;
            this.slider = noUiSlider.create(this.$refs["form-item__silder"], {
                start: [
                    this.input_min,
                    this.input_max
                ],
                range: {
                    'min': [this.min],
                    'max': [this.max]
                },
                step: this.step,
                connect: [false, true, false],
                format: wNumb({
                    decimals: 0,
                })
            });

            this.slider.on('update', function (values) {
                vue.input_min = values[0];
                vue.input_max = values[1];
            });
        },
        setMinDefault() {
            this.input_min = this.min;
        },
        setMaxDefault() {
            this.input_max = this.max;
        },
        changeValue() {
            this.$emit('input', {
                min: (this.input_min != this.min) ? this.input_min : '',
                max: (this.input_max != this.max) ? this.input_max : ''
            });
        }
    }
}
</script>

<style scoped>

</style>
