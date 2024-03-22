<template>
    <div class="bb1 mb20 pb20">
        <div class="mb5 flex1 flex-v-start">
            <a v-if="travel['status'] == 1" class="link link-orange mr10" :href="travel['href']">
                {{ travel['name'] }}
            </a>
            <span v-else class="color-error">
                {{ getNameById(travel['status'], $t('travel.states')) }}<br>
                {{ travel['name'] }}
            </span>
            <span class="card-bages">
                <span v-if="travel['draft']" class="card-bages__item card-bages__item_draft tooltip-left"
                      :data-title="$t('event.txt3')">
                    <svg>
                        <use xlink:href="#ico-draft"></use>
                    </svg>
                </span>
            </span>
        </div>
        <div class="flex1 flex-wrap lh12">
            <p class="fz16 mr5">{{ travel['country_name'] }},</p>
            <p class="fz16 mr5">{{ travel['region'] }},</p>
            <p class="fz16">{{ travel['distance'] }} {{ $t('text.km') }}</p>
        </div>
    </div>
</template>

<script>
export default {
    name: "TravelCard",
    props: {
        travel: Object
    }, mounted() {
        window.initTooltip();
    },
    methods: {
        getNameById(id, scope) {
            return window.getNameById(id, scope);
        }
    },
}
</script>

<style scoped>

</style>
