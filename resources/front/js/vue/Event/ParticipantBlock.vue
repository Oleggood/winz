<template>
    <div v-if="event['before_start']['invert']">
        <div class="card-border mb16">
            <div v-if="!author" class="fz17">
                <p class="mb20">
                    {{ $t('participant.prt_tx38') }}: {{
                        parseInt(participants_drivers) + parseInt(participants_passengers)
                    }}
                    ({{ $t('participant.prt_tx40') }}
                    {{
                        (parseInt(event['max_participant'])) + parseInt(total_passenger_places)
                    }} {{ $t('participant.prt_tx40_1') }})
                </p>
                <p class="mb20" v-if="event['passenger']">
                    {{ $t('participant.prt_tx39') }}: {{ participants_passengers }}
                    ({{ $t('participant.prt_tx40') }}
                    {{ total_passenger_places }} {{ $t('participant.prt_tx40_1') }})
                </p>
                <p class="mb20" v-if="event['passenger']">
                    {{ $t('participant.prt_tx41') }}: {{ participants_drivers }} ({{
                        $t('participant.prt_tx40')
                    }}
                    {{ parseInt(event['max_participant']) }}
                    {{ $t('participant.prt_tx40_1') }})
                </p>
            </div>
            <div v-if="participant['confirmed']" class="mb20">

                <p v-if="participant['confirmed'] == 9" class="fz17 lh15 mb10 fw600 color-red">
                    {{ $t('participant.prt_tx20') }}</p>
                <p v-if="participant['confirmed'] == 10" class="fz17 lh15 mb10 fw600 color-red">
                    {{ $t('participant.prt_tx21') }}</p>
                <p v-if="participant['confirmed'] == 1" class="fz17 lh15 mb10 fw600 color-blue">
                    {{ $t('participant.prt_tx13_1') }} ({{
                        getNameById(participant['role'], $t('participant.prt_tx3'))
                    }})
                </p>
                <p v-if="participant['confirmed'] == 2" class="fz17 lh15 mb10 fw600 color-blue">
                    {{ $t('participant.prt_tx14') }}</p>
                <p v-if="participant['confirmed'] == 3" class="fz17 lh15 mb10 fw600 color-blue">
                    {{ $t('participant.prt_tx13') }}
                    ({{ getNameById(participant['role'], $t('participant.prt_tx3')) }})</p>
                <div v-if="event['before_start']['invert']">
                    <div class="mb10" v-if="participant['confirmed'] == 2 || participant['confirmed'] == 3">
                        <div class="mb10">
                            <a href="#" class="btn btn_red" @click.prevent="cancel">{{ $t('participant.prt_tx19') }}</a>
                        </div>
                        <div class="form-wrap">
                            <p class="fz14 lh15 mb10">{{ $t('participant.prt_tx18') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="mb20" ref="formParticipate">
                <div v-if="!author" class="mb10">
                    <a class="btn" href="#" @click.prevent="form_visible = !form_visible">{{
                            $t('participant.prt_tx1_1')
                        }}</a>
                </div>
                <vue-slide-up-down :active="(form_visible || author)" name="slide">
                    <div>
                        <p v-if="author" class="fz17 lh15 fw700 warning-notification">{{ $t('participant.prt_tx5_1') }}</p>
                        <p v-if="author" class="fz17 lh15 fw700 color-error">{{ $t('participant.prt_tx5_1') }}</p>
                        <p v-else class="fz17 lh15">{{ $t('participant.prt_tx5') }}</p>
                        <p class="fz17 mb10 fw600 lh15 color-red">{{ event['start_formatted'] }}
                            ({{ $t('event.prt_tx6') }}
                            {{ event['before_start']['days'] }}
                            {{ $t('event.prt_tx6_1') }}
                            {{ event['before_start']['h'] }} {{ $t('event.prt_tx6_2') }})
                        </p>
                        <div class="mb20">
                            <block-select :label="$t('participant.prt_tx1')"
                                          :values="$t('participant.prt_tx3')"
                                          :error="errors['role']"
                                          v-model="participant['role']">
                            </block-select>
                        </div>
                        <div v-if="event['passenger'] && participant['role'] == 1" class="mb20">
                            <p class="fz14 lh15 mb10">{{ $t('participant.prt_tx10') }}
                                <span v-if="event['max_team']">
                                    <br>({{ $t('participant.prt_tx45') }} {{ event['max_team'] }}
                                    {{ $t('participant.prt_tx46') }})
                                </span>
                            </p>
                            <block-input :label="$t('participant.prt_tx9')"
                                         :error="errors['passengers']"
                                         :input_class="'input-mask-3'"
                                         v-model="participant['passengers']">
                            </block-input>
                        </div>
                        <div class="mb20">
                            <block-input :label="$t('participant.prt_tx4')"
                                         :textarea="true"
                                         :error="errors['description']"
                                         :input_class="'input-mask-3'"
                                         v-model="participant['description']">
                            </block-input>
                        </div>
                        <p v-if="event['payment']" class="fz14 lh15 mb20">{{ $t('participant.prt_tx8') }}</p>
                        <button class="btn" @click.prevent="submit">{{ $t('participant.prt_tx2') }}</button>
                    </div>
                </vue-slide-up-down>
            </div>

            <div class="mb20" v-if="Object.keys(this.participants).length">
                <p class="fz17 lh15 mb10 fw600 color-blue">{{ $t('participant.prt_tx25') }}</p>
                <table class="fz17 table">
                    <tr>
                        <th class="hide-550">{{ $t('participant.prt_tx22') }}</th>
                        <th>{{ $t('participant.prt_tx23') }}</th>
                        <th class="hide-550">{{ $t('participant.prt_tx24') }}</th>

                        <th class="hide-550" v-if="event['passenger']">{{ $t('participant.prt_tx37') }}</th>

                        <th>{{ $t('participant.prt_tx35') }}</th>
                        <th>{{ $t('participant.prt_tx26') }}</th>
                    </tr>
                    <tr v-for="participant in participants">
                        <td class="hide-550">{{ participant['created_formatted'] }}</td>
                        <td>
                            <a class="link link-blue" :href="participant['user']['href']" target="_blank">
                                {{ participant['user']['showname'] }}
                                <span class="ico-online" v-if="participant['user']['is_online']"></span>
                            </a>
                        </td>
                        <td class="hide-550">{{ participant['description'] }}</td>
                        <td class="hide-550" v-if="event['passenger']">{{ participant['passengers'] }}</td>
                        <td>{{ getNameById(participant['role'], $t('participant.prt_tx3')) }}</td>
                        <td>
                            <div class="flex flex-v-center flex_5">
                                <div class="col0 col_5">
                                    {{ getNameById(participant['confirmed'], $t('participant.prt_sts19')) }}
                                </div>
                                <div v-if="participant['confirmed'] == 2" class="col0 col_5">

                                    <button @click.prevent="participantConfirm(participant['id'])"
                                            class="btn btn_small tooltip-bottom"
                                            :data-title="$t('participant.prt_tx29')">
                                        <svg height=".7rem" viewBox="0 -46 417.81333 417" width=".7rem"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="m159.988281 318.582031c-3.988281 4.011719-9.429687 6.25-15.082031 6.25s-11.09375-2.238281-15.082031-6.25l-120.449219-120.46875c-12.5-12.5-12.5-32.769531 0-45.246093l15.082031-15.085938c12.503907-12.5 32.75-12.5 45.25 0l75.199219 75.203125 203.199219-203.203125c12.503906-12.5 32.769531-12.5 45.25 0l15.082031 15.085938c12.5 12.5 12.5 32.765624 0 45.246093zm0 0"/>
                                        </svg>
                                    </button>

                                </div>
                                <div class="col0 col_5" v-if="participant['confirmed'] == 2">
                                    <a href="#" class="btn btn_red btn_small tooltip-bottom"
                                       :data-title="$t('event.prt_tx30')"
                                       @click.prevent="participantReject(participant['id'])">
                                        <svg height=".7rem" viewBox="0 0 365.696 365.696" width=".7rem"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="m243.1875 182.859375 113.132812-113.132813c12.5-12.5 12.5-32.765624 0-45.246093l-15.082031-15.082031c-12.503906-12.503907-32.769531-12.503907-45.25 0l-113.128906 113.128906-113.132813-113.152344c-12.5-12.5-32.765624-12.5-45.246093 0l-15.105469 15.082031c-12.5 12.503907-12.5 32.769531 0 45.25l113.152344 113.152344-113.128906 113.128906c-12.503907 12.503907-12.503907 32.769531 0 45.25l15.082031 15.082031c12.5 12.5 32.765625 12.5 45.246093 0l113.132813-113.132812 113.128906 113.132812c12.503907 12.5 32.769531 12.5 45.25 0l15.082031-15.082031c12.5-12.503906 12.5-32.769531 0-45.25zm0 0"/>
                                        </svg>
                                    </a>
                                </div>

                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            {{ $t('participant.prt_tx38') }}: {{
                                parseInt(participants_drivers) + parseInt(participants_passengers)
                            }}
                            ({{ $t('participant.prt_tx40') }}
                            {{
                                (parseInt(event['max_participant'])) + parseInt(total_passenger_places)
                            }} {{ $t('participant.prt_tx40_1') }})
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" v-if="event['passenger']">
                            {{ $t('participant.prt_tx39') }}: {{ participants_passengers }}
                            ({{ $t('participant.prt_tx40') }}
                            {{ total_passenger_places }} {{ $t('participant.prt_tx40_1') }})
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" v-if="event['passenger']">
                            {{ $t('participant.prt_tx41') }}: {{ participants_drivers }} ({{
                                $t('participant.prt_tx40')
                            }}
                            {{ parseInt(event['max_participant']) }}
                            {{ $t('participant.prt_tx40_1') }})
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="flex flex-wrap-768" v-if="participant['confirmed'] == 1 || participant['confirmed'] == 3">
            <div class="col6 col12-768 mb20">
                <div class="card-border">
                    <div class="message">
                        <p class="fz17 lh15 mb10 fw600 color-blue">{{ $t('participant.ms_tx1') }}</p>
                        <div class="messages mb20">
                            <div v-if="this.messages.length">
                                <div v-for="message in this.messages">
                                    <div class="messages__item mb10"
                                         :class="[message['is_my'] ? 'messages__item_my' : '']">
                                        <a class="link link-blue fz16 fw600 mb10" :href="message['user']['href']"
                                           target="_blank" v-if="!message['is_my']">{{
                                                message['user']['showname']
                                            }}</a>
                                        <p class="fz16 mb5">{{ message['text'] }}</p>
                                        <p class="color-gray fz12">{{ message['created_formatted'] }}</p>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <p class="fz16 color-gray">{{ $t('participant.ms_tx5') }}</p>
                            </div>
                        </div>
                        <div class="messages__form">
                            <div class="mb20">
                                <block-input :label="$t('participant.ms_tx2')"
                                             :textarea="true"
                                             v-model="text"
                                             v-on:pressedEnter="sendMessage"
                                ></block-input>
                            </div>
                            <button @click="sendMessage" class="btn">{{ $t('participant.ms_tx3') }}</button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col6 col12-768 mb20">
                <div class="card-border participant-block">
                    <div>
                        <p class="fz17 lh15 mb10 fw600 color-blue">{{ $t('participant.prt_tx47') }}</p>
                        <p class="fz17 mb10">{{ $t('participant.prt_tx47_1') }}</p>
                        <div class="mb20">
                            <div class="mb5 flex1" v-for="gathering in gatheringsLocal">
                                <label class="st-checkbox flex-full mr10"
                                       @change="setGatheringDone(gathering)">
                                    <input v-model="gathering['done']" type="checkbox"
                                           :disabled="gathering['user_id'] && gathering['user_id'] != participant['user_id']">
                                    <span class="st-checkbox__dot"></span>
                                    <span class="fz17">
                                        {{ gathering['text'] }}
                                        <span v-if="gathering['author']" class="color-gray">
                                            ({{ gathering['author']['showname'] }})
                                        </span>
                                    </span>
                                </label>
                                <button v-if="author" class="btn btn_red btn_small btn_small_svg" @click="removeGathering(gathering)">
                                    &times;
                                </button>
                            </div>
                        </div>
                        <div v-if="author" class="flex1 flex-v-start">
                            <div class="mr10 flex-full">
                                <block-input :label="$t('participant.prt_tx48')"
                                             :error="errorGathering['text']"
                                             v-model="tempGathering">
                                </block-input>
                            </div>
                            <button class="btn btn_full_svg" @click="addGathering">
                                <svg width="1rem" height="1rem">
                                    <use xlink:href="#ico-plus"></use>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else>
        <div class="flex">
            <div class="col6 col12-768 mb20" v-if="this.messages.length">
                <div class="message card-border">
                    <p class="fz17 lh15 mb10 fw600 color-blue">{{ $t('participant.ms_tx1') }}</p>
                    <div class="messages">
                        <div v-for="message in this.messages">
                            <div class="messages__item mb10"
                                 :class="[message['is_my'] ? 'messages__item_my' : '']">
                                <a class="link link-blue fz16 fw600 mb10" :href="message['user']['href']"
                                   target="_blank" v-if="!message['is_my']">{{
                                        message['user']['showname']
                                    }}</a>
                                <p class="fz16 mb5">{{ message['text'] }}</p>
                                <p class="color-gray fz12">{{ message['created_formatted'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col6 col12-768 mb20" v-if="this.gatheringsLocal.length">
                <div class="card-border">
                    <p class="fz17 lh15 mb10 fw600 color-blue">{{ $t('participant.prt_tx47') }}</p>
                    <div class="mb5 flex1" v-for="gathering in gatheringsLocal">
                        <p class="flex-full mr10">
                            <span class="fz17">
                                {{ gathering['text'] }}
                                <span v-if="gathering['author']" class="color-gray">
                                    ({{ gathering['author']['showname'] }})
                                </span>
                            </span>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
export default {
    name: "ParticipantBlock",
    props: {
        event: {}
    },
    data() {
        return {
            participant: {},
            participants: {},
            author: false,
            form_visible: false,
            participants_passengers: 0,
            participants_drivers: 0,
            total_passenger_places: 0,
            url_confirm: route('participants.confirm'),
            url_reject: route('participants.reject'),
            url_get_list: route('participants.get_list'),
            url_cancel: route('participants.cancel'),
            url_get_form: route('participants.get_form'),
            url_submit: route('participants.store'),
            url_list_gathering: route('gatherings.list'),
            url_add_gathering: route('gatherings.store'),
            url_destroy_gathering: route('gatherings.destroy'),
            url_take_gathering: route('gatherings.take'),
            url_untake_gathering: route('gatherings.untake'),
            errors: {},
            text: '',
            messages: {},
            url_send_message: route('messages.store'),
            url_get_messages: route('messages.index'),
            gatheringsLocal: this.event['gatherings'],
            tempGathering: '',
            errorGathering: [],
        }
    },
    mounted() {
        this.refreshBlocks();
        this.listGatherings();
    },
    methods: {
        refreshBlocks() {
            this.getForm();
            this.getParticipants();
            this.getMessages();
        },
        getForm() {
            axios.get(this.url_get_form + `?event_id=` + this.event['id'])
                .then((response) => {
                    let res = response.data;
                    if (res.participant)
                        this.participant = res.participant;
                    if (res.author)
                        this.author = res.author;
                });
        },
        cancel() {
            Swal.fire({
                html: this.$t('participant.prt_tx15'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e55353',
                cancelButtonColor: '#ddd',
                confirmButtonText: this.$t('participant.prt_tx19'),
                cancelButtonText: this.$t('text.cancel')
            }).then((result) => {
                if (result.isConfirmed) {
                    $('.ajax-loader').show();
                    let formData = new FormData;
                    formData.append('event_id', this.event['id']);
                    axios.post(this.url_cancel, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                        .then((response) => {
                            $('.ajax-loader').hide();
                            window.formSendResponce(response.data);
                            this.refreshBlocks();
                        })
                        .catch((err) => {
                            $('.ajax-loader').hide();
                            window.showRequestErrors(err.response);
                        });
                }
            })
        },
        submit() {
            $('.ajax-loader').show();
            let formData = new FormData;
            formData.append('event_id', this.event['id']);
            for (let i in this.participant) {
                let val = this.participant[i];
                if (val !== null && val !== undefined)
                    formData.append(i, val);
            }
            axios.post(this.url_submit, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then((response) => {
                    $('.ajax-loader').hide();
                    window.formSendResponce(response.data);
                    this.refreshBlocks();
                })
                .catch((err) => {
                    $('.ajax-loader').hide();
                    this.errors = err.response.data.errors;
                    window.showRequestErrors(err.response);
                });
        },
        getParticipants() {
            axios.get(this.url_get_list + `?event_id=` + this.event['id'])
                .then((response) => {
                    let res = response.data;
                    if (res.participants)
                        this.participants = res.participants;
                    if (res.participants_passengers)
                        this.participants_passengers = res.participants_passengers;
                    if (res.participants_drivers)
                        this.participants_drivers = res.participants_drivers;
                    if (res.total_passenger_places)
                        this.total_passenger_places = res.total_passenger_places;
                });
        },
        participantConfirm(id) {
            $('.ajax-loader').show();
            let formData = new FormData;
            formData.append('event_id', this.event['id']);
            formData.append('id', id);
            axios.post(this.url_confirm, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then((response) => {
                    $('.ajax-loader').hide();
                    window.formSendResponce(response.data);
                    this.refreshBlocks();
                })
                .catch((err) => {
                    $('.ajax-loader').hide();
                });
        },
        participantReject(id) {
            Swal.fire({
                html: this.$t('participant.prt_tx27'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e55353',
                cancelButtonColor: '#ddd',
                confirmButtonText: this.$t('participant.prt_tx28'),
                cancelButtonText: this.$t('text.cancel')
            }).then((result) => {
                if (result.isConfirmed) {
                    $('.ajax-loader').show();
                    let formData = new FormData;
                    formData.append('event_id', this.event['id']);
                    formData.append('id', id);
                    axios.post(this.url_reject, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                        .then((response) => {
                            $('.ajax-loader').hide();
                            window.formSendResponce(response.data);
                            this.refreshBlocks();
                        })
                        .catch((err) => {
                            $('.ajax-loader').hide();
                            window.showRequestErrors(err.response);
                        });
                }
            })
        },
        sendMessage() {
            let temp = this.text;
            this.text = '';
            axios.post(this.url_send_message, {
                target_id: this.event['id'],
                text: temp,
                target_type: 1,
            }).then((response) => {
                this.refreshMessages(response.data);
            })
        },
        getMessages() {
            axios.get(this.url_get_messages + `?event_id=${this.event['id']}`)
                .then((response) => {
                    this.refreshMessages(response.data);
                });
        },
        refreshMessages(data) {
            this.messages = data;
            if (Object.keys(this.messages).length)
                setTimeout(function () {
                    let objDiv = document.getElementsByClassName("messages")[0];
                    if (objDiv)
                        objDiv.scrollTop = objDiv.scrollHeight;
                }, 50)

        },
        listGatherings() {
            axios.get(this.url_list_gathering + `?event_id=${this.event['id']}`).then((response) => {
                this.gatheringsLocal = response.data.data;
            })
        },
        removeGathering(gathering) {
            $('.ajax-loader').show();
            axios.post(this.url_destroy_gathering, {
                gathering_id: gathering['id'],
            }).then((response) => {
                $('.ajax-loader').hide();
                this.gatheringsLocal = response.data.data;
            })
                .catch((err) => {
                    $('.ajax-loader').hide();
                    this.errorGathering = err.response.data.errors;
                    window.showRequestErrors(err.response);
                });
        },
        addGathering() {
            let temp = this.tempGathering;
            this.tempGathering = '';
            $('.ajax-loader').show()
            axios.post(this.url_add_gathering, {
                event_id: this.event['id'],
                text: temp,
            }).then((response) => {
                $('.ajax-loader').hide();
                this.gatheringsLocal = response.data.data;
            })
                .catch((err) => {
                    $('.ajax-loader').hide();
                    this.errorGathering = err.response.data.errors;
                    window.showRequestErrors(err.response);
                });

        },
        setGatheringDone(gathering) {
            $('.ajax-loader').show();
            let url = this.url_take_gathering;
            if (!gathering['done'])
                url = this.url_untake_gathering
            axios.post(url, {
                gathering_id: gathering['id'],
            }).then((response) => {
                $('.ajax-loader').hide();
                this.gatheringsLocal = response.data.data;
            })
                .catch((err) => {
                    $('.ajax-loader').hide();
                    this.errorGathering = err.response.data.errors;
                    window.showRequestErrors(err.response);
                });
        },
        getNameById(id, scope) {
            return window.getNameById(id, scope);
        }
    },
    watch: {
        form_visible: function () {
            if (this.form_visible)
                this.$refs['formParticipate'].scrollIntoView({
                    behavior: 'smooth'
                });
        }
    }
}
</script>

<style scoped>

</style>
