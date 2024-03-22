<i18n>
{
    "ru": {
        "agree": "Регистрируясь, я соглашаюсь с <a class='link link-blue fw600' target='_blank' href='/ru/info/policy'>политикой обработки персональных данных</a> и с <a class='link link-blue fw600' target='_blank' href='/ru/info/terms'>условиями использования ресурса</a>",
        "register": "Зарегистрироваться"
    },
    "en": {
        "agree": "By continuing, you accept our <a class='link link-blue fw600' target='_blank' href='/en/info/policy'>Privacy Policy</a> and <a class='link link-blue fw600' target='_blank' href='/en/info/terms'>Terms & Conditions</a>",
        "register": "Sign up"
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
            <block-input :label="$t('auth.input_phone')"
                         :error="errors['phone']"
                         :input_phone="true"
                         v-model="form['phone']">
            </block-input>
        </div>
        <div class="mb20">
            <block-input :label="$t('auth.input_password')"
                         :error="errors['password']"
                         :type="'password'"
                         v-model="form['password']">
            </block-input>
        </div>
        <div class="mb20">
            <block-checkbox :label="$t('agree')"
                            :error="errors['agree']"
                            v-model="form['agree']">
            </block-checkbox>
        </div>
        <button type="submit" class="btn btn_med btn_full" @click.prevent="register">
            {{ $t('register') }}
        </button>
    </div>
</template>

<script>
export default {
    name: "FormRegister",
    data() {
        return {
            errors: {},
            form: {
                'name': '',
                'phone': '',
                'password': '',
                'agree': false
            },
            url_register: route('register')
        }
    },
    methods: {
        register() {
            $('.ajax-loader').show();
            let formData = new FormData();
            for (let i in this.form) {
                let val = this.form[i];
                if (val !== null && val !== undefined)
                    formData.append(i, val);
            }
            console.log(formData)
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
