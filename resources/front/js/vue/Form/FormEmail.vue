<i18n>
{
    "ru": {
        "send_link": "Отправить ссылку для сброса пароля"
    },
    "en": {
        "send_link": "Send a link to reset your password"
    }
}
</i18n>
<template>
    <div>
        <div class="mb20">
            <block-input :label="$t('auth.input_email')"
                         :error="errors['email']"
                         v-model="form['email']">
            </block-input>
        </div>
        <button type="submit" class="btn btn_med btn_full" @click.prevent="send_link">
            {{ $t('send_link') }}
        </button>
    </div>
</template>

<script>
export default {
    name: "FormEmail",
    data() {
        return {
            errors: {},
            form: {},
            url_send_link: route('password.email')
        }
    },
    methods: {
        send_link(){
            $('.ajax-loader').show();
            let formData = new FormData();
            for (let i in this.form) {
                let val = this.form[i];
                if (val !== null && val !== undefined)
                    formData.append(i, val);
            }
            axios.post(this.url_send_link, formData, {
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
