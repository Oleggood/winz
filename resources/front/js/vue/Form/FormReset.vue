<i18n>
{
    "ru": {
        "reset": "Сбросить пароль"
    },
    "en": {
        "reset": "Reset password"
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
        <div class="mb20">
            <block-input :label="$t('auth.input_password')"
                         :error="errors['password']"
                         :type="'password'"
                         v-model="form['password']">
            </block-input>
        </div>
        <button type="submit" class="btn btn_med btn_full" @click.prevent="update">
            {{ $t('reset') }}
        </button>
    </div>
</template>

<script>
export default {
    name: "FormReset",
    props:{
        token: String
    },
    data() {
        let url_params = (new URLSearchParams(window.location.search));
        let form = {};
        form['email'] = url_params.get('email') || '';
        return {
            errors: {},
            form: form,
            url_update: route('password.update'),
        }
    },
    mounted() {


    },
    methods: {
        update(){
            $('.ajax-loader').show();
            let formData = new FormData();
            for (let i in this.form) {
                let val = this.form[i];
                if (val !== null && val !== undefined)
                    formData.append(i, val);
                formData.append('token', this.token);
            }
            axios.post(this.url_update, formData, {
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
