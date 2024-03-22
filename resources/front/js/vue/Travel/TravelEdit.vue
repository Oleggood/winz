<i18n>
{
    "ru": {
        "crt_tx17": "Период доступности",
        "crt_tx18": "Доступно",
        "crt_tx18_1": "Выбрать все",
        "crt_tx19": "Недоступно",
        "crt_lb8": "Краткое описание",
        "crt_lb15": "Возможные трудности и опасности",
        "crt_tx16": "Придумайте название",
        "crt_tx15": "Выберите подходящий транспорт",
        "crt_lb10": "Если у вас есть фотографии указанной местности - загрузите их (не более 10 шт)",
        "crt_btn1": "При сохранении черновика вы сможете вернуться к редактированию маршрута позже. Найти сохраненные черновики можно в личном кабинете",
        "crt_btn1_1": "Вы можете перенести маршрут в черновики и опубликовать его позже. Найти сохраненные черновики можно в личном кабинете",
        "crt_btn2": "После создания маршрута он будет опубликован для всех пользователей сайта",
        "crt_btn2_1": "Вы можете внести изменения, пока не создано ни одного прохождения данного маршрута",
        "create": "Создать маршрут",
        "crt_err5": "Укажите хотя бы одну точку на карте",
        "delete": "Удалить маршрут?<br> Это действие необратимо!",
        "srf_tx1": "Виды транспорта, рекомендованные для этой поверхности выделены <span class='color-green'>зеленым цветом</span>. Вы можете отметить их все, нажав кнопку:",
        "srf_tx3": "Отметить все"
    },
    "en": {
        "crt_tx17": "Availability period",
        "crt_tx18": "Available",
        "crt_tx18_1": "Select all",
        "crt_tx19": "Unavailable",
        "crt_lb8": "Short description",
        "crt_lb15": "Possible difficulties and dangers",
        "crt_tx16": "Name",
        "crt_tx15": "Choose suitable transport",
        "crt_lb10": "If you have photos of the area - upload them (no more 10 pcs)",
        "crt_btn1": "If you save the draft, you can go back to editing the route later. You can find saved drafts in your personal account",
        "crt_btn1_1": "You can transfer the route to drafts and publish it later. You can find saved drafts in your personal account",
        "crt_btn2": "After publication, the route will be available to other users of the site.",
        "crt_btn2_1": "You can change the route until it is overcome by anyone",
        "create": "Create a route",
        "crt_err5": "Specify at least one point on the map",
        "delete": "Delete a route?<br> This action is irreversible!",
        "srf_tx1": "Types of transport recommended for this surface are highlighted <span class='color-green'>green</span>. To mark them all, click:",
        "srf_tx3": "Select all"
    }
}

