<template>
    <div class="flex flex-wrap">
        <div class="col6 col12-768">
            <p class="fz17 fw600 mb10">{{ $t('account.ava') }}</p>
            <div class="mb20 single-photo">
                <block-multi-photo :files="localUser['images']"
                                   :max="1"
                                   v-model="localUser['images']">
                </block-multi-photo>
            </div>
            <p class="fz17 mb20"><span class="color-gray">{{ $t('auth.input_email') }}</span>: {{ localUser['email'] }}
            </p>
            <div class="mb20">
                <block-input :label="$t('auth.input_phone')"
                             :error="errors['phone']"
                             :input_phone="true"
                             v-model="localUser['phone']"
                             :autocompleteoff="true">
                </block-input>
            </div>
            <div class="mb20">
                <p class="fz17 fw600 mb10">{{ $t('account.acd_tx1') }}</p>
                <block-input :label="$t('auth.input_password')"
                             :error="errors['password']"
                             :type="'password'"
                             v-model="localUser['password']"
                             :autocompleteoff="true">
                </block-input>
            </div>
        </div>
        <div class="col6 col12-768">
            <div v-if="localUser['type']">
                <p class="fz17 mb20">
                    <span class="color-gray">{{ $t('account.acd_tx4') }}:</span>
                    {{ getNameById(localUser['type'], $t('account.acd_tx5')) }}
                </p>
                <div v-if="localUser['type'] == 1">
                    <div class="flex flex_5">
                        <div class="col6 col_5 mb20">
                            <block-input :label="$t('auth.input_name')"
                                         :error="errors['name']"
                                         v-model="localUser['name']">
                            </block-input>

                        </div>
                        <div class="col6 col_5 mb20">
                            <block-input :label="$t('auth.input_lastname')"
                                         :error="errors['lastname']"
                                         v-model="localUser['lastname']">
                            </block-input>
                        </div>
                    </div>
                    <div class="flex flex_5">
                        <div class="col6 col_5 mb20">
                            <block-input :label="$t('account.aci_tx1')"
                                         :error="errors['nickname']"
                                         v-model="localUser['nickname']">
                            </block-input>

                        </div>
                        <div class="col6 col_5 mb20">
                            <block-select :label="$t('account.aci_tx6')"
                                          :values="$t('account.aci_tx5')"
                                          :error="errors['gender']"
                                          v-model="localUser['gender']">
                            </block-select>
                        </div>
                    </div>

                    <p class="fz17 mb10">{{ $t('account.aci_tx2') }}</p>
                    <div class="flex flex_5">
                        <div class="col3 col_5 mb20">
                            <block-select :label="$t('account.aci_tx2_1')"
                                          :values="this.dates"
                                          :disabled_options="days_disabled"
                                          :no-enter-label="true"
                                          :error="errors['birthday_day']"
                                          v-model="localUser['birthday_day']">
                            </block-select>
                        </div>
                        <div class="col5 col_5 mb20">
                            <block-select :label="$t('account.aci_tx2_2')"
                                          :values="$t('account.aci_tx7')"
                                          :noEnterLabel="true"
                                          :error="errors['birthday_month']"
                                          v-model="localUser['birthday_month']">
                            </block-select>
                        </div>
                        <div class="col4 col_5 mb20">
                            <block-select :label="$t('account.aci_tx2_3')"
                                          :values="this.years"
                                          :noEnterLabel="true"
                                          :error="errors['birthday_year']"
                                          v-model="localUser['birthday_year']">
                            </block-select>
                        </div>
                    </div>
                    <div class="mb20">
                        <block-select :label="$t('account.aci_tx24')"
                                      :values="this.params['countries']"
                                      :multiple="true"
                                      :error="errors['countries']"
                                      v-model="localUser['countries']">
                        </block-select>
                    </div>
                    <vue-slide-up-down :active="Object.keys(this.regions).length !== 0">
                        <div class="mb20">
                            <p class="fz17 mb20">{{ $t('account.aci_tx26') }}</p>
                            <block-select :label="$t('account.aci_tx27')" ref="region"
                                          :values="this.regions"
                                          v-model="localUser['region']">
                            </block-select>
                        </div>
                    </vue-slide-up-down>
                    <div class="mb20">
                        <block-select :label="$t('account.aci_tx25')"
                                      :values="this.params['transports']"
                                      :multiple="true"
                                      :group="true"
                                      :error="errors['transports']"
                                      v-model="localUser['transports']">
                        </block-select>
                    </div>
                    <div class="mb20">
                        <div class="mb10">
                            <block-checkbox :label="$t('account.aci_tx8')"
                                            v-model="localUser['blogger']">
                            </block-checkbox>
                        </div>
                        <vue-slide-up-down :active="!!localUser['blogger']" name="slide">
                            <block-input :label="$t('account.aci_tx9')"
                                         :error="errors['blog_link']"
                                         v-model="localUser['blog_link']">
                            </block-input>
                        </vue-slide-up-down>
                    </div>
                    <div class="mb20">
                        <div class="mb10">
                            <block-checkbox :label="$t('account.aci_tx11')"
                                            v-model="localUser['photographer']">
                            </block-checkbox>
                        </div>
                        <vue-slide-up-down :active="!!localUser['photographer']" name="slide">
                            <block-input :label="$t('account.aci_tx12')"
                                         :error="errors['video_link']"
                                         v-model="localUser['video_link']">
                            </block-input>
                        </vue-slide-up-down>
                    </div>
                    <div class="mb20">
                        <block-checkbox :label="$t('account.aci_tx13')"
                                        v-model="localUser['guide']">
                        </block-checkbox>
                    </div>
                    <div class="mb20">
                        <block-input :label="$t('account.acie_tx1')"
                                     :textarea="true"
                                     :error="errors['about']"
                                     v-model="localUser['about']">
                        </block-input>
                    </div>
                    <div class="mb20">
                        <block-input :label="$t('account.acie_tx2')"
                                     :textarea="true"
                                     :error="errors['socials']"
                                     v-model="localUser['socials']">
                        </block-input>
                    </div>
                </div>
                <div v-if="localUser['type'] == 2">
                    <div class="mb20">
                        <block-input :label="$t('account.aci_tx17')"
                                     :error="errors['name']"
                                     v-model="localUser['name']">
                        </block-input>
                    </div>
                    <div class="mb20">
                        <block-input :label="$t('account.aci_tx18')"
                                     :error="errors['code']"
                                     v-model="localUser['code']">
                        </block-input>
                    </div>
                    <div class="mb20">
                        <block-select :label="$t('account.aci_tx21')"
                                      :values="$t('account.aci_tx20')"
                                      :error="errors['specialization']"
                                      v-model="localUser['specialization']">
                        </block-select>
                    </div>
                    <div class="mb20">
                        <block-input :label="$t('account.aci_tx22')"
                                     :error="errors['site_link']"
                                     v-model="localUser['site_link']">
                        </block-input>
                    </div>
                    <div class="mb20">
                        <block-input :label="$t('account.crt_lb8')"
                                     :textarea="true"
                                     :error="errors['about']"
                                     v-model="localUser['about']">
                        </block-input>
                    </div>
                    <div class="mb20">
                        <block-select :label="$t('account.aci_tx23')"
                                      :values="this.params['countries']"
                                      :multiple="true"
                                      :error="errors['countries']"
                                      v-model="localUser['countries']">
                        </block-select>
                    </div>
                </div>
            </div>
            <div v-else>
                <div class="mb20">
                    <block-select :label="$t('account.acd_tx4')"
                                  :values="$t('account.acd_tx5')"
                                  :error="errors['type']"
                                  v-model="localUser['type']">
                    </block-select>
                </div>
            </div>
        </div>
        <div class="col12">
            <button @click="save" class="btn">{{ $t('account.acd_tx3') }}</button>
        </div>
    </div>
