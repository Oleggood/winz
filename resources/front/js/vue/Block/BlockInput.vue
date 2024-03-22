<template>
    <div>
        <div class="st-input1" :class="classObject">
            <label class="st-input1__label">{{ label }}</label>
            <textarea v-if="this.textarea" v-model="valueLocal" class="st-input1__input"
                      @focus="focusInput" @blur="blurInput" @keyup.enter="pressedEnter"></textarea>
            <input v-else
                   :type="typeLocal"
                   class="st-input1__input"
                   :class="[input_class ? input_class : '']"
                   v-model="valueLocal"
                   @focus="focusInput"
                   :autocomplete="[autocompleteoff ? 'new-password': '']"
                   @blur="blurInput">
            <div class="st-input1__show" @click="togglePassword">
                <svg class="st-input1__show-close" v-if="typeLocal=='password'">
                    <use xlink:href="#ico-eye-close"></use>
                </svg>
                <svg class="st-input1__show-open" v-if="typeLocal=='text' && type=='password'">
                    <use xlink:href="#ico-eye-open"></use>
                </svg>
            </div>
        </div>
        <div class="st-input1__error" v-if="this.errorLocal">{{ this.errorLocal[0] }}</div>
    </div>
</template>

<script>
export default {
    name: "BlockInput",
    props: {
        input_class: String,
        label: String,
        textarea: Boolean,
        error: Array,
        type: String,
        value: [String, Number],
        autocompleteoff: Boolean,
        name: String,
    },

    data() {
        return {
            valueLocal: '',
            focused: false,
            errorLocal: this.error,
            typeLocal: this.type || 'text'
        }
    },

    mounted() {
        this.valueLocal = this.value || '';
    },
    methods: {
        togglePassword() {
            if (this.type == 'password') {
                this.typeLocal = (this.typeLocal == 'password') ? 'text' : 'password';
            }
        },
        focusInput() {
            this.focused = true
        },
        blurInput() {
            this.focused = false;
        },
        pressedEnter() {
            this.$emit('pressedEnter', '')
        },
        emitValue() {
            if (this.valueLocal && this.valueLocal.length)
                this.errorLocal = [];
            this.$emit('input', this.valueLocal);
        }
    },
    watch: {
        valueLocal: function () {
            this.emitValue();
        },
        value: function () {
            this.valueLocal = this.value;
        },
        error: function () {
            this.errorLocal = this.error;
        }
    },
    computed: {
        classObject: function () {
            let filled = this.valueLocal || this.focused;
            return {
                'st-input1_error': (this.errorLocal && this.errorLocal.length),
                'st-input1_focused': this.focused,
                'st-input1_filled': filled,
            }
        }
    },
}
</script>

<style scoped>

</style>
