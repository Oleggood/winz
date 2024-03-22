<i18n>
{
    "ru": {
        "crt_tx14": "Расстояние, км (примерно)",
        "from_start": "От начала маршрута",
        "from_prev": "От предыдущей точки"
    },
    "en": {
        "crt_tx14": "Distance, km (approximately)",
        "from_start": "From the beginning of the route",
        "from_prev": "From the previous point"
    }
}

</i18n>
<template>
    <div class="relative map">
        <div class="map__frame">
            <div id="mapdiv" class="travel-form__map"></div>
            <div class="map__legend">
                <p class="map__legend-distance fz16 mb10"><span class="color-gray">{{ $t('crt_tx14') }}:</span> <span class="js-field-distance fw600">{{ this.distance }}</span></p>
                <div>
                    <button :data-title="$t('map.crt_tx6')" class="btn btn_small map__btn js-map-fullscreen tooltip-right">
                        <svg>
                            <use xlink:href="#ico-full"></use>
                        </svg>
                        <span>{{ $t('map.crt_tx6') }}</span>
                    </button>
                    <button :data-title="$t('map.crt_tx7')" style="display: none;" class="tooltip-right btn btn_small map__btn js-map-window">
                        <svg>
                            <use xlink:href="#ico-smallsize"></use>
                        </svg>
                        <span>{{ $t('map.crt_tx7') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TravelMap",
    props: {
        distance: Number,
        points: Array,
    },
    mounted() {
        window.initMap();
        this.rearrangePoints();
    },
    methods: {
        rearrangePoints() {
            let markers = [], lines = [], text, km_temp = 0, km = 0;
            for (let i = 0; i < this.points.length; i++) {
                if (i == 0) {
                    text = this.$t('text.start');
                    markers.push(L.marker([this.points[i][0], this.points[i][1]], {icon: flagStart}));
                } else {
                    lines.push(L.polyline([
                        [this.points[i][0], this.points[i][1]],
                        [this.points[i - 1][0], this.points[i - 1][1]]
                    ], {
                        color: 'red',
                    }));
                    lines[lines.length - 1].addTo(window.map);
                    km_temp = window.getDistanceFromLatLonInKm(this.points[i - 1][0], this.points[i - 1][1], this.points[i][0], this.points[i][1]);
                    km += km_temp;
                    text = this.$t('from_prev') + ': ' +
                        km_temp.toFixed(2) + this.$t('text.km') + '<br>' +
                        this.$t('from_start') + ': ' +
                        km.toFixed(2) + this.$t('text.km');
                    if (i == this.points.length - 1) {
                        markers.push(L.marker([this.points[i][0], this.points[i][1]], {icon: flagEnd}));
                    } else {
                        markers.push(L.marker([this.points[i][0], this.points[i][1]], {icon: smallIcon}));

                    }
                }
                markers[i].addTo(window.map).bindPopup(text);
            }
            window.map.fitBounds(this.points, {maxZoom: 15});
        }
    }
}
</script>

<style scoped>

</style>
