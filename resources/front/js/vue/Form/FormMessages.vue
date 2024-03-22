<i18n>
{
    "ru": {
        "acc_tx10": "Собеседники",
        "acc_tx11": "Выберите собеседника",
        "ms_tx1": "Чат с пользователем",
        "ms_tx2": "Сообщение",
        "ms_tx3": "Отправить",
        "ms_tx5": "Нет сообщений"
    },
    "en": {
        "acc_tx10": "Contacts",
        "acc_tx11": "Select a contact",
        "ms_tx1": "Chat with user",
        "ms_tx2": "Message",
        "ms_tx3": "Send",
        "ms_tx5": "No messages"
    }
}
</i18n>
<template>
    <div>
        <div class="flex flex-wrap-550">
            <div class="col9 col12-550 mb10">
                <div class="card-border">
                    <div class="message" v-if="interlocutor_id">
                        <p class="fz17 lh15 mb10 fw600 flex1 flex-v-center flex-wrap-550">
                            <span class="mr5">{{ $t('ms_tx1') }}</span>
                            <a class="link link-blue flex1 flex-v-center mr5" :href="interlocutor['href']">
                                <span>{{ interlocutor['showname'] }}</span>
                                <svg width="1rem" height="1rem" v-if="interlocutor['id'] == admin_chat ">
                                    <use xlink:href="#ico-check"></use>
                                </svg>
                            </a>
                            <span class="color-green fz12" v-if="interlocutor['is_online']">online</span>
                            <span class="color-gray fz12" v-else>online: {{ interlocutor['was_online'] }}</span>
                        </p>
                        <div class="messages mb20">
                            <div v-if="this.messages.length">
                                <div v-for="message in this.messages">
                                    <div class="messages__item mb10"
                                         :class="[message['is_my'] ? 'messages__item_my' : '']">
                                        <p class="color-blue fz16 fw600 mb10" target="_blank" v-if="!message['is_my']">
                                            {{
                                                message['user']['showname']
                                            }}</p>
                                        <p class="fz16 mb5">{{ message['text'] }}</p>
                                        <p class="color-gray fz12">{{ message['created_formatted'] }}</p>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <p class="fz16 color-gray p17">{{ $t('ms_tx5') }}</p>
                            </div>
                        </div>
                        <div class="messages__form">
                            <div class="mb20">
                                <block-input :label="$t('ms_tx2')"
                                             :textarea="true"
                                             v-model="text"
                                             v-on:pressedEnter="sendMessage"
                                ></block-input>
                            </div>
                            <button @click="sendMessage" class="btn">{{ $t('ms_tx3') }}</button>
                        </div>
                    </div>
                    <div v-else>
                        <p class="fz20 fw500">{{ $t('acc_tx11') }}</p>
                    </div>
                </div>
            </div>
            <div class="col3 col12-550 mb10">
                <div class="card-border">
                    <p class="fz20 fw500 mb30">{{ $t('acc_tx10') }}</p>
                    <ul class="fz17 lh15">
                        <li class="link mb5" :class="{'color-blue': interlocutor['id'] == interlocutor_id}" v-for="interlocutor in user_list" v-html="interlocutor['name']"
                            @click="interlocutor_id = interlocutor['id']">
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: "FormMessages",
    props: {
        user_list: Array,
        admin_chat: Number,
    },
    mounted() {
        this.updateInterlocutor();
    },
    data() {
        let url_params = (new URLSearchParams(window.location.search));
        let temp_interlocutor_id = url_params.get('interlocutor_id') || '';
        if (getIDs(this.user_list).indexOf(temp_interlocutor_id) === -1)
            temp_interlocutor_id = '';
        return {
            messages: {},
            interlocutor_id: temp_interlocutor_id,
            interlocutor: {},
            text: url_params.get('text') || '',
            url_get_messages: route('private_messages'),
            url_send_message: route('messages.store'),
            url_current: route('account_chats')
        }
    },
    methods: {
        sendMessage() {
            let temp = this.text;
            this.text = '';
            axios.post(this.url_send_message, {
                target_id: this.interlocutor_id,
                text: temp,
                target_type: 2,
            }).then((response) => {
                this.refreshMessages(response.data);
            })
        },
        refreshMessages(data) {
            this.messages = data;
            if (Object.keys(this.messages).length)
                setTimeout(function () {
                    let objDiv = document.getElementsByClassName("messages")[0];
                    objDiv.scrollTop = objDiv.scrollHeight;
                }, 50)
        },
        updateInterlocutor() {
            if (this.interlocutor_id) {
                axios.get(this.url_get_messages + `?interlocutor_id=${this.interlocutor_id}`)
                    .then((response) => {
                        if (response.data.interlocutor) {
                            this.refreshMessages(response.data.messages);
                            this.interlocutor = response.data.interlocutor
                            this.user_list = response.data.user_list
                        } else {
                            this.interlocutor_id = '';
                        }
                        window.getQueryString(this.url_current, {'interlocutor_id': this.interlocutor_id});
                    });
            }
        }
    },
    watch: {
        interlocutor_id: function () {
            this.updateInterlocutor();
        },
    }
}
</script>

<style scoped>

</style>