</i18n>
<template>
    <div>
        <div class="flex flex-wrap">
            <div class="col6 col12-768 mb20">
                <travel-edit-map v-model="geo_info">
                </travel-edit-map>
                <div class="mb20 show-550">
                    <block-input :label="$t('crt_tx16')"
                                 :error="errors['name']"
                                 v-model="travelLocal['name']">
                    </block-input>
                </div>
                <div class="mb40">
                    <div class="mb20">
                        <block-calendar :label="$t('crt_tx17')"
                                        v-model="travelLocal['availability']"
                                        :error="errors['availability']"
                                        :selected="travelLocal['availability_parsed']">
                        </block-calendar>
                    </div>
                    <div class="flex1 flex-v-center mb10">
                        <div class="flex1 flex-v-center mr10">
                            <div class="map__avail mr10"></div>
                            <p class="fz16">{{ $t('crt_tx18') }}</p>
                        </div>
                        <div class="flex1 flex-v-center">
                            <div class="map__not-avail mr10"></div>
                            <p class="fz16">{{ $t('crt_tx19') }}</p>
                        </div>
                    </div>
                </div>
                <div class="mb20">
                    <block-input :label="$t('crt_lb15')"
                                 :error="errors['description2']"
                                 :textarea="true"
                                 v-model="travelLocal['description2']">
                    </block-input>
                </div>
                <div class="mb20">
                    <block-input :label="$t('crt_lb8')"
                                 :error="errors['description1']"
                                 :textarea="true"
                                 v-model="travelLocal['description1']">
                    </block-input>
                </div>
                <div>
                    <p class="fz17 fw600 mb10">{{ $t('crt_lb10') }}</p>
                    <block-multi-photo :files="travelLocal['images']"
                                       :max="10"
                                       v-model="travelLocal['images']">
                    </block-multi-photo>
                </div>
            </div>
            <div class="col6 col12-768 mb20 trvl1">
                <div class="mb20 hide-550">
                    <block-input :label="$t('crt_tx16')"
                                 :error="errors['name']"
                                 v-model="travelLocal['name']">
                    </block-input>
                </div>
                <div :class="[travelLocal['surface'] ? 'mb10' : 'mb20']">
                    <block-select :label="$t('travel.surface_name')"
                                  :values="$t('travel.surfaces')"
                                  :error="errors['surface']"
                                  v-model="travelLocal['surface']">
                    </block-select>
                </div>
                <div class="mb20" v-if="travelLocal['surface']">
                    <block-multi-checkbox v-model="travelLocal['transports']"
                                          :label="$t('crt_tx15')"
                                          :error="errors['transports']"
                                          :all_transports="all_transports"
                                          :recommended="recommendedTransports">
                    </block-multi-checkbox>
                </div>
                <div class="mb20">
                    <block-select :label="$t('text.difficult_name')"
                                  :values="$t('text.difficult')"
                                  :error="errors['difficult']"
                                  v-model="travelLocal['difficult']">
                    </block-select>
                </div>


                <div class="mb20">
                    <block-select :label="$t('text.escort_name')"
                                  :values="$t('text.escort')"
                                  :error="errors['escort']"
                                  v-model="travelLocal['escort']">
                    </block-select>
                </div>
            </div>
        </div>
        <div class="form-width mb10">
            <p class="fz16 lh14 mb10 color-gray" v-if="travelLocal['id']">{{ $t('crt_btn1') }}</p>
            <p class="fz16 lh14 mb10 color-gray" v-else>{{ $t('crt_btn1_1') }}</p>
            <p class="fz16 lh14 mb10 color-gray" v-if="travelLocal['id']">{{ $t('crt_btn2_1') }}</p>
            <p class="fz16 lh14 mb10 color-gray" v-else>{{ $t('crt_btn2') }}</p>
        </div>
        <div class="mb80">
            <div class="flex1 mb20">
                <button class="btn mr10" v-if="travelLocal['id']" @click.prevent="prepareToSave">
                    {{ $t('text.create_edit') }}
                </button>
                <button class="btn mr10" v-else @click.prevent="prepareToSave">{{ $t('create') }}</button>
                <button v-if="!travelLocal['id']" class="btn btn_trs mr10" @click.prevent="saveDraft">
                    {{ $t('text.draft') }}
                </button>
                <button v-if="(travelLocal['id'] && travelLocal['draft'] == 0)" class="btn btn_trs mr10"
                        @click.prevent="saveDraft">{{ $t('text.draft_move') }}
                </button>
                <button v-if="(travelLocal['id'] && travelLocal['draft'] == 1)" class="btn btn_trs mr10"
                        @click.prevent="saveClean">{{ $t('text.draft_publish') }}
                </button>
                <button v-if="travelLocal['id']" class="btn btn_red" @click.prevent="destroy">
                    {{ $t('text.delete') }}
                </button>
            </div>
            <div>
                <a :href="url_show" v-if="(travelLocal['id'] && travelLocal['draft'] == 0)" class="btn">
                    {{ $t('text.go_to_card') }}
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TravelEdit",
    props: {
        all_transports: Array,
        travel: Object,
    },
    data() {
        return {
            travelLocal: this.travel || {},
            url_destroy: '',
            url_save: route('travels.store'),
            url_get_rec_transports: route('get_recommended_transports'),
            url_show: '',
            errors: {},
            recommendedTransports: [],
            geo_info: {
                'points_parsed': this.travel['points_parsed'] || [],
                'country': this.travel['country'] || '-',
                'region': this.travel['region'] || '-',
                'distance': this.travel['distance'] || 0,
            },
        };
    },
    mounted() {
        if (this.travelLocal['id']) {
            this.url_show = route('travels.show', {'travel': this.travelLocal['id']});
            this.url_destroy = route('travels.destroy', {'travel': this.travelLocal['id']});
            this.url_save = route('travels.update', {'travel': this.travelLocal['id']});
        }
        window.preventExitPage(this.$t('text.leave_page'), this.$t('text.yes'), this.$t('text.no'))
    },
    methods: {
        prepareToSave(return_draft = false) {
            if (!this.geo_info['points']) {
                Swal.fire({
                    icon: 'error',
                    text: this.$t('crt_err5')
                })
            } else {
                this.$set(this.travelLocal, 'points_parsed', this.geo_info['points'])
                this.$set(this.travelLocal, 'country', this.geo_info['country'])
                this.$set(this.travelLocal, 'region', this.geo_info['region'])
                this.$set(this.travelLocal, 'distance', this.geo_info['distance'])
                let formData = new FormData();
                for (let i in this.travelLocal) {
                    if (i == 'images') {
                        for (let j in this.travelLocal['images']['images']) {
                            formData.append('images[]', this.travelLocal['images']['images'][j]);
                        }
                        formData.append('old_images', JSON.stringify(this.travelLocal['images']['old_images']));
                    } else if (i == 'transports') {
                        for (let j in this.travelLocal[i]) {
                            formData.append(i + '[]', this.travelLocal[i][j]);
                        }
                    } else if (i == 'availability' || i == 'points_parsed') {
                        formData.append(i, JSON.stringify(this.travelLocal[i]));
                    } else {
                        let val = this.travelLocal[i];
                        if (val !== null && val !== undefined)
                            formData.append(i, val);
                    }
                }
                this.save(formData, return_draft);
            }
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
                    this.showErrorModal();
                    window.showRequestErrors(err.response);
                    if (return_draft)
                        this.$set(this.travelLocal, 'draft', 1);
                });
        },
        showErrorModal() {
            let errors_text = '';
            if (this.errors) {
                if (this.errors['country'])
                    errors_text += this.errors['country'][0] + '<br>';
                if (this.errors['region'])
                    errors_text += this.errors['region'][0] + '<br>';
                if (this.errors['distance'])
                    errors_text += this.errors['distance'][0] + '<br>';
                if (this.errors['points_parsed'])
                    errors_text += this.errors['points_parsed'][0] + '<br>';
            }
            if (errors_text) {
                errors_text += this.$t('text.reload')
                Swal.fire({
                    icon: 'error',
                    html: errors_text
                })
            }
        },
        saveDraft() {
            this.$set(this.travelLocal, 'draft', 1);
            this.prepareToSave();
        },
        saveClean() {
            this.$set(this.travelLocal, 'draft', 0);
            this.prepareToSave(true);
        },
        destroy() {
            Swal.fire({
                html: this.$t('delete'),
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
                            $('.ajax-loader').hide();
                            window.formSendResponce(response.data)
                        })
                        .catch((err) => {
                            $('.ajax-loader').hide();
                            this.errors = err.response.data.errors;
                            this.showErrorModal();
                            window.showRequestErrors(err.response);
                        });
                }
            })

        },
        selectRecommendedTransports() {
            this.$set(this.travelLocal, 'transports', this.recommendedTransports);
        }
    },
    watch: {
        'travelLocal.surface': function () {
            axios.get(this.url_get_rec_transports + '?surface=' + this.travelLocal['surface'], {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then((response) => {
                    this.recommendedTransports = response.data;
                    this.selectRecommendedTransports();
                })
                .catch((err) => {
                });
        },
        travelLocal: {
            deep: true,
            handler() {
                window.page_was_edited = true;
            }
        },
        geo_info: {
            deep: true,
            handler() {
                window.page_was_edited = true;
            }
        }
    }
}
</script>

<style scoped>

</style>
