<i18n>
{
    "ru": {
        "rv_tx1": "Опишите ваши впечатления от участия в событии",
        "rv_tx2": "Насколько точным было описание маршрута",
        "rv_tx3": "Насколько точным было описание события",
        "rv_tx4": "Насколько хорошо было организовано событие",
        "rv_tx5": "Отправить",
        "rv_tx6": "Добавьте фотографии события"
    },
    "en": {
        "rv_tx1": "Describe your impressions from participation in the event",
        "rv_tx2": "How accurate was the description of the route",
        "rv_tx3": "How accurate was the description of the event",
        "rv_tx4": "How well the event was organized",
        "rv_tx5": "Submit",
        "rv_tx6": "Add event photos"
    }
}
</i18n>
<template>
    <div>
        <div class="mb20">
            <block-review :label="$t('rv_tx2')"
                          :identifier="'rating_travel'"
                          :error="errors['rating_travel']"
                          v-model="form['rating_travel']">
            </block-review>
        </div>
        <div class="mb20">
            <block-review :label="$t('rv_tx3')"
                          :identifier="'rating_event'"
                          :error="errors['rating_event']"
                          v-model="form['rating_event']">
            </block-review>
        </div>
        <div class="mb20">
            <block-review :label="$t('rv_tx4')"
                          :identifier="'rating_user'"
                          :error="errors['rating_user']"
                          v-model="form['rating_user']">
            </block-review>
        </div>
        <div class="mb20">
            <p class="fz17 lh15 mb10">{{ $t('rv_tx6') }}</p>
            <block-multi-photo :files="[]"
                               :max="10"
                               v-model="form['images']">
            </block-multi-photo>

        </div>
        <div class="mb20">
            <block-input :label="$t('rv_tx1')"
                         :error="errors['review']"
                         :textarea="true"
                         v-model="form['review']">
            </block-input>
        </div>
        <button class="btn" @click="save">{{ $t('rv_tx5') }}</button>
    </div>
</template>

<script>
export default {
    name: "FormReview",
    props: {
        event_id: Number,
    },
    data() {
        return {
            errors: {},
            form: [],
            url_save: route('ratings.store'),
        }
    },
    methods: {
        save() {
            let formData = new FormData();
            for (let i in this.form) {
                if (i == 'images') {
                    for (let j in this.form[i]['images']) {
                        formData.append('images[]', this.form[i]['images'][j]);
                    }
                    formData.append('old_images', JSON.stringify(this.form['images']['old_images']));
                } else {
                    let val = this.form[i];
                    if (val !== null && val !== undefined)
                        formData.append(i, val);
                }
                formData.append('event_id', this.event_id);
            }
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
                });
        }
    }
}
</script>

<style scoped>

</style>
