<i18n>
{
    "ru": {
        "search": "Поиск",
        "crt_tx1": "Отменить последнюю точку",
        "crt_tx9": "Удалить все точки",
        "crt_tx10": "Вы уверены, что ходите удалить все точки маршрута, и начать сначала?",
        "crt_tx10_2": "Все текущие точки будут удалены. Продолжить?",
        "crt_tx2": "Точки расположены слишком близко",
        "crt_tx3": "Точки расположены слишком далеко",
        "crt_tx9_3": "Вы можете создать маршрут добавляя точки на карте, либо загрузив трек в формате gpx. После загрузки трека вы можете его отредактировать - подвинуть или добавить точки.",
        "crt_tx9_1": "Загрузить трек",
        "crt_tx11": "Страна",
        "crt_tx12": "Регион",
        "crt_tx14": "Расстояние, км (примерно)",
        "crt_tx20": "Регион и страна определяются автоматически - просто поставьте точку на карте",
        "gpx_error": "Необходимо загрузить трек в формате gpx",
        "country_not_defined": "Страна не определена",
        "region_not_defined": "Регион не определен"
    },
    "en": {
        "search": "Search",
        "crt_tx1": "Cancel last point",
        "crt_tx9": "Remove all points",
        "crt_tx10": "Are you sure you want to delete all the waypoints and start over?",
        "crt_tx10_2": "All current points will be deleted. Continue?",
        "crt_tx2": "Dots are too close",
        "crt_tx3": "Dots are too far",
        "crt_tx9_3": "You can create a route by adding points on the map, or by uploading a track in gpx format. After loading the track, you can edit it - move or add points.",
        "crt_tx9_1": "Upload track",
        "crt_tx11": "Country",
        "crt_tx12": "Region",
        "crt_tx14": "Distance, km (approximately)",
        "crt_tx20": "The region and country are determined automatically - just put a point on the map",
        "gpx_error": "You must upload a track in GPX format",
        "country_not_defined": "The country is not defined",
        "region_not_defined": "The region is not defined"
    }
}


