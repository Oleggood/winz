<i18n>
{
    "ru": {
        "txt6": "Проводник",
        "txt7": "Транспорт"
    },
    "en": {
        "txt6": "Guide",
        "txt7": "Transport"
    }
}


</i18n>
<template>
    <a class="card-border link block color-dark link-bordered flex1 flex-column" :href="event['href']">
        <div class="flex mb5 flex-full">
            <div class="col8">
                <div class="mb5 flex1 flex-v-start">
                    <p class="link link-orange mr10 fz18 lh11">
                        {{ event['name'] ? event['name_formatted'] + ', ' : '' }}<br v-if="event['name']">
                        {{ $t('event.txt1') }}: {{ event['start_formatted'] }}<br>
                    </p>
                    <span class="card-bages">
                        <span v-if="event['draft']" class="card-bages__item card-bages__item_draft tooltip-bottom"
                              :data-title="$t('event.txt3')">
                            <svg>
                                <use xlink:href="#ico-draft"></use>
                            </svg>
                        </span>
                        <span v-if="event['payment']" class="card-bages__item card-bages__item_pay tooltip-bottom"
                              :data-title="$t('event.txt4')">
                            <svg>
                                <use xlink:href="#ico-payment"></use>
                            </svg>
                        </span>
                        <span v-if="event['type'] == 2" class="card-bages__item card-bages__item_type tooltip-bottom"
                              :data-title="$t('event.type')[1]['name']">
                            <svg>
                                <use xlink:href="#ico-event-type2"></use>
                            </svg>
                        </span>
                        <span v-if="event['type'] == 3" class="card-bages__item card-bages__item_type tooltip-bottom"
                              :data-title="$t('event.type')[2]['name']">
                            <svg>
                                <use xlink:href="#ico-event-type3"></use>
                            </svg>
                        </span>
                        <span v-if="event['passenger']"
                              class="card-bages__item card-bages__item_passenger tooltip-bottom"
                              :data-title="$t('event.txt5')">
                            <svg>
                                <use xlink:href="#ico-passenger"></use>
                            </svg>
                        </span>
                    </span>
                </div>
                <div class="flex1 flex-wrap fz16 lh12 fw600 mb5">
                    <p class="mr5">{{ $t('event.txt2') }} "{{ event['travel']['name'] }}"</p>
                    <p class="mr5">{{ event['country_name'] }},</p>
                    <p class="mr5">{{ event['travel']['region'] }},</p>
                    <p class="mr5">{{ event['travel']['distance'] }} {{ $t('text.km') }},</p>
                    <p class="">{{ event['length_count'] }} {{ event['length_text'] }}</p>
                </div>
                <div class="flex1 flex-wrap fz14 lh12 mb5 hide-550">
                    <p class="mr5">{{ getNameById(event['travel']['surface'], $t('travel.surfaces')) }},</p>
                    <p class="mr5">{{ getNameById(event['difficult'], $t('text.difficult')) }},</p>
                    <p class="">{{ $t('txt6') }} {{ getNameById(event['travel']['escort'], $t('text.escort')) }}</p>
                </div>
                <div class="mb5 hide-550">
                    <div class="categ__months">
                        <div class="categ__month-wrap flex1" v-for="i in 12">
                            <p class="categ__month-name fz14">{{ $t('travel.availabilities_short')[i - 1]['name'] }}</p>
                            <div v-for="j in 2" class="categ__month categ__month"
                                 :class="[event['travel']['availability'].indexOf(i + '_' +j) > -1 ? 'categ__month categ__month_active' : '']"></div>
                        </div>
                    </div>
                </div>
                <p class="fz14 lh12">{{ event['description1'] }}</p>

                <p class="fz14 lh12 mr10" v-for="target in event['event_targets']">
                    {{ target['name'] }}
                </p>
            </div>
            <div class="col4">
                <div class="categ__image" v-if="event['image']">
                    <img class="block" :src="event['image']" alt="">
                </div>
            </div>
        </div>
        <div class="mb5 show-550">
            <div class="flex1 flex-wrap fz14 lh12">
                <p class="mr5">{{ getNameById(event['travel']['surface'], $t('travel.surfaces')) }},</p>
                <p class="mr5">{{ getNameById(event['difficult'], $t('text.difficult')) }},</p>
                <p class="">{{ $t('txt6') }} {{ getNameById(event['travel']['escort'], $t('text.escort')) }}</p>
            </div>
        </div>
        <div class=" mb5 show-550">
            <div class="categ__months">
                <div class="categ__month-wrap flex1" v-for="i in 12">
                    <p class="categ__month-name fz14">{{ $t('travel.availabilities_short')[i - 1]['name'] }}</p>
                    <div v-for="j in 2" class="categ__month categ__month"
                         :class="[event['travel']['availability'].indexOf(i + '_' +j) > -1 ? 'categ__month categ__month_active' : '']"></div>
                </div>
            </div>
        </div>
        <div class="categ__transport flex1 flex-v-center flex-wrap">
            <p class="fz16 color-gray mr10 mb5">{{ $t('txt7') }}:</p>

            <div v-for="transport in event['event_transports']" class="tooltip-bottom mr5 mb5"
                 :data-title="transport['name']" v-html="transport['svg']"></div>
        </div>
    </a>

</template>

<script>
export default {
    name: "EventCard",
    props: {
        event: Object
    },
    methods: {
        getNameById(id, scope) {
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