</template>

<script>
export default {
    name: "FormAccount",
    props: {
        user: Object,
        params: Object,
    },
    data() {
        let user = this.user;
        user.password = '';
        return {
            localUser: user,
            errors: {},
            days_disabled: [{
                'id': 32,
                'name': 32
            }],
            apply_type_url: route('apply_user_type'),
            save_url: route('save_user_data'),
            dates: this.returnDays(),
            years: this.returnYears(),
            regions: [],
            month_length: [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
            regions_by_country_url: route('regions_by_country')
        }
    },
    mounted() {
        this.updateBirthday();
    },
    methods: {
        returnDays() {
            let dates = [];
            for (let i = 1; i <= 31; i++) {
                dates.push({
                    'id': i,
                    'name': i
                });
            }
            return dates;
        },
        returnYears() {
            let years = [];
            for (let i = (new Date()).getFullYear() - 18; i > 1901; i--) {
                years.push({
                    'id': i,
                    'name': i
                });
            }
            return years;
        },
        isLeapYear(y) {
            return !(y & 3 || !(y % 25) && y & 15);
        },
        updateBirthday() {
            let month = this.localUser['birthday_month'],
                isLeap = this.isLeapYear(this.localUser['birthday_year']);
            if (month) {
                this.days_disabled = [];
                for (let i = 1; i <= 32; i++) {
                    if (i <= this.month_length[month - 1]) {
                        if (i == 29 && month == 2 && !isLeap) {
                            this.days_disabled.push({
                                'id': i,
                                'name': i
                            })
                        }
                    } else {
                        this.days_disabled.push({
                            'id': i,
                            'name': i
                        })
                    }
                }
            } else {
                this.days_disabled = [];
                this.days_disabled.push({
                    'id': 32,
                    'name': 32
                });
            }
        },
        save() {
            $('.ajax-loader').show();
            let formData = new FormData();
            for (let i in this.localUser) {
                if (i == 'images') {
                    for (let j in this.localUser[i]['images']) {
                        formData.append('images[]', this.localUser[i]['images'][j]);
                    }
                    formData.append('old_images', JSON.stringify(this.localUser['images']['old_images']));
                } else if (i == 'transports' || i == 'countries') {
                    for (let j in this.localUser[i]) {
                        formData.append(i + '[]', this.localUser[i][j]);
                    }
                } else {
                    let val = this.localUser[i];
                    if (val !== null && val !== undefined)
                        formData.append(i, val);
                }
            }
            axios.post(this.save_url, formData, {
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
                });
        },
        getNameById(id, scope) {
            return window.getNameById(id, scope);
        }
    },
    watch: {
        'localUser.countries': function () {
            if (this.localUser['countries'] && this.localUser['countries'].length == 1) {
                axios.get(this.regions_by_country_url + `?str=` + this.localUser['countries'][0])
                    .then((response) => {
                        this.regions = response.data;
                        $('.ajax-loader').hide();
                    });

            } else {
                this.regions = [];
                this.localUser['region'] = ''
            }
        },
        'localUser.type': {
            deep: true,
            handler(newVal, oldVal) {
                let component = this;
                if (component.localUser['type'] && newVal != oldVal) {
                    Swal.fire({
                        text: this.$t('account.acd_tx6'),
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#ddd',
                        confirmButtonText: this.$t('text.yes'),
                        cancelButtonText: this.$t('text.no')
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: component.apply_type_url,
                                method: 'get',
                                data: {
                                    'type': component.localUser['type'],
                                },
                                success: function () {

                                }
                            });
                        } else {
                            component.localUser['type'] = '';
                        }
                    })
                }
            }
        },
        'localUser.birthday_year': {
            deep: true,
            handler() {
                this.updateBirthday()
            }
        },
        'localUser.birthday_month': {
            deep: true,
            handler() {
                this.updateBirthday()
            }
        }
    }
}
</script>

<style scoped>

</style>