</i18n>
<template>
    <div class="mb20">
        <div class="relative map mb20">
            <div class="map__frame">
                <div class="map__search">
                    <div class="map__search-content"
                         :class="[this.search_visible ? 'map__search-content_visible' : '']">
                        <block-input :label="$t('search')"
                                     v-model="search_input">
                        </block-input>
                        <div class="map__search-result fz14" v-if="Object.keys(this.search_results).length !== 0">

                            <div v-for="(result, index) in this.search_results" class="link link-blue mb10"
                                 @click="setView(index)">{{ result['display_name'] }}
                            </div>
                        </div>
                    </div>
                    <div class="map__search-toggle btn btn_small map__btn" @click="toggleSearchInput">
                        <svg width="1.3rem" height="1.3rem">
                            <use xlink:href="#ico-search"></use>
                        </svg>
                    </div>
                </div>
                <div id="mapdiv" class="travel-form__map"></div>
                <div class="map__legend">
                    <p class="map__legend-distance fz16 mb10"><span class="color-gray">{{ $t('crt_tx14') }}:</span>
                        <span class="fw600">{{ this.distance.toFixed(2) }}</span></p>
                    <div class="mb10">
                        <button :data-title="$t('map.crt_tx6')"
                           class="btn btn_small map__btn js-map-fullscreen tooltip-right">
                            <svg>
                                <use xlink:href="#ico-full"></use>
                            </svg>
                            <span>{{ $t('map.crt_tx6') }}</span>
                        </button>
                        <button :data-title="$t('map.crt_tx7')" style="display: none;"
                           class="tooltip-right btn btn_small map__btn js-map-window">
                            <svg>
                                <use xlink:href="#ico-smallsize"></use>
                            </svg>
                            <span>{{ $t('map.crt_tx7') }}</span>
                        </button>
                    </div>
                    <div class="mb10">
                        <button :data-title="$t('crt_tx1')" class="tooltip-right btn btn_small map__btn"
                           @click.prevent="removePoint" :class="[Object.keys(this.points).length ? '' : 'disabled']">
                            <svg>
                                <use xlink:href="#ico-undo"></use>
                            </svg>
                            <span>{{ $t('crt_tx1') }}</span>
                        </button>
                    </div>
                    <div>
                        <button :data-title="$t('crt_tx9')" class="tooltip-right btn btn_small map__btn"
                           :class="[Object.keys(this.points).length ? '' : 'disabled']"
                           @click.prevent="deleteRoute">
                            <svg>
                                <use xlink:href="#ico-delete"></use>
                            </svg>
                            <span>{{ $t('crt_tx9') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <p class="fz17 color-gray mb10 lh15">{{ $t('crt_tx9_3') }}</p>
        <div class="mb20 relative">
            <label class="btn" for="track-input">
                <svg class="mr10" height="1rem" width="1rem">
                    <use xlink:href="#ico-upload"></use>
                </svg>
                <span>{{ $t('crt_tx9_1') }}</span>
            </label>
            <input type="file" id="track-input" @change="uploadFile">
        </div>
        <p class="fz17 color-gray mb10">{{ $t('crt_tx20') }}</p>
        <p class="fz17">
            <span class="color-gray">{{ $t('crt_tx11') }}:</span>
            <span class="fw600">{{ this.country_name }}</span>,
            <span class="color-gray">{{ $t('crt_tx12') }}:</span>
            <span class="fw600">{{ this.region }}</span>,
            <span class="color-gray">{{ $t('crt_tx14') }}:</span>
            <span class="fw600">{{ this.distance.toFixed(2) }}</span>
        </p>
    </div>
</template>

<script>
export default {
    name: "TravelEditMap",
    props: {},
    data() {
        return {
            search_visible: false,
            search_input: '',
            search_results: [],
            timer: null,
            points: this.$attrs['value']['points_parsed'] || [],
            markers: [],
            edit_lines: [],
            km: [],
            country: this.$attrs['value']['country'] || '',
            country_name: '-',
            region: this.$attrs['value']['region'] || '-',
            distance: this.$attrs['value']['distance'] || 0,
            get_country_url: route('get_country'),
            get_closest_routes_url: route('get_closest_routes'),
            regions_by_country_url: route('regions_by_country'),
        };
    },
    watch: {
        search_input: function () {
            let component = this;
            if (this.search_input) {
                let url = 'https://nominatim.openstreetmap.org?q=' + this.search_input + '&format=json';
                clearTimeout(this.timer);
                this.timer = setTimeout(function () {
                    axios.get(url)
                        .then((response) => {
                            component.search_results = response.data;
                        });
                }, 500)
            }
        },
        points: function () {
            this.changeValue();
        },
        country: function () {
            this.changeValue();
        },
        region: function () {
            this.changeValue();
        },
        distance: function () {
            this.changeValue();
        },
    },
    mounted() {
        window.initMap();
        let component = this;
        window.map.on('click', function (e) {
            component.addPoint(e.latlng.lat, e.latlng.lng);
        });
        document.addEventListener('keyup', this.keyupHandler);
        this.rearrangePoints();
    },
    methods: {

        /**
         * Переводит карту на точку, выбранную из результатов поиска
         */
        setView(index) {
            window.map.setView(L.latLng(this.search_results[index]['lat'], this.search_results[index]['lon']), 14);
            this.search_results = [];
            this.search_visible = false;
            this.search_input = '';
        },

        /**
         * Отслеживает Ctrl+Z
         */
        keyupHandler(event) {
            if (event.ctrlKey && event.code === 'KeyZ') {
                this.removePoint();
            }

        },

        /**
         * Показывает/скрывает поле поиска
         */
        toggleSearchInput() {
            this.search_visible = !this.search_visible;
            this.search_results = [];
        },

        /**
         * Название страны по коду
         */
        getCountryName(code) {
            axios.get(this.get_country_url + `?code=` + code)
                .then((response) => {
                    if (response.data) {
                        this.country_name = response.data;
                    } else {
                        this.country_name = this.$t('country_not_defined')
                    }
                });
        },

        /**
         * Расставляет существующие точки
         */
        rearrangePoints() {
            let component = this;
            if (component.points.length > 0) {
                let points_to_add = this.points;
                this.points = [];
                for (let i in points_to_add) {
                    this.addPoint(points_to_add[i][0], points_to_add[i][1], false);
                }
                map.fitBounds(component.points, {maxZoom: 15});
            } else {
                window.region = window.getCookie('region');
                window.country = window.getCookie('country');
                window.lat = window.getCookie('lat');
                window.lng = window.getCookie('lng');
                if (!window.region || !window.country || !window.lat || !window.lng) {
                    axios.get(`https://api.sypexgeo.net/json/`)
                        .then((response) => {
                            let answer = response.data;
                            component.updateRegion(answer.region.name_ru, answer.country.iso, answer.city.lat, answer.city.lon);
                            window.map.setView(L.latLng(lat, lng), 13);
                        });
                } else {
                    component.updateRegion(window.region, window.country, window.lat, window.lng);
                    window.map.setView(L.latLng(window.lat, window.lng), 13);
                }
            }
        },

        /**
         * Добавляет точку
         */
        addPoint(lat, lng, validation = true) {
            let current = [lat, lng], prev,
                component = this;
            if (!Object.keys(component.points).length) {
                component.getRegionByLanLng(lat, lng);
                component.searchClosestRoute(lat, lng);
            } else {
                prev = component.points[Object.keys(component.points).length - 1];
            }
            let distancesValid = true;
            if (validation)
                distancesValid = component.checkDistancesNewPoint(lat, lng)
            if (distancesValid) {
                component.points.push([lat, lng]);
                if (prev) {
                    component.edit_lines.push(L.polyline([current, prev], {color: 'red'}));
                    component.edit_lines[Object.keys(component.edit_lines).length - 1].addTo(window.map);
                    component.km.push(getDistanceFromLatLonInKm(prev[0], prev[1], lat, lng))
                }
                let options = {
                    'draggable': true,
                    'arr_index': Object.keys(component.points).length - 1,
                };
                if (Object.keys(component.markers).length) {
                    options.icon = redIcon
                } else {
                    options.icon = flagStart
                }
                component.markers.push(L.marker([lat, lng], options));
                component.markers[Object.keys(component.markers).length - 1].addTo(window.map)
                    .on('dragstart', function (ev) {
                        let i = ev.target.options.arr_index;
                        component.markers[i].old_lat_lng = component.points[i];
                    })
                    .on('drag', function (ev) {
                        let i = ev.target.options.arr_index,
                            lat_lng = [ev.latlng.lat, ev.latlng.lng];
                        component.markers[i].new_lat_lng = lat_lng;
                        component.setMarkerPosition(i, lat_lng);
                        component.recalcDistance();
                    })
                    .on('dragend', function (ev) {
                        let i = ev.target.options.arr_index;
                        if (component.checkDistancesExistingPoint(i, component.markers[i].new_lat_lng)) {
                            component.applyMarkerPosition(i, component.markers[i].new_lat_lng);
                            if (i == 0) {
                                component.getRegionByLanLng(component.markers[i].new_lat_lng[0], component.markers[i].new_lat_lng[1])
                            }
                        } else {
                            component.markers[i].setLatLng(component.markers[i].old_lat_lng);
                            component.setMarkerPosition(i, component.markers[i].old_lat_lng);
                        }
                        component.recalcDistance();
                    });
                component.recalcDistance();
            }
        },

        /**
         * Пересчитывает длину маршрута, подставляет в поля формы и инфо-блоки
         */
        recalcDistance() {
            this.distance = 0;
            for (let i in this.km) {
                this.distance += this.km[i];
            }
        },

        /**
         * Определяет регион по координатам
         */
        getRegionByLanLng(lat, lng) {
            let url = 'https://nominatim.openstreetmap.org/reverse?lat=' + lat
                    + '&lon=' + lng
                    + '&accept-language=' + window.getMapLocale()
                    + '&format=json',
                component = this;
            axios.get(url)
                .then((response) => {
                    let answer = response.data;
                    if (answer.error) {
                        Swal.fire({
                            icon: 'error',
                            confirmButtonColor: '#3085d6',
                            text: component.$t('text.error_other')
                        })

                        /*country_local = this.$t('country_not_defined');
                        region_local = this.$t('region_not_defined');
                        country_local_code = 'WORLD';*/
                    }
                    let region_local, country_local, country_local_code;
                    if (!answer.error && answer.address.state != null) {
                        region_local = answer.address.state;
                    }
                    if (!answer.error && answer.address.country != null) {
                        country_local_code = answer.address.country_code;
                        country_local = answer.address.country;
                    }
                    let fields = [
                        'municipality',
                        'province',
                        'county',
                        'city_district',
                        'region',
                        'village',
                        'territory',
                        'road',
                        'city'
                    ]
                    for (let field in fields) {
                        if (!region_local && answer.address[fields[field]] != null) {
                            region_local = answer.address[fields[field]];
                        }
                    }

                    if (!country_local) {
                        country_local = this.$t('country_not_defined');
                        region_local = this.$t('region_not_defined');
                        country_local_code = 'WORLD';
                    }

                    // Для сейшелов и прочей хуйни
                    if (country_local && !region_local)
                        region_local = country_local

                    let itms1 = ['Автономная Республика Крым', 'Республика Крым'];
                    if (itms1.indexOf(region_local) > -1) {
                        country_local_code = 'RU';
                        region_local = 'Республика Крым'
                    }

                    if (region_local) {
                        component.updateRegion(region_local, country_local_code, lat, lng, true);
                        component.country = country_local_code.toUpperCase();
                        component.region = region_local;
                        this.getCountryName(component.country);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            text: error_bug
                        });
                        window.sendErrorReport('Не определена область', answer, 'error_location');
                    }
                });
        },

        /**
         * Ищет маршруты, которые начинаются рядом с точкой старта
         */
        searchClosestRoute(lat, lng) {
            axios.get(this.get_closest_routes_url + `?code=` + window.country + `&region=` + window.region)
                .then((response) => {
                    let msg = response.data, html = '', num = 0;
                    for (let i in msg) {
                        let distance = window.getDistanceFromLatLonInKm(msg[i].start_parsed[0], msg[i].start_parsed[1], lat, lng);
                        if (distance < window.near_routes_radius) {
                            num++;
                            html += `<a class="link link-blue fz16" target="_blank" href="` + msg[i].href + `">`
                                + msg[i].name
                                + `(` + msg[i].distance + this.$t('text.km') + `)</a><br>`;
                        }
                    }
                    if (num) {
                        html = window.renderTemplate('near_travel_template', {
                            distance: window.near_routes_radius,
                            quantity: num
                        }) + html;
                        Swal.fire({
                            icon: 'question',
                            html: html
                        })
                    }
                });
        },

        /**
         * Заменяет координаты точки в маршруте (после передвигания маркера)
         */
        applyMarkerPosition(i, lat_lng) {
            this.points[i] = lat_lng;
        },

        /**
         * При смене позиции маркера, пересчитывая расстояние маршрута и двигает линии
         */
        setMarkerPosition(i, lat_lng) {
            if (this.edit_lines[i - 1]) {
                this.edit_lines[i - 1].setLatLngs([this.points[i - 1], lat_lng])
                this.km[i - 1] = getDistanceFromLatLonInKm(this.points[i - 1][0], this.points[i - 1][1], lat_lng[0], lat_lng[1]);
            }
            if (this.edit_lines[i]) {
                this.edit_lines[i].setLatLngs([this.points[i + 1], lat_lng])
                this.km[i] = getDistanceFromLatLonInKm(this.points[i + 1][0], this.points[i + 1][1], lat_lng[0], lat_lng[1]);
            }
        },

        /**
         * Проверяет расстояние до предыдущей точки до заданных координат (перед добавлением новой)
         */
        checkDistancesNewPoint(lat, lng) {
            let points_length = Object.keys(this.points).length
            if (!points_length)
                return true;
            let length1;
            if (this.points[points_length - 1]) {
                length1 = getDistanceFromLatLonInKm(
                    lat,
                    lng,
                    this.points[points_length - 1][0],
                    this.points[points_length - 1][1]
                )
                if (length1 > window.max_between_points) {
                    Swal.fire({
                        icon: 'warning',
                        text: this.$t('crt_tx3')
                    })
                    return false;
                }
            }
            return true;
        },

        /**
         * Проверяет расстояние от точки до соседних (для двигания точек)
         */
        checkDistancesExistingPoint(i, lat_lng) {
            let length1, length2
            if (this.points[i - 1]) {
                length1 = getDistanceFromLatLonInKm(
                    this.points[i - 1][0],
                    this.points[i - 1][1],
                    lat_lng[0],
                    lat_lng[1]
                );
                if (length1 < window.min_between_points) {
                    Swal.fire({
                        icon: 'warning',
                        text: this.$t('crt_tx2')
                    })
                    return false;
                }
                if (length1 > window.max_between_points) {
                    Swal.fire({
                        icon: 'warning',
                        text: this.$t('crt_tx3')
                    })
                    return false;
                }
            }
            if (this.points[i + 1]) {
                length2 = window.getDistanceFromLatLonInKm(
                    lat_lng[0],
                    lat_lng[1],
                    this.points[i + 1][0],
                    this.points[i + 1][1]
                )
                if (length2 < window.min_between_points) {
                    Swal.fire({
                        icon: 'warning',
                        text: this.$t('crt_tx2')
                    })
                    return false;
                }
                if (length2 > window.max_between_points) {
                    Swal.fire({
                        icon: 'warning',
                        text: this.$t('crt_tx3')
                    })
                    return false;
                }
            }
            return true;
        },
        /**
         * Сохраняет выбранный регион и координаты стартовой точки маршрута
         * @param loc_region
         * @param loc_country_code
         * @param loc_lat
         * @param loc_lng
         * @param search_closest
         */
        updateRegion(loc_region, loc_country_code, loc_lat, loc_lng, search_closest = false) {
            window.region = loc_region;
            window.country = loc_country_code.toUpperCase();
            window.setCookie('country', window.country, {expires: 1000000});
            window.setCookie('region', window.region, {expires: 1000000});
            window.lat = loc_lat;
            window.lng = loc_lng;
            setCookie('lat', window.lat, {expires: 1000000});
            setCookie('lng', window.lng, {expires: 1000000});
        },

        /**
         * Удаляет последнюю точку маршрута, обновляя все массивы
         */
        removePoint() {
            if (Object.keys(this.points).length > 1) {
                this.edit_lines[Object.keys(this.edit_lines).length - 1].remove(window.map);
                this.edit_lines.pop();
            }
            this.markers[Object.keys(this.markers).length - 1].remove(window.map);
            this.markers.pop();
            this.points.pop();
            this.km.pop();
            this.recalcDistance();
        },


        /**
         * Очищает маршрут
         */
        deleteRoute() {
            let component = this;
            Swal.fire({
                text: this.$t('crt_tx10'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#ddd',
                confirmButtonText: this.$t('text.yes'),
                cancelButtonText: this.$t('text.no')
            }).then((result) => {
                if (result.isConfirmed) {
                    component.clearPoints();
                }
            })
        },
        clearPoints() {
            for (let i in this.markers) {
                this.markers[i].remove(window.map);
            }
            for (let i in this.edit_lines) {
                this.edit_lines[i].remove(window.map);
            }
            this.km = [];
            this.markers = [];
            this.points = [];
            this.edit_lines = [];
            this.recalcDistance();
        },

        /**
         * Проверяет загруженный файл
         */
        uploadFile(event) {
            let file = event.target.files[0],
                component = this;
            if (/*!file.type.match(/gpx/)*/0) {
                //TODO разобраться, почему не определяется тип файла
                Swal.fire({
                    icon: 'warning',
                    text: this.$t('gpx_error')
                })
            } else {
                if (Object.keys(this.markers).length) {
                    Swal.fire({
                        text: this.$t('crt_tx10_2'),
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#ddd',
                        confirmButtonText: this.$t('text.yes'),
                        cancelButtonText: this.$t('text.no')
                    }).then((result) => {
                        if (result.isConfirmed) {
                            component.clearPoints();
                            component.addPointsFromTrack(file);
                        }
                    })
                } else {
                    component.addPointsFromTrack(file)
                }
            }
        },

        /**
         * Добавляет точки из загруженного файла
         * @param file
         */
        addPointsFromTrack(file) {
            let reader = new FileReader(), component = this;
            reader.readAsText(file);
            reader.onload = function () {
                let gpx = reader.result,
                    parser = new DOMParser(),
                    xmlDoc = parser.parseFromString(gpx, "text/xml"),
                    points = [];
                $(xmlDoc).find("trkpt").each(function () {
                    points.push([
                        $(this).attr("lat"),
                        $(this).attr("lon")
                    ]);
                });
                if (points.length) {
                    let last_added_dot = [points[0][0], points[0][1]];
                    component.addPoint(points[0][0], points[0][1], false);
                    for (let i = 1; i < points.length; i++) {
                        if (getDistanceFromLatLonInKm(last_added_dot[0], last_added_dot[1], points[i][0], points[i][1]) > window.min_between_points) {
                            component.addPoint(points[i][0], points[i][1], false);
                            last_added_dot = [points[i][0], points[i][1]];
                        }
                    }
                    map.fitBounds(points, {maxZoom: 15});
                } else {

                }
            };
        },

        changeValue() {
            this.$emit('input', {
                "points": this.points,
                "country": this.country,
                "region": this.region,
                "distance": this.distance,
            })
        }
    }
}
</script>

<style scoped>

</style>
