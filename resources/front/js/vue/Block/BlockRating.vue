<template>
    <div>
        <p class="fz17 lh15">{{ this.label }}</p>
        <div class="rating">
            <div class="rating__fill"
                 :style="{'width': (this.number / 5 * 100) +'%'}">
            </div>
            <div
                class="rating__number fz16 flex1 flex-v-center flex-center">{{ this.number }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "BlockRating",
    props: {
        label: String,
        number: Number
    }
}
</script>

<style scoped>

</style>
