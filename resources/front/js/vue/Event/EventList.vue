
<template>
    <div class="flex  catalog">
        <div class="catalog__filter-shadow"></div>
        <div class="col3 catalog__filter">
            <div class="catalog__filter-close">
                <svg>
                    <use xlink:href="#ico-close"></use>
                </svg>
            </div>
            <div class="filter">
                <div class="filter__wrap mb10">
                    <div class="flex1 flex-v-center mb20">
                        <p class="fz20 fw600 flex-full">{{ $t('text.ct_tx2') }}</p>
                        <a v-if="this.clearEnabled" :href="this.events_url"
                           class="link link-blue fz14 filter__reset">{{ $t('text.ct_tx4') }}</a>
                    </div>
                    <div class="mb20">
                        <filter-country :all_countries="this.params['all_countries']"
                                        :regions="this.params['regions']"
                                        v-model="filter['geo']" refs="geo">

                        </filter-country>
                    </div>
                    <block-slider :min="1"
                                  :max="this.params['distance_max']"
                                  :step="1"
                                  :title="$t('text.ct_tx18')"
                                  v-model="filter['distances']">
                    </block-slider>
                    <div class="mb20">
                        <block-input :label="$t('travel.ntf_cns_tx4')"
                                     v-model="filter['like']['name']">
                        </block-input>
                    </div>
                    <div class="mb10">
                        <div class="fz17 fw600 mb20">{{ $t('event.ct_tx6') }}</div>
                        <div class="flex flex_5">
                            <div class="col6 col_5 mb10">
                                <block-date-time
                                    v-model="filter['start']['min']"
                                    :formattedValue="filter['start']['min']"
                                    :type="'date'"
                                    :format="'DD.MM.YYYY'"
                                    :value_type="'YYYY-MM-DD'"
                                    :label="$t('event.ct_tx6_1')">
                                </block-date-time>
                            </div>
                            <div class="col6 col_5 mb10">
                                <block-date-time
                                    v-model="filter['start']['max']"
                                    :formattedValue="filter['start']['max']"
                                    :type="'date'"
                                    :format="'DD.MM.YYYY'"
                                    :value_type="'YYYY-MM-DD'"
                                    :label="$t('event.ct_tx6_2')">
                                </block-date-time>
                            </div>
                        </div>
                    </div>
                    <block-slider :min="0"
                                  :max="this.params['length_max']"
                                  :step="1"
                                  :title="$t('event.ct_tx7')"
                                  v-model="filter['lengths']">
                    </block-slider>
                    <div class="mb20">
                        <block-select :label="$t('event.target_name')"
                                      :values="this.params['all_targets']"
                                      multiple
                                      v-model="filter['targets']">
                        </block-select>
                    </div>
                    <div class="mb20">
                        <block-select :label="$t('text.difficult_name')"
                                      :values="$t('text.difficult')"
                                      v-model="filter['same']['events.difficult']">
                        </block-select>
                    </div>
                    <div :class="[filter['transports'].length ? 'mb10' : 'mb20']">
                        <block-select :label="$t('text.transport_name')"
                                      :values="this.params['all_transports']"
                                      :group="true"
                                      multiple
                                      v-model="filter['transports']">
                        </block-select>
                    </div>
                    <div class="mb20" v-if="filter['transports'].length">
                        <div class="mb5">
                            <block-checkbox :label="$t('event.pt_tx3_1')"
                                            v-model="filter['similar_transports']">
                            </block-checkbox>
                        </div>
                        <p class="fz14 lh15 color-gray">{{ $t('event.pt_tx3_2') }}</p>
                    </div>
                    <div class="mb20">
                        <block-select :label="$t('event.ct_tx12')"
                                      :values="$t('event.ct_tx11')"
                                      v-model="filter['payment']">
                        </block-select>
                    </div>
                    <div class="mb20">
                        <block-select :label="$t('event.ct_tx16')"
                                      :values="$t('event.ct_tx15')"
                                      v-model="filter['same']['passenger']">
                        </block-select>
                    </div>
                    <button v-on:click="sendFilter" class="btn btn_med btn_full filter__btn">
                        {{ $t('text.ct_tx3') }}
                    </button>
                </div>
            </div>
        </div>
        <div class="col9 col12-768">
            <div class="flex flex-v-center mb20">
                <div class="col0 flex-full">
                    <h1 class="fz36 fw600">{{ $t('event.title') }}</h1>
                </div>
                <div class="col0 show-768">
                    <div class="catalog__filter-button btn">
                        <svg class="mr5">
                            <use xlink:href="#ico-filter"></use>
                        </svg>
                        {{ $t('text.filter') }}
                    </div>
                </div>
            </div>
            <div class="categ__tabs">
                <a href="#categ__tab1">{{ $t('text.tab1') }}</a>
                <a href="#categ__tab2">{{ $t('text.tab2') }}</a>
            </div>
            <div id="categ__tab1">
                <div class="categ flex flex_5 flex-wrap"
                     v-if="!this.was_filtered">
                    <div class="col6 col_5 mb10 col12-768" v-for="ind in per_page">
                        <div class="card-border">
                            <div class="mb10">
                                <vue-skeleton-loader :width="150" :height="20"/>
                            </div>
                            <div class="mb10">
                                <vue-skeleton-loader :width="200" :height="16"/>
                            </div>
                            <div class="mb10">
                                <vue-skeleton-loader :width="300" :height="32"/>
                            </div>
                            <div class="mb10">
                                <vue-skeleton-loader :width="240" :height="28"/>
                            </div>
                            <div class="mb10">
                                <vue-skeleton-loader :width="300" :height="25"/>
                            </div>
                            <div>
                                <vue-skeleton-loader :width="300" :height="28"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="categ flex flex_5 flex-wrap">
                    <div class="col6 col_5 mb10 col12-768" v-for="event in this.events" :key="event['id']">
                        <event-card :event="event"></event-card>
                    </div>
                </div>
                <div v-if="Object.keys(this.events).length === 0 && this.was_filtered">
                    {{ $t('text.nothing_found') }}
                </div>
            </div>
            <div id="categ__tab2">
                <div class="map__frame relative">
                    <l-map ref="myMap"></l-map>
                    <div id="mapdiv" class="travel-list__map"></div>
                    <div class=" map__legend">
                        <div class="mb10">
                            <a :data-title="$t('event.map.crt_tx6')" href="#"
                               class="tooltip-right btn btn_small map__btn js-map-fullscreen">
                                <svg>
                                    <use xlink:href="#ico-map-full"></use>
                                </svg>
                                <span>{{ $t('event.map.crt_tx6') }}</span>
                            </a>
                            <a :data-title="$t('event.map.crt_tx7')" href="#" style="display: none;"
                               class="tooltip-right btn btn_small map__btn js-map-window">
                                <svg>
                                    <use xlink:href="#ico-map-small"></use>
                                </svg>
                                <span>{{ $t('event.map.crt_tx7') }}</span>
                            </a>
                        </div>
                        <div class="mb10">
                            <a v-if="this.show_start_markers" :data-title="$t('event.map.lst_tx4')" href="#"
                               class="tooltip-right btn btn_small map__btn" @click.prevent="hideStart">
                                <svg>
                                    <use xlink:href="#ico-start"></use>
                                </svg>

                                <span>{{ $t('event.map.lst_tx4_2') }}</span>
                            </a>
                            <a v-else :data-title="$t('event.map.lst_tx4')" href="#"
                               class="tooltip-right btn btn_small btn_off map__btn" @click.prevent="showStart">
                                <svg>
                                    <use xlink:href="#ico-start"></use>
                                </svg>

                                <span>{{ $t('event.map.lst_tx4_1') }}</span>
                            </a>
                        </div>
                        <div class="mb10">

                            <a v-if="this.show_end_markers" :data-title="$t('event.map.lst_tx5')" href="#"
                               class="tooltip-right btn btn_small map__btn" @click.prevent="hideEnd">
                                <svg>
                                    <use xlink:href="#ico-end"></use>
                                </svg>

                                <span>{{ $t('event.map.lst_tx5_2') }}</span>
                            </a>
                            <a v-else :data-title="$t('event.map.lst_tx5')" href="#"
                               class="tooltip-right btn btn_small btn_off map__btn" @click.prevent="showEnd">
                                <svg>
                                    <use xlink:href="#ico-end"></use>
                                </svg>

                                <span>{{ $t('event.map.lst_tx5_1') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <pagination :current="parseInt(filter['page'])" :max="parseInt(max_pages)"
                        v-on:switch_page="switchPage"></pagination>
        </div>
    </div>
</template>

<script>
export default {
    name: "EventList",
    props: {
        params: {}
    },
    data() {
        let url_params = (new URLSearchParams(window.location.search));
        let targets = [],
            transports = [],
            page;
        for (let key of url_params) {
            if (key[0].indexOf('targets') > -1)
                targets.push(key[1]);
            if (key[0].indexOf('transports') > -1)
                transports.push(key[1]);
            if (key[0].indexOf('page') > -1 && key[1] != 1)
                page = key[1];
        }
        return {
            events_url: route('events.index'),
            events_url_filtered: route('events.filtered'),
            events: Array,
            was_filtered: false,
            start_points: [],
            end_points: [],
            start_markers: [],
            end_markers: [],
            points: [],
            lines: [],
            show_end_markers: true,
            show_start_markers: true,
            clearEnabled: false,
            filter: {
                geo: {
                    'country': url_params.get('geo[country]') || '',
                    'region': url_params.get('geo[region]') || '',
                },
                same: {
                    'events.difficult': url_params.get('same[events.difficult]') || '',
                    'passenger': url_params.get('same[passenger]') || '',
                },
                distances: {
                    min: url_params.get('distances[min]') || '',
                    max: url_params.get('distances[max]') || '',
                },
                start: {
                    min: url_params.get('start[min]') || '',
                    max: url_params.get('start[max]') || '',
                },
                lengths: {
                    min: url_params.get('lengths[min]') || '',
                    max: url_params.get('lengths[max]') || '',
                },
                like: {
                    'name': url_params.get('like[name]') || '',
                },
                targets: targets,
                transports: transports,
                payment: url_params.get('payment') || '',
                page: page
            },
            max_pages: 1,
            per_page: window.events_per_page
        }
    },

    mounted() {
        window.initMap();
        this.sendFilter();
    },
    methods: {
        sendFilter() {
            $('.ajax-loader').show();
            closeFilter();
            this.events = [];
            this.was_filtered = false;
            let string = window.getQueryString(this.events_url, this.filter);
            this.clearEnabled = !!string.length;
            axios.get(this.events_url_filtered + `?${string}`)
                .then((response) => {
                    this.events = response.data.events;
                    let comp = this;
                    this.max_pages = response.data.max_pages;
                    if (this.filter['page'] > this.max_pages) {
                        this.filter['page'] = this.max_pages;
                        window.getQueryString(this.travels_url, this.filter)
                    }
                    if (this.filter['page'] < 1) {
                        this.filter['page'] = 1;
                        window.getQueryString(this.travels_url, this.filter)
                    }
                    this.rearrangePoints(function () {
                        comp.was_filtered = true;
                        $('.ajax-loader').hide();
                    });
                });
        },
        rearrangePoints(callback = null) {
            this.start_markers = window.removeMarkers(this.start_markers);
            this.end_markers = window.removeMarkers(this.end_markers);
            this.lines = window.removeLines(this.lines);
            this.start_points = [];
            this.end_points = [];
            this.points = [];
            for (let i in this.events) {
                let temp_points = [];
                let current_points = JSON.parse(this.events[i]['travel']['points']);
                let html_start = `<p><a class="link link-blue" href="` + this.events[i]['href'] + `">`
                    + this.events[i]['start_formatted'] + `</a> `
                    + this.$t('event.pt_tx1') + `</p>
    <p><span class="color-gray">` + this.$t('event.pt_tx2') + `:</span>` + this.events[i]['travel']['distance'] + `</p>
    <p><span class="color-gray">` + this.$t('event.pt_tx3') + `:</span>`;
                let html_end = `<p><a class="link link-blue" href="` + this.events[i]['href'] + `">`
                    + this.events[i]['end_formatted'] + `</a> `
                    + this.$t('event.pt_tx4') + `</p>
    <p><span class="color-gray">` + this.$t('event.pt_tx2') + `:</span>` + this.events[i]['travel']['distance'] + `</p>
    <p><span class="color-gray">` + this.$t('event.pt_tx3') + `:</span>`;
                let transport_text = '';
                for (let j in this.events[i]['event_transports']) {
                    transport_text += `<span>` + this.events[i]['event_transports'][j]['name'] + `</span>`;
                    if (transport_text)
                        transport_text += `, `
                }
                html_start += transport_text + `</div>`;
                html_end += transport_text + `</div>`;
                this.start_points.push([
                    this.events[i]['travel']['start_parsed'][0],
                    this.events[i]['travel']['start_parsed'][1],
                    html_start
                ]);
                if (this.events[i]['travel']['start_parsed'] != this.events[i]['travel']['end_parsed']) {
                    temp_points.push(this.start_points[this.start_points.length - 1]);
                    for (let j in current_points) {
                        temp_points.push(current_points[j]);
                    }
                }
                this.end_points.push([
                    this.events[i]['travel']['end_parsed'][0],
                    this.events[i]['travel']['end_parsed'][1],
                    html_end
                ]);
                temp_points.push(this.end_points[this.end_points.length - 1]);
                this.points.push(temp_points);
            }
            let result_arr = [];
            if (this.show_start_markers) {
                this.start_markers = window.addMarkers(this.start_points, this.start_markers, window.flagStart);
                result_arr = this.start_points;
            }
            if (this.show_end_markers) {
                this.end_markers = window.addMarkers(this.end_points, this.end_markers, window.flagEnd);
                result_arr = this.end_points;
            }
            if (this.show_start_markers && this.show_end_markers) {
                this.lines = window.addLines(this.points);
                result_arr = this.start_points.concat(this.end_points);
            }
            if (result_arr.length) {
                window.map.fitBounds(result_arr, {maxZoom: 15})
            } else {
                window.map.setView([54, 38], 2)
            }
            if (callback)
                callback();
        },
        showStart() {
            this.start_markers = window.addMarkers(this.start_points, this.start_markers, window.flagStart);
            this.show_start_markers = true;
            if (this.show_end_markers)
                this.lines = window.addLines(this.points);
        },
        hideStart() {
            this.show_start_markers = false;
            this.start_markers = window.removeMarkers(this.start_markers);
            this.lines = window.removeLines(this.lines);
        },
        showEnd() {
            this.end_markers = window.addMarkers(this.end_points, this.end_markers, window.flagEnd);
            this.show_end_markers = true;
            if (this.show_start_markers)
                this.lines = window.addLines(this.points);
        },
        hideEnd() {
            this.show_end_markers = false;
            this.end_markers = window.removeMarkers(this.end_markers);
            this.lines = window.removeLines(this.lines);
        },
        switchPage(page) {
            this.filter['page'] = page;
            this.sendFilter()
        },
    },
    watch: {}
}
</script>

