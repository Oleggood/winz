<template>
    <div>
        <div class="flex flex-wrap-768">
            <div class="col6 mb10 col12-768">
                <travel-card :travel="params['travel']"></travel-card>
            </div>
            <div class="col6 mb10 col12-768">
                <travel-map :distance="params['travel']['distance']"
                            :points="params['travel']['points_parsed']">
                </travel-map>
            </div>
        </div>
        <div class="flex mb20 flex-wrap-768">
            <div class="col6 mb20 col12-768">
                <div class="mb10">
                    <p class="fz17 fw600 mb10">{{ $t('event.evn_tx0') }}</p>
                    <block-multi-photo :files="eventLocal['images']"
                                       :max="1"
                                       v-model="eventLocal['images']">
                    </block-multi-photo>
                </div>
                <div class="mb20">
                    <block-input :label="$t('event.crt_tx51')"
                                 :error="errors['name']"
                                 v-model="eventLocal['name']">
                    </block-input>
                </div>
                <div class="mb20">
                    <div class="mb10">
                        <block-select :label="$t('event.crt_tx2')"
                                      :values="$t('event.type')"
                                      :error="errors['type']"
                                      v-model="eventLocal['type']">
                        </block-select>
                    </div>
                    <p class="fz17 lh14 fw600 mb10 color-gray" v-html="this.$t('event.crt_tx1_1')"></p>
                </div>
                <div class="mb20">
                    <block-select :label="$t('event.crt_tx4')"
                                  :values="$t('event.crt_tx5')"
                                  :error="errors['features']"
                                  v-model="eventLocal['features']">
                    </block-select>
                </div>
                <div class="mb20">
                    <block-select :label="$t('event.target_name')"
                                  :values="this.params['all_targets']"
                                  multiple
                                  :error="errors['targets']"
                                  v-model="eventLocal['targets']">
                    </block-select>
                </div>
                <div class="mb20">
                    <block-date-time
                        v-model="eventLocal['start']"
                        :error="errors['start']"
                        :formattedValue="eventLocal['start_formatted_edit']"
                        :type="'datetime'"
                        :format="'DD.MM.YYYY HH:mm'"
                        :value_type="'YYYY-MM-DD HH:mm'"
                        :label="$t('event.crt_tx6')">
                    </block-date-time>
                </div>
                <div class="mb20">
                    <block-select :label="$t('event.crt_tx50')"
                                  :values="timezones"
                                  :error="errors['timezone']"
                                  v-model="eventLocal['timezone']">
                    </block-select>
                </div>
                <div class="flex flex_5">
                    <div class="mb20 col6 col_5">
                        <block-input :label="$t('event.crt_tx7')"
                                     :error="errors['length_count']"
                                     :input_class="'input-mask-3'"
                                     v-model="eventLocal['length_count']">
                        </block-input>
                    </div>
                    <div class="mb20 col6 col_5">
                        <block-select :label="$t('event.crt_tx9')"
                                      :values="$t('event.crt_tx8')"
                                      :error="errors['length_unit']"
                                      v-model="eventLocal['length_unit']">
                        </block-select>
                    </div>
                </div>
                <p class="fz17 fw600 mb20">{{ $t('event.crt_tx10') }}:
                    {{ getNameById(params['travel']['difficult'], $t('text.difficult')) }}.
                    {{ $t('event.crt_tx10_1') }}</p>
                <div class="mb20">
                    <block-select :label="$t('text.difficult_name')"
                                  :values="$t('text.difficult')"
                                  v-model="eventLocal['difficult']">
                    </block-select>
                </div>
                <div class="tourist-block">
                    <p v-if="show_transport" class="fz17 fw600 mb20">{{ $t('event.crt_tx15_1') }}</p>
                    <p v-else class="fz17 fw600 mb20">{{ $t('event.crt_tx15') }}</p>
                </div>
                <div class="flex flex_5 flex-wrap-550">
                    <div class="col4 col_5 mb20 col12-550">
                        <block-input :label="$t('event.crt_tx16')"
                                     :input_class="'input-mask-3'"
                                     :error="errors['min_participant']"
                                     v-model="eventLocal['min_participant']">
                        </block-input>
                    </div>
                    <div class="col4 col_5 mb20 col12-550">
                        <block-input :label="$t('event.crt_tx17')"
                                     :input_class="'input-mask-3'"
                                     :error="errors['opt_participant']"
                                     v-model="eventLocal['opt_participant']">
                        </block-input>
                    </div>
                    <div class="col4 col_5 mb20 col12-550">
                        <block-input :label="$t('event.crt_tx18')"
                                     :input_class="'input-mask-3'"
                                     :error="errors['max_participant']"
                                     v-model="eventLocal['max_participant']">
                        </block-input>
                    </div>
                </div>
                <div class="mb20">
                    <div class="mb10">
                        <block-select :label="$t('text.transport_name')"
                                      :values="this.params['all_transports']"
                                      :group="true"
                                      :error="errors['transports']"
                                      :enabled="params['travel']['transports']"
                                      multiple
                                      v-model="eventLocal['transports']">
                        </block-select>
                    </div>
                    <p class="fz16 lh14 mb20 color-gray">{{ $t('event.crt_tx49') }}</p>
                </div>
                <vue-slide-up-down :active="show_transport" name="slide">
                    <div class="transport-block">
                        <div class="mb20">
                            <block-select :label="$t('event.crt_tx11')"
                                          :values="$t('event.crt_tx12')"
                                          :error="errors['transport_provided']"
                                          v-model="eventLocal['transport_provided']">
                            </block-select>
                        </div>
                        <div class="mb20">
                            <block-input :label="$t('event.crt_tx36')"
                                         :error="errors['transport_requirements']"
                                         :textarea="true"
                                         v-model="eventLocal['transport_requirements']">
                            </block-input>
                        </div>
                        <div class="mb20">
                            <block-checkbox :label="$t('event.crt_tx20')"
                                            v-model="eventLocal['teams']">
                            </block-checkbox>
                        </div>
                        <vue-slide-up-down :active="!!eventLocal['teams']" name="slide">
                            <div>
                                <div class="pb20">
                                    <div class="mb10">
                                        <block-checkbox :label="$t('event.crt_tx21')"
                                                        v-model="eventLocal['passenger']">
                                        </block-checkbox>
                                    </div>
                                    <p class="fz16 lh14 color-gray" v-html="$t('event.crt_tx23')"></p>
                                </div>
                                <div class="pb20">


                                    <div class="mb10">
                                        <block-checkbox :label="$t('event.crt_tx22')"
                                                        v-model="eventLocal['fixed_team']">
                                        </block-checkbox>
                                    </div>
                                    <p class="fz16 lh14 color-gray" v-html="$t('event.crt_tx24')"></p>
                                </div>
                                <vue-slide-up-down :active="!!eventLocal['fixed_team']" name="slide">
                                    <div>
                                        <p class="fz17 fw600 mb10">{{ $t('event.crt_tx19') }}</p>
                                        <div class="flex flex_5 flex-wrap-550">
                                            <div class="col4 col_5 mb20 col12-550">
                                                <block-input :label="$t('event.crt_tx16')"
                                                             :input_class="'input-mask-3'"
                                                             :error="errors['min_team']"
                                                             v-model="eventLocal['min_team']">
                                                </block-input>
                                            </div>
                                            <div class="col4 col_5 mb20 col12-550">
                                                <block-input :label="$t('event.crt_tx17')"
                                                             :input_class="'input-mask-3'"
                                                             :error="errors['opt_team']"
                                                             v-model="eventLocal['opt_team']">
                                                </block-input>
                                            </div>
                                            <div class="col4 col_5 mb20 col12-550">
                                                <block-input :label="$t('event.crt_tx18')"
                                                             :input_class="'input-mask-3'"
                                                             :error="errors['max_team']"
                                                             v-model="eventLocal['max_team']">
                                                </block-input>
                                            </div>
                                        </div>
                                    </div>
                                </vue-slide-up-down>
                            </div>
                        </vue-slide-up-down>
                    </div>
                </vue-slide-up-down>
            </div>
            <div class="col6 mb20 col12-768">
                <div class="mb20">
                    <block-select :label="$t('event.crt_tx26')"
                                  :values="$t('event.crt_tx25')"
                                  :error="errors['equipment']"
                                  v-model="eventLocal['equipment']">
                    </block-select>
                </div>
                <div class="mb20">
                    <block-select :label="$t('event.crt_tx27')"
                                  :values="$t('event.crt_tx25')"
                                  :error="errors['food']"
                                  v-model="eventLocal['food']">
                    </block-select>
                </div>
                <div class="mb20">
                    <block-select :label="$t('event.crt_tx28')"
                                  :values="$t('event.crt_tx29')"
                                  :error="errors['escort']"
                                  :disabled_options="params['travel']['escort'] == 1 ? [1] : [100]"
                                  v-model="eventLocal['escort']">
                    </block-select>
                </div>
                <div class="mb20">
                    <block-select :label="$t('event.crt_tx30')"
                                  :values="$t('event.crt_tx31')"
                                  :error="errors['lodging']"
                                  v-model="eventLocal['lodging']">
                    </block-select>
                </div>
                <vue-slide-up-down :active="eventLocal['lodging'] != 1" name="slide">
                    <div class="mb20">
                        <block-select :label="$t('event.crt_tx32')"
                                      :values="$t('event.crt_tx33')"
                                      :error="errors['accommodations']"
                                      v-model="eventLocal['accommodations']">
                        </block-select>
                    </div>
                </vue-slide-up-down>
                <div class="mb20">
                    <block-select :label="$t('event.crt_tx34')"
                                  :values="$t('event.crt_tx35')"
                                  :error="errors['min_preparation']"
                                  v-model="eventLocal['min_preparation']">
                    </block-select>
                </div>
                <div class="mb20">
                    <block-input :label="$t('event.crt_tx37')"
                                 :error="errors['equipment_requirements']"
                                 :textarea="true"
                                 v-model="eventLocal['equipment_requirements']">
                    </block-input>
                </div>
                <div class="mb20">
                    <block-input :label="$t('event.crt_tx38')"
                                 :error="errors['other_requirements']"
                                 :textarea="true"
                                 v-model="eventLocal['other_requirements']">
                    </block-input>
                </div>
                <div>
                    <div class="mb20">
                        <block-checkbox :label="$t('event.crt_tx41')"
                                        v-model="eventLocal['payment_checkbox']">
                        </block-checkbox>
                    </div>
                    <vue-slide-up-down :active="!!eventLocal['payment'] || !!eventLocal['payment_checkbox']"
                                       name="slide">
                        <div>
                            <div class="flex flex_5 flex-wrap">
                                <div class="col6 col_5 mb20">
                                    <block-input :label="$t('event.crt_tx39')"
                                                 :error="errors['payment']"
                                                 :input_class="'input-mask-7'"
                                                 v-model="eventLocal['payment']">
                                    </block-input>
                                </div>
                                <div class="col6 col_5 mb20">
                                    <block-select :label="$t('event.crt_tx40')"
                                                  :values="params['all_currencies']"
                                                  :error="errors['currency']"
                                                  v-model="eventLocal['currency']">
                                    </block-select>
                                </div>
                                <div class="col12 col_5 mb20">
                                    <block-input :label="$t('event.crt_tx42')"
                                                 :error="errors['payment_requirements']"
                                                 :textarea="true"
                                                 v-model="eventLocal['payment_requirements']">
                                    </block-input>
                                </div>
                            </div>
                        </div>
                    </vue-slide-up-down>
                </div>
                <div class="mb20">
                    <block-select :label="$t('event.crt_tx43')"
                                  :values="$t('event.crt_tx44')"
                                  :error="errors['transfer']"
                                  v-model="eventLocal['transfer']">
                    </block-select>
                </div>
                <div class="mb20">
                    <div class="mb10">
                        <block-input :label="$t('event.crt_tx45')"
                                     :error="errors['description']"
                                     :textarea="true"
                                     v-model="eventLocal['description']">
                        </block-input>
                    </div>
                    <p class="fz16 lh14 mb10 color-gray">{{ $t('event.crt_tx46') }}</p>

                </div>
            </div>
        </div>
        <div class="form-width mb10">
            <p class="fz16 lh14 mb10 color-gray" v-if="eventLocal['id']">{{ $t('event.crt_btn1') }}</p>
            <p class="fz16 lh14 mb10 color-gray" v-else>{{ $t('event.crt_btn1_1') }}</p>
            <p class="fz16 lh14 mb10 color-gray" v-if="eventLocal['id']">{{ $t('event.crt_btn2_1') }}</p>
            <p class="fz16 lh14 mb10 color-gray" v-else>{{ $t('event.crt_btn2') }}</p>
        </div>
        <div class="mb80">
            <div class="flex1 mb20">
                <button class="btn mr10" v-if="eventLocal['id']" @click.prevent="prepareToSave">
                    {{ $t('text.create_edit') }}
                </button>
                <button class="btn mr10" v-else @click.prevent="prepareToSave">{{ $t('event.create') }}</button>
                <button v-if="!eventLocal['id']" class="btn btn_trs mr10" @click.prevent="saveDraft">
                    {{ $t('text.draft') }}
                </button>
                <button v-if="(eventLocal['id'] && eventLocal['draft'] == 0)" class="btn btn_trs mr10"
                        @click.prevent="saveDraft">{{ $t('text.draft_move') }}
                </button>
                <button v-if="(eventLocal['id'] && eventLocal['draft'] == 1)" class="btn btn_trs mr10"
                        @click.prevent="saveClean">{{ $t('text.draft_publish') }}
                </button>
                <button v-if="eventLocal['id']" class="btn btn_red" @click.prevent="destroy">{{
                        $t('text.delete')
                    }}
                </button>
            </div>
            <div>
                <a :href="url_show" v-if="(eventLocal['id'] && eventLocal['draft'] == 0)" class="btn">
                    {{ $t('text.go_to_card') }}
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "EventEdit",
    props: {
        params: Object,
        event: Object
    },
    data() {
        return {
            eventLocal: this.event || {},
            errors: {},
            show_transport: false,
            show_passengers: false,
            url_save: route('events.store'),
            url_show: '',
            url_destroy: '',
            url_get_timezones: route('get_timezones'),
            timezones: [],
        }
    },
    mounted() {
        if (this.eventLocal['id']) {
            this.url_destroy = route('events.destroy', {'event': this.eventLocal['id']});
            this.url_show = route('events.show', {'event': this.eventLocal['id']});
            this.url_save = route('events.update', {'event': this.eventLocal['id']});
        } else {
            this.eventLocal['difficult'] = this.params['travel']['difficult']
        }
        if (this.eventLocal['new_targets']) {
            this.eventLocal['targets'] = this.eventLocal['new_targets']
        }
        if (this.eventLocal['new_transports'])
            this.eventLocal['transports'] = this.eventLocal['new_transports'];
        this.getAllTimeZones();
        this.setTimezone();
        if (this.eventLocal && this.eventLocal['payment'])
            this.eventLocal['payment_checkbox'] = 1;
        window.preventExitPage(this.$t('text.leave_page'), this.$t('text.yes'), this.$t('text.no'))
    },
    watch: {
        eventLocal: {
            deep: true,
            handler() {
                this.recalcBlockVisibility();
            }
        }
    },
    methods: {
        recalcBlockVisibility() {
            window.page_was_edited = true;
            this.show_transport = false;
            this.show_passengers = false;
            let int_transports = [];
            for (let i in this.eventLocal['transports']) {
                int_transports.push(parseInt(this.eventLocal['transports'][i]));
            }
            for (let i in this.params['all_transports']) {
                for (let j in this.params['all_transports'][i]['items']) {
                    if (int_transports && int_transports.indexOf(this.params['all_transports'][i]['items'][j]['id']) > -1) {
                        if (this.params['all_transports'][i]['items'][j]['passengers']) {
                            this.show_passengers = true;
                        }
                        if (this.params['all_transports'][i]['id'] != 1) {
                            this.show_transport = true;
                        }
                    }
                }
            }
        },
        prepareToSave(return_draft = false) {
            let formData = new FormData();
            for (let i in this.eventLocal) {
                if (i == 'images') {
                    for (let j in this.eventLocal[i]['images']) {
                        formData.append('images[]', this.eventLocal[i]['images'][j]);
                    }
                    formData.append('old_images', JSON.stringify(this.eventLocal['images']['old_images']));
                } else if (i == 'targets' || i == 'transports') {
                    for (let j in this.eventLocal[i]) {
                        formData.append(i + '[]', this.eventLocal[i][j]);
                    }
                } else {
                    let val = this.eventLocal[i];
                    if (val !== null && val !== undefined)
                        formData.append(i, val);
                }
                formData.append('travel_id', this.params['travel']['id']);
            }
            this.save(formData, return_draft);
        },
        save(formData, return_draft) {
            $('.ajax-loader').show();
            axios.post(this.url_save, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then((response) => {
                    window.formSendResponce(response.data)
                })
                .catch((err) => {
                    this.errors = err.response.data.errors;
                    window.showRequestErrors(err.response);
                    if (return_draft)
                        this.$set(this.eventLocal, 'draft', 1);
                });
        },
        saveDraft() {
            this.$set(this.eventLocal, 'draft', 1);
            this.prepareToSave();
        },
        saveClean() {
            this.$set(this.eventLocal, 'draft', 0);
            this.prepareToSave(true);
        },
        getAllTimeZones() {
            axios.get(this.url_get_timezones)
                .then((response) => {
                    this.timezones = response.data;
                });
        },
        setTimezone() {
            if (!this.eventLocal['timezone']) {
                let coord = JSON.parse(this.params['travel']['start_point']);
                let url = 'https://dev.virtualearth.net/REST/v1/timezone/' + coord[0] + ',' + coord[1] + '?key=' + window.BING_API_KEY;
                axios.get(url)
                    .then((response) => {
                        try {
                            let zone = response.data.resourceSets[0].resources[0].timeZone.utcOffset;
                            if (zone.indexOf('-') !== 0)
                                zone = '+' + zone;
                            this.eventLocal['timezone'] = zone;
                            this.$forceUpdate();
                        } catch {
                        }
                    });
            }
        },
        destroy() {
            Swal.fire({
                html: this.$t('event.delete'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e55353',
                cancelButtonColor: '#ddd',
                confirmButtonText: this.$t('text.yes'),
                cancelButtonText: this.$t('text.no')
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(this.url_destroy)
                        .then((response) => {
                            window.formSendResponce(response.data)
                        })
                        .catch((err) => {
                            this.errors = err.response.data.errors;
                            window.showRequestErrors(err.response);
                        });
                }
            })

        },
        getNameById(id, scope){
            return window.getNameById(id, scope);
        }
    }
}
</script>

<style scoped>

</style>
