<i18n>
{
    "ru": {
        "txt1": "Информация о маршруте:",
        "txt6": "Проводник",
        "txt7": "Транспорт",
        "txt8": "Автор",
        "txt_last": "--"
    },
    "en": {
        "txt1": "Route Information:",
        "txt6": "Guide",
        "txt7": "Transport",
        "txt8": "Author",
        "txt_last": "--"
    }
}
</i18n>
<template>
    <component :is="tagCard" :href="travel['href']" :class="[!small_link ? 'link link-bordered' : '']" class="card-border  block color-dark flex1 flex-column">
        <p class="fz17 lh15 mb10 fw600 color-blue" v-if="small_link">{{ $t('txt1') }}</p>
        <div class="flex mb5 flex-full">
            <div class="col8">
                <component :is="tagInner" :href="travel['href']" class="link link-orange fz18 lh11 mb5">
                    {{ travel['name'] }}
                </component>
                <div class="flex1 flex-wrap fz16 lh12 fw600 mb5">
                    <p class="mr5">{{ travel['country_name'] }},</p>
                    <p class="mr5">{{ travel['region'] }},</p>
                    <p class="">{{ travel['distance'] }} {{ $t('text.km') }}</p>
                </div>
                <div class="flex1 flex-wrap fz14 lh12 mb5">
                    <p class="mr5">{{ getNameById(travel['surface'], $t('travel.surfaces')) }},</p>
                    <p class="mr5">{{ getNameById(travel['difficult'], $t('text.difficult')) }},</p>
                    <p class="">{{ $t('txt6') }}: {{ getNameById(travel['escort'], $t('text.escort')) }}</p>
                </div>
                <div class="mb5 hide-550">
                    <div class="categ__months">
                        <div class="categ__month-wrap flex1" v-for="i in 12">
                            <p class="categ__month-name fz14">{{ $t('travel.availabilities_short')[i-1]['name'] }}</p>
                            <div v-for="j in 2" class="categ__month categ__month"
                                 :class="[travel['availability_parsed'].indexOf(i + '_' +j) > -1 ? 'categ__month categ__month_active' : '']"></div>
                        </div>
                    </div>
                </div>
                <p class="fz14 lh12 hide-550">{{ travel['short_description1'] }}</p>
            </div>
            <div class="col4">
                <div class="categ__image" v-if="travel['image']">
                    <img class="block" :src="travel['image']" :alt="travel['name']">
                </div>
            </div>
        </div>
        <div class=" mb5 show-550">
            <div class="categ__months">
                <div class="categ__month-wrap flex1" v-for="i in 12">
                    <p class="categ__month-name fz14">{{ $t('travel.availabilities_short')[i-1]['name'] }}</p>
                    <div v-for="j in 2" class="categ__month categ__month"
                         :class="[travel['availability_parsed'].indexOf(i + '_' +j) > -1 ? 'categ__month categ__month_active' : '']"></div>
                </div>
            </div>
        </div>
        <p class="fz14 lh12 mb5 show-550">{{ travel['short_description1'] }}</p>
        <div class="flex1 flex-v-center" v-if="travel['user']">
            <p class="fz16 color-gray mr10 hide-550">{{ $t('txt8') }}:</p>
            <a :href="travel['user']['href']" class="fz16 link link-blue">{{ travel['user']['showname'] }}</a>
        </div>
        <div class="categ__transport flex1 flex-v-center flex-wrap">
            <p class="fz16 color-gray mr10 mb5 hide-550">{{ $t('txt7') }}:</p>

            <div v-for="transport in travel['travel_transports']" class="tooltip-bottom mr5 mb5"
                 :data-title="transport['name']" v-html="transport['svg']"></div>
        </div>
    </component>
</template>

<script>
export default {
    name: "TravelCard",
    props: {
        travel: Object,
        small_link: Boolean
    },
    data(){
        return {
            tagCard: this.small_link ? 'div' : 'a',
            tagInner: !this.small_link ? 'p' : 'a'
        }
    },
    methods: {
        getNameById(id, scope){
            return window.getNameById(id, scope);
        }
    },
    mounted() {
        window.initTooltip();
    }
}
</script>

<style scoped>

</style>
