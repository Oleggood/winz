<template>
    <div>
        <div class="flex1 flex-v-start mb5">
            <a v-if="event['status'] == 1" class="link link-orange mr10 fz16 lh12" :href="event['href']">
                {{ event['name'] ? event['name'] + ', ' : '' }}<br v-if="event['name']">
                <span v-if="event['start_formatted']">
                    <span v-if="event['before_start']['invert']">{{ $t('event.txt1') }}:</span>
                    <span v-else>{{ $t('event.txt1_2') }}:</span>
                    {{ event['start_formatted'] }}
                </span>
                <span v-else>
                    {{ $t('event.txt1_1') }},
                </span>
                {{ $t('event.txt2') }} "{{ event['travel']['name'] }}"
                <span v-if="event['start_formatted']">
                    (<span v-if="event['before_start']['invert']">{{ $t('event.prt_tx6') }}</span>
                    {{ event['before_start']['days'] }}
                    {{ $t('event.prt_tx6_1') }}
                    {{ event['before_start']['h'] }}
                    {{ $t('event.prt_tx6_2') }}
                <span v-if="!event['before_start']['invert']">{{ $t('event.txt1_3') }}</span>)
                </span>
            </a>
            <span v-else class="mr10 fz16 lh12 color-error">
                <span>{{ getNameById(event['status'], $t('event.states')) }}</span><br>
                {{ event['name'] ? event['name'] + ', ' : '' }}<br v-if="event['name']">
                <span v-if="event['start_formatted']">
                    <span v-if="event['before_start']['invert']">{{ $t('event.txt1') }}:</span>
                    <span v-else>{{ $t('event.txt1_2') }}:</span>
                    {{ event['start_formatted'] }}
                </span>
            </span>
            <span class="card-bages">
                <span v-if="event['draft']" class="card-bages__item card-bages__item_draft tooltip-left"
                      :data-title="$t('event.txt3')">
                    <svg>
                        <use xlink:href="#ico-draft"></use>
                    </svg>
                </span>
                <span v-if="event['payment']" class="card-bages__item card-bages__item_pay tooltip-left"
                      :data-title="$t('event.txt4')">
                    <svg>
                        <use xlink:href="#ico-payment"></use>
                    </svg>
                </span>
                <span v-if="event['type'] == 2" class="card-bages__item card-bages__item_type tooltip-left"
                      :data-title="$t('event.type')[1]['name']">
                    <svg>
                        <use xlink:href="#ico-event-type2"></use>
                    </svg>
                </span>
                <span v-if="event['type'] == 3" class="card-bages__item card-bages__item_type tooltip-left"
                      :data-title="$t('event.type')[2]['name']">
                    <svg>
                        <use xlink:href="#ico-event-type3"></use>
                    </svg>
                </span>
                <span v-if="event['passenger']" class="card-bages__item card-bages__item_passenger tooltip-left"
                      :data-title="$t('event.txt5')">
                    <svg>
                        <use xlink:href="#ico-passenger"></use>
                    </svg>
                </span>
            </span>
        </div>
        <div class="flex1 flex-wrap mb10 lh12">
            <p class="fz16 mr5">{{ event['country_name'] }},</p>
            <p class="fz16 mr5">{{ event['travel']['region'] }},</p>
            <p class="fz16 mr5">{{ event['travel']['distance'] }} {{ $t('text.km') }},</p>
            <p class="fz16 mr5">{{ event['length_count'] }} {{ event['length_text'] }}</p>
        </div>
    </div>

</template>

<script>
export default {
    name: "EventCard",
    props: {
        event: Object
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
