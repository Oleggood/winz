<i18n>
{
    "ru": {
        "acn_tx1": "Получать уведомления в Telegram",
        "acn_tx2": "Получать уведомления на E-mail",
        "acn_tx3": "О каких событиях отправлять уведомления?",
        "acn_tx4": "Опубликован новый маршрут",
        "acn_tx5": "Добавлено новое событие",
        "acn_tx6": "Кому-то нужна помощь (скоро)",
        "acn_tx7": "ID Телеграм",
        "acn_tx8": "Здесь нужно указать ID вашей учетной записи. Узнать свой ID можно написав одному из ботов. Например, этому:",
        "acn_tx9": "После сохранения данных отправьте сообщение нашему боту (он стесняется писать первым 😊 )",
        "acn_tx10": "E-mail не самый надежный способ доставки уведомлений. Письма могут теряться, попадать в спам, поэтому рекомендуем включить уведомления в Telegram",
        "acn_tx11": "О каких событиях отправлять уведомления?",
        "acn_tx12": "Чтобы получать уведомления о новых маршрутах событиях, укажите, в каких <span class='color-red'>странах</span> вы путешествуете и какой <span class='color-red'>транспорт</span> используете на странице",
        "acn_tx13": "мои данные",
        "acn_tx14": "Личные сообщения"
    },
    "en": {
        "acn_tx1": "Receive notifications in Telegram",
        "acn_tx2": "Receive notifications on E-mail",
        "acn_tx3": "Choose the type of notifications",
        "acn_tx4": "Published new route",
        "acn_tx5": "Published new event",
        "acn_tx6": "Someone needs help (coming soon)",
        "acn_tx7": "Your Telegram ID",
        "acn_tx8": "Here you need to specify your account ID. You can find out your ID by writing to one of the bots. For example, this:",
        "acn_tx9": "After saving the data, send a message to our bot (he is shy to write first 😊 )",
        "acn_tx10": "E-mail is not the most reliable way to deliver notifications. Emails can get lost, get into spam, we recommend enable notifications in Telegram",
        "acn_tx11": "Choose the type of notifications",
        "acn_tx12": "To receive notifications about new routes and events, specify which <span class='color-red'>countries</span> you travel and what <span class='color-red'>transport</span> use on the page",
        "acn_tx13": "my account",
        "acn_tx14": "Private messages"
    }
}

</i18n>
<template>
    <div class="flex flex-wrap">
        <div class="col6 mb20 col12-768">
            <p class="fz16 lh14 mb10">
                <span v-html="$t('acn_tx12')"></span>
                <a class="link link-blue" :href="data_url">{{ $t('acn_tx13') }}</a>
            </p>
            <div class="mb10">
                <block-checkbox :label="$t('acn_tx1')"
                                v-model="localNotification['telegram_enable']">
                </block-checkbox>
            </div>
            <vue-slide-up-down :active="!!localNotification['telegram_enable']" name="slide">
                <div class="mb10">
                    <p class="fz16 lh14 mb10">
                        {{ $t('acn_tx8') }}
                        <a class="link link-blue" target="_blank" href="https://t.me/getmyid_bot">@getmyid_bot</a>
                    </p>
                    <block-input :label="$t('acn_tx7')"
                                 :error="errors['telegram']"
                                 v-model="localNotification['telegram']">
                    </block-input>
                </div>
                <p class="fz16 lh14">
                    {{ $t('acn_tx9') }}
                    <a class="link link-blue" target="_blank" href="https://t.me/tropkaBot">@tropkaBot</a>
                </p>
            </vue-slide-up-down>
            <div>
                <div class="mb10">
                    <block-checkbox :label="$t('acn_tx2')"
                                    v-model="localNotification['email_enable']">
                    </block-checkbox>
                </div>
                <vue-slide-up-down :active="!!localNotification['email_enable']" name="slide">
                    <p class="fz16 lh14">{{ $t('acn_tx10') }}</p>
                </vue-slide-up-down>
            </div>
        </div>
        <div class="col6 mb20 col12-768">
            <p class="mb10 fz17 fw600 lh11 mb10">{{ $t('acn_tx11') }}</p>
            <div class="mb10">
                <block-checkbox :label="$t('acn_tx4')"
                                v-model="localNotification['travel_enable']">
                </block-checkbox>
            </div>
            <div class="mb10">
                <block-checkbox :label="$t('acn_tx5')"
                                v-model="localNotification['event_enable']">
                </block-checkbox>
            </div>
            <div class="mb10 color-gray">
                <block-checkbox :label="$t('acn_tx6')"
                                v-model="localNotification['help_enable']">
                </block-checkbox>
            </div>
            <div>
                <block-checkbox :label="$t('acn_tx14')"
                                v-model="localNotification['message_enable']">
                </block-checkbox>
            </div>
        </div>
        <div class="col12">
            <button @click="save" class="btn">{{ $t('account.acd_tx3') }}</button>
        </div>
    </div>
</template>

<script>
export default {
    name: "FormNotifications",
    props: {
        user_notification: Object
    },
    data() {
        return {
            localNotification: this.user_notification || {},
            errors: {},
            save_url: route('save_notifications'),
            data_url: route('user_data'),
        }
    },
    methods: {
        save() {
            $('.ajax-loader').show();
            let formData = new FormData();
            for (let i in this.localNotification) {
                let val = this.localNotification[i];
                if (val !== null && val !== undefined)
                    formData.append(i, val);
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
        }
    }
}
</script>

<style scoped>

</style>
