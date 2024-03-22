<i18n>
{
    "ru": {
        "login": "Вход"
    },
    "en": {
        "login": "Login"
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
        <button type="submit" class="btn btn_med btn_full" @click.prevent="login">
            {{ $t('login') }}
        </button>
    </div>
</template>

<script>
export default {
    name: "FormLogin",
    data() {
        return {
            errors: {},
            form: {},
            url_register: route('login')
        }
    },
    methods: {
        login(){
            $('.ajax-loader').show();
            let formData = new FormData();
            for (let i in this.form) {
                let val = this.form[i];
                if (val !== null && val !== undefined)
                    formData.append(i, val);
            }
            axios.post(this.url_register, formData, {
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
