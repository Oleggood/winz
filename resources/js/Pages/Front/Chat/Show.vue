<template>
    <Head title="Dashboard222"/>

    <FrontAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Чаты пользователей</h2>
        </template>

        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="p-1 text-gray-900 mt-2">
                        <Link :href="route('chats.index')" class="pl-6 text-sky-500 font-semibold">
                            &#60;&#60;&#60; все чаты
                        </Link>

                        <div class="mx-auto pt-3">
                            <div class="flex justify-evenly">
                                <!--левый блок - начало-->
                                <div class="w-1/3 px-4 text-gray-400">
                                    <h3 class="font-semibold pl-3">Участники чата ({{ users.length }}):</h3>
                                    <div v-if="users.length > 0" class="text-sm">
                                        <div v-for="user in users" class="">
                                            <p class="my-3 px-3">
                                                {{ user.lastname }} {{ user.name }} ({{ user.nickname }})
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--левый блок - конец-->

                                <!--правый блок - начало-->
                                <div class="w-2/3">
                                    <div class="">
                                        <h3 class="font-semibold text-sm">{{ chat.title ?? 'чат без заголовка' }}</h3>
                                    </div>
                                    <div v-if="messages.length > 0" class="mb-4">
                                        <div v-if="!isLastPage" class="my-6 text-center">
                                            <a @click.prevent="getMessages" class="px-2 py-1 bg-violet-500 rounded-md text-xs text-white font-semibold hover:bg-violet-700" href="#">&and; загрузить более старые сообщения... &and;</a>
                                        </div>
                                        <div v-for="message in messages.slice().reverse()" class="">
                                            <div
                                                :class="[message.is_owner ? 'text-right' : 'text-left']"
                                                class="pb-2"
                                            >
                                                <p class="text-xs text-gray-500">
                                                    <!-- {{ message.user_name }} {{ message.user_lastname }} -->
                                                    {{ message.user_nickname }} <span class="italic">({{
                                                        message.time
                                                    }})</span>
                                                </p>
                                                <p>
                                                    {{ message.text }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="grow">
                                            <TextInput
                                                id="text"
                                                type="text"
                                                class="block w-full rounded-none border-violet-500 focus:border-violet-500 focus:ring-violet-500"
                                                v-model="text"
                                                autofocus
                                            />
                                        </div>
                                        <div class="grow-0 font-bold">
                                            <a @click.prevent="store"
                                               class="inline-block bg-violet-500 hover:bg-violet-700 hover:shadow-sm text-white border border-violet-500 px-3 py-2"
                                               href="">&#62;</a>
                                        </div>

                                    </div>
                                </div>
                                <!--правый блок - конец-->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </FrontAuthenticatedLayout>
</template>


<script>
import {Head, Link} from '@inertiajs/vue3';
import FrontAuthenticatedLayout from "@/Layouts/FrontAuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import axios from "axios";

export default {
    name: 'Show',

    components: {
        TextInput,
        InputLabel,
        FrontAuthenticatedLayout,
        Head,
        Link
    },
    props: [
        'chat',
        'users',
        'messages',
        'isLastPage',
    ],

    data() {
        return {
            'text': '',
            'page': 1,
        }
    },
    computed: {
        otherUsersIds() {
            return this.users.map(user => {
                return user.id
            }).filter(userId => {
                return userId !== this.$page.props.auth.user.id
            })
        },

    },
    watch: {},
    methods: {
        store() {
            axios.post('/ru/messages',
                {
                    chat_id: this.chat.id,
                    text: this.text,
                    user_ids: this.otherUsersIds,
                })
                .then(res => {
                    this.messages.unshift(res.data);  //убрать, чтобы избавиться от дублирования, но должно работать и с этим!
                    this.text = '';
                })
        },

        getMessages() {
            axios.get(`/ru/chats/${this.chat.id}?page=${++this.page}`)
                .then( res => {
                    this.messages.push(...res.data.messages);
                    this.$page.props.isLastPage = res.data.is_last_page;
                })
        },

    },

    mounted() {
        window.Echo.channel(`store_message.${this.chat.id}`)
            .listen('.store-message', res => {
                this.messages.unshift(res.new_message)
                if (this.$page.url === `/ru/chats/${this.chat.id}`) {
                    axios.patch('/ru/message_statuses', {
                        user_id: this.$page.props.auth.user.id,
                        message_id: res.new_message.id,

                    })
                }
            })
    },
}
</script>
