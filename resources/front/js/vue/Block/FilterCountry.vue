<i18n>
{
    "ru": {
        "txt1": "Страна",
        "txt2": "Регион"
    },
    "en": {
        "txt1": "Country",
        "txt2": "Region"
    }
}
</i18n>
<template>
    <div>
        <div class="mb20">
            <block-select :label="$t('txt1')" ref="country"
                          :values="this.all_countries"
                          v-model="country">
            </block-select>
        </div>
        <vue-slide-up-down :active="Object.keys(this.regions).length !== 0">
            <div class="mb20">
                <block-select :label="$t('txt2')" ref="region"
                              :values="this.regions"
                              v-model="region">
                </block-select>
            </div>
        </vue-slide-up-down>
    </div>
</template>

<script>
export default {
    name: "FilterCountry",
    props: {
        all_countries: [],
    },
    mounted() {

    },
    data() {
        return {
            country: this.$attrs['value']['country'],
            region: this.$attrs['value']['region'],
            regions: this.$attrs['regions'],
            regions_by_country_url: route('regions_by_country')
        };
    },
    watch: {
        country: function () {
            if (this.country) {
                $('.ajax-loader').show();
                axios.get(this.regions_by_country_url + `?str=` + this.country)
                    .then((response) => {
                        this.regions = response.data;
                        $('.ajax-loader').hide();
                    });

            } else {
                this.regions = [];
                this.region = ''
            }
            this.changeValue();
        },
        region: function () {
            this.changeValue();
        }
    },
    methods: {
        changeValue() {
            this.$emit('input', {
                'country': this.country,
                'region': this.region,
            })
        },
        animateEnter(el) {
            $(el).fadeIn('slow')
        },
        animateLeave(el) {
            $(el).fadeOut('slow')
        }
    }
}
</script>

<style scoped>

</style>
