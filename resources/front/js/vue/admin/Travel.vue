<template>
    <div class="mb60">
        <h2 class="fz36 fw600 mb20">Блок администратора</h2>
        <div class="flex">
            <div class="col6 col12-768">
                <div class="card-border form-width">
                    <p class="fz20 fw600 color-green mb20">Изменение статуса события</p>
                    <div class="mb20">
                        <block-select :label="'Новый статус'"
                                      :values="values"
                                      :error="errors['status']"
                                      v-model="form['status']">
                        </block-select>
                    </div>
                    <div class="mb20">
                        <div class="mb10">
                            <block-checkbox :label="'Уведомить автора'"
                                            v-model="form['notify']">
                            </block-checkbox>
                        </div>
                        <block-input :label="'Причина (будет отправлена автору)'"
                                     :error="errors['message']"
                                     v-model="form['message']">
                        </block-input>
                    </div>
                    <button class="btn btn_red mb20" @click="saveStatus">Изменить статус</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "AdminTravel",
    props: {
        travel: {},
        values: [],
    },
    data() {
        return {
            errors: {},
            form: {
                'travel_id': this.travel['id']
            },
            urlSaveStatus: route('back.travels.cancel'),
        }
    },
    methods: {
        saveStatus() {
            $('.ajax-loader').show();
            let formData = new FormData();
            for (let i in this.form) {
                let val = this.form[i];
                if (val !== null && val !== undefined)
                    formData.append(i, val);
            }
            axios.post(this.urlSaveStatus, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then((response) => {
                    window.location.reload()
                })
                .catch((err) => {
                    this.errors = err.response.data.errors;
                    window.showRequestErrors(err.response);
                });
        }
    }

}
</script>

<style scoped>

</style>
