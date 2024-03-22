<i18n>
{
    "ru": {
        "title": "Маршруты",
        "pt_tx1": "Старт",
        "pt_tx2": "Дистанция",
        "pt_tx3": "Транспорт",
        "pt_tx4": "Финиш",
        "pt_tx5": "Только мои маршруты"
    },
    "en": {
        "title": "Routes",
        "pt_tx1": "Start",
        "pt_tx2": "Distance",
        "pt_tx3": "Transport",
        "pt_tx4": "Finish",
        "pt_tx5": "Only my routes"

    }
}

</i18n>
<template>
    <div class="flex catalog">
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
                        <a v-if="this.clearEnabled" :href="this.travels_url" class="link link-blue fz14 filter__reset">
                            {{ $t('text.ct_tx4') }}
                        </a>
                    </div>
                    <div>
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
                    <div class="mb20">
                        <block-select :label="$t('travel.surface_name')"
                                      :values="$t('travel.surfaces')"
                                      multiple
                                      v-model="filter['surfaces']">
                        </block-select>
                    </div>
                    <div class="mb20">
                        <block-select :label="$t('text.difficult_name')"
                                      :values="$t('text.difficult')"
                                      v-model="filter['same']['difficult']">
                        </block-select>
                    </div>
                    <div class="mb20">
                        <block-select :label="$t('text.escort_name')"
                                      :values="$t('text.escort')"
                                      v-model="filter['same']['escort']">
                        </block-select>
                    </div>
                    <div class="mb20">
                        <block-calendar :label="$t('travel.availabilities_name')"
                                        v-model="filter['availability']">
                        </block-calendar>
                    </div>
                    <div class="mb20">
                        <block-select :label="$t('text.transport_name')"
                                      :values="this.params['all_transports']"
                                      :group="true"
                                      multiple
                                      v-model="filter['transports']">
                        </block-select>
                    </div>
                    <div class="mb20" v-if="params['auth']">
                        <label class="st-checkbox">
                            <input v-model="filter['only_my']" type="checkbox">
                            <span class="st-checkbox__dot"></span>
                            <span class="fz17">
                                {{ $t('pt_tx5') }}
                            </span>
                        </label>
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
                    <h1 class="fz36 fw600">{{ $t('title') }}</h1>
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
                <div class="categ flex flex_5 flex-wrap" v-else>
                    <div class="col6 col_5 mb10 col12-768" v-for="travel in this.travels" :key="travel['id']">
                        <travel-card :travel="travel"></travel-card>
                    </div>
                </div>
                <div v-if="Object.keys(this.travels).length === 0 && this.was_filtered">
                    {{ $t('text.nothing_found') }}
                </div>
            </div>
            <div id="categ__tab2">
                <div class="map__frame relative">
                    <l-map ref="myMap"></l-map>
                    <div id="mapdiv" class="travel-list__map"></div>
                    <div class=" map__legend">
                        <div class="mb10">
                            <a :data-title="$t('map.crt_tx6')" href="#"
                               class="tooltip-right btn btn_small map__btn js-map-fullscreen">
                                <svg>
                                    <use xlink:href="#ico-map-full"></use>
                                </svg>
                                <span>{{ $t('map.crt_tx6') }}</span>
                            </a>
                            <a :data-title="$t('map.crt_tx7')" href="#" style="display: none;"
                               class="tooltip-right btn btn_small map__btn js-map-window">
                                <svg>
                                    <use xlink:href="#ico-map-small"></use>
                                </svg>
                                <span>{{ $t('map.crt_tx7') }}</span>
                            </a>
                        </div>
                        <div class="mb10">
                            <a v-if="this.show_start_markers" :data-title="$t('map.lst_tx4')" href="#"
                               class="tooltip-right btn btn_small map__btn" @click.prevent="hideStart">
                                <svg>
                                    <use xlink:href="#ico-start"></use>
                                </svg>

                                <span>{{ $t('map.lst_tx4_2') }}</span>
                            </a>
                            <a v-else :data-title="$t('map.lst_tx4')" href="#"
                               class="tooltip-right btn btn_small btn_off map__btn" @click.prevent="showStart">
                                <svg>
                                    <use xlink:href="#ico-start"></use>
                                </svg>

                                <span>{{ $t('map.lst_tx4_1') }}</span>
                            </a>
                        </div>
                        <div class="mb10">

                            <a v-if="this.show_end_markers" :data-title="$t('map.lst_tx5')" href="#"
                               class="tooltip-right btn btn_small map__btn" @click.prevent="hideEnd">
                                <svg>
                                    <use xlink:href="#ico-end"></use>
                                </svg>

                                <span>{{ $t('map.lst_tx5_2') }}</span>
                            </a>
                            <a v-else :data-title="$t('map.lst_tx5')" href="#"
                               class="tooltip-right btn btn_small btn_off map__btn" @click.prevent="showEnd">
                                <svg>
                                    <use xlink:href="#ico-end"></use>
                                </svg>

                                <span>{{ $t('map.lst_tx5_1') }}</span>
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
    name: "TravelList",
    props: {
        params: {}
    },
    mounted() {
        window.initMap();
        this.sendFilter()
    },
    data() {
        let url_params = (new URLSearchParams(window.location.search));
        let transports = [],
            availability = [],
            surfaces = [],
            page,
            only_my = this.params['auth'] && url_params.get('only_my') ? url_params.get('only_my') : '';
        for (let key of url_params) {
            if (key[0].indexOf('transports') > -1)
                transports.push(key[1]);
            if (key[0].indexOf('surfaces') > -1)
                surfaces.push(key[1]);
            if (key[0].indexOf('availability') > -1)
                availability.push(key[1]);
            if (key[0].indexOf('page') > -1 && key[1] != 1)
                page = key[1];
        }
        return {
            travels_url: route('travels.index'),
            travels_url_filtered: route('travels.filtered'),
            travels: Array,
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
                    'difficult': url_params.get('same[difficult]') || '',
                    'escort': url_params.get('same[escort]') || '',
                },
                like: {
                    'name': url_params.get('like[name]') || '',
                },
                distances: {
                    min: url_params.get('distances[min]') || '',
                    max: url_params.get('distances[max]') || '',
                },
                only_my: only_my,
                surfaces: surfaces,
                availability: availability,
                transports: transports,
                page: page
            },
            max_pages: 1,
            per_page: window.travels_per_page,
        }
    },
    methods: {
        sendFilter() {
            $('.ajax-loader').show();
            this.skeleton_length = Object.keys(this.travels).length || 10;
            this.travels = [];
            this.was_filtered = false;
            let string = window.getQueryString(this.travels_url, this.filter);
            this.clearEnabled = !!string.length;
            axios.get(this.travels_url_filtered + `?${string}`)
                .then((response) => {
                    this.travels = response.data.travels;
                    this.max_pages = response.data.max_pages;
                    if (this.filter['page'] > this.max_pages) {
                        this.filter['page'] = this.max_pages;
                        window.getQueryString(this.travels_url, this.filter)
                    }
                    if (this.filter['page'] < 1) {
                        this.filter['page'] = 1;
                        window.getQueryString(this.travels_url, this.filter)
                    }
                    let comp = this;
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
            for (let i in this.travels) {
                let temp_points = [];
                let current_points = this.travels[i]['points_parsed'];
                let html_start = `<p><a class="link link-blue" href="` + this.travels[i]['href'] + `">` + this.travels[i]['name'] + `</a> `
                    + this.$t('pt_tx1') + `</p>
    <p><span class="color-gray">` + this.$t('pt_tx2') + `:</span>` + this.travels[i]['distance'] + `</p>
    <p><span class="color-gray">` + this.$t('pt_tx3') + `:</span>`;
                let html_end = `<p><a class="link link-blue" href="` + this.travels[i]['href'] + `">` + this.travels[i]['name'] + `</a> `
                    + this.$t('pt_tx4') + `</p>
    <p><span class="color-gray">` + this.$t('pt_tx2') + `:</span>` + this.travels[i]['distance'] + `</p>
    <p><span class="color-gray">` + this.$t('pt_tx3') + `:</span>`;
                let transport_text = '';
                for (let j in this.travels[i]['travel_transports']) {
                    transport_text += `<span>` + this.travels[i]['travel_transports'][j]['name'] + `</span>`;
                    if (transport_text)
                        transport_text += `, `
                }
                html_start += transport_text + `</div>`;
                html_end += transport_text + `</div>`;
                this.start_points.push([
                    this.travels[i]['start_parsed'][0],
                    this.travels[i]['start_parsed'][1],
                    html_start
                ]);
                if (this.travels[i]['start_parsed'] != this.travels[i]['end_parsed']) {
                    temp_points.push(this.start_points[this.start_points.length - 1]);
                    for (let j in current_points) {
                        temp_points.push(current_points[j]);
                    }
                }
                this.end_points.push([
                    this.travels[i]['end_parsed'][0],
                    this.travels[i]['end_parsed'][1],
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
        }
    }
}
</script>

<style scoped>

</style>
