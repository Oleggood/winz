<template>
    <div>
        <div class="st-rating">
            <p class="fz17 lh15">{{ label }}</p>
            <div class="flex1 flex-v-center">
                <template v-for="i in this.marks">
                    <label :for="'rating'  + identifier + i">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1.2rem" viewBox="0 0 24 24" width="1.2rem"
                        >
                            <path d="M0 0h24v24H0z" fill="none"/>
                            <path d="M0 0h24v24H0z" fill="none"/>
                            <path
                                d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                        </svg>
                    </label>
                    <input @change="emitValue" v-model="valueLocal" type="radio" :value="i" :id="'rating' + identifier + i">
                </template>
            </div>
            <div class="st-input1__error" v-if="this.errorLocal">{{ this.errorLocal[0] }}</div>
        </div>
    </div>
</template>

<script>
export default {
    name: "BlockReview",
    props: {
        label: String,
        identifier: String,
        error: Array,
        value: Number,
    },
    data() {
        return {
            marks: [1, 2, 3, 4, 5],
            valueLocal: this.value || 5,
            errorLocal: this.error,
        }
    },

    methods: {
        emitValue() {
            if (this.valueLocal && this.valueLocal.length)
                this.errorLocal = [];
            this.$emit('input', this.valueLocal)
        }
    },
    watch: {
        valueLocal: function () {
            this.emitValue();
        },
        error: function () {
            this.errorLocal = this.error;
        }
    },
    mounted() {
        this.emitValue();
    }
}
</script>

<style scoped>

</style>
