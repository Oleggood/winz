<template>
    <Head title="Dashboard222"/>

    <FrontAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Чаты пользователей</h2>
        </template>

        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="p-1 text-gray-900">
                        <div class="mx-auto">
                            <div class="flex justify-evenly">
                                <!--левый блок - начало-->
                                <div class="px-4">
                                    <div class="mt-2 flex justify-between items-center">
                                        <h3 v-if="!isGroup" class="font-semibold mr-10">Все контакты:</h3>
                                        <a href="#"
                                           @click.prevent="isGroup = true"
                                           v-if="!isGroup"
                                           class="bg-indigo-200 px-2 py-1 rounded-lg hover:bg-violet-400 text-sm font-semibold"
                                        >Новая группа</a>

                                        <div v-if="isGroup" class="">
                                            <div class="flex justify-between">
                                                <a href="#"
                                                   @click.prevent="storeGroup"
                                                   class="mr-2 bg-green-400 px-2 py-1 rounded-lg hover:bg-green-600 text-sm font-semibold"
                                                >Создать группу</a>
                                                <a href="#"
                                                   @click.prevent="isGroup = false"
                                                   class="bg-red-300 px-2 py-1 rounded-lg hover:bg-red-400 text-sm font-semibold"
                                                >Отмена</a>
                                            </div>
                                            <div class="mt-2">
                                                <p class="text-xs font-semibold text-gray-500">Название чата:</p>
                                                <input type="text" v-model="title"
                                                       class="rounded-lg px-1 py-0.5 w-full">
                                            </div>
                                            <p class="text-xs font-semibold text-gray-500 mt-4">Выберите участников:</p>
                                        </div>
                                        <div class=""></div>
                                    </div>
                                    <div v-if="users.length > 0" class="text-sm">
                                        <div v-for="user in users" class="flex">
                                            <p
                                                @click.prevent="!isGroup ? store(user.id, user.nickname) : toggleUsers(user.id)"
                                                :class="[isGroup && userIds.includes(user.id) ? 'bg-sky-500' : 'bg-sky-200']"
                                                class="mb-1 mt-2 px-3 rounded-lg cursor-pointer hover:bg-violet-300">
                                                {{ user.lastname }} {{ user.name }} ({{ user.nickname }})
                                            </p>

                                        </div>
                                    </div>
                                </div>
                                <!--левый блок - конец-->

                                <!--правый блок - начало-->
                                <div v-show="!isGroup" class="mt-3 px-4">
                                    <h3 class="font-semibold ml-3">Мои чаты:</h3>
                                    <div v-if="chats.length > 0" class="text-sm">
                                        <div v-for="chat in chats" class="my-1 px-3 rounded-md bg-violet-100 hover:bg-violet-300">
                                            <Link :href="route('chats.show', chat.id)">
                                                <div class="flex justify-between items-center">
                                                    <div class="flex my-1.5">
                                                        <div class="px-3 rounded-md">
                                                            {{ chat.title }} -
                                                        </div>
                                                        <div class="italic text-gray-500">{{
                                                                chat.last_message.text.length > 10 ? `${chat.last_message.text.substring(0, 10)}...` : chat.last_message.text
                                                            }}
                                                        </div>
                                                    </div>
                                                    <div class="ml-2 rounded-full bg-gray-300 min-w-6 text-center">
                                                        <span class="text-xs w-full">
                                                            {{ chat.unread_count === 0 ? '' : chat.unread_count }}
                                                        </span>
                                                    </div>
                                                    <div class="italic text-gray-500 text-xs">
                                                        <span>({{ chat.last_message.time }})</span>
                                                    </div>
                                                </div>
                                            </Link>
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
import Checkbox from "@/Components/Checkbox.vue";

export default {
    name: 'Index',

    components: {
        Checkbox,
        FrontAuthenticatedLayout,
        Head,
        Link
    },
    props: [
        'users',
        'chats',
    ],

    data() {
        return {
            isGroup: false,
            userIds: [],
            title: null,
        }
    },
    computed: {},
    watch: {},
    methods: {
        store(id, nickname) {
            // let newTitle = `${nickname} и ${this.$page.props.auth.user.nickname}`;
            // this.$inertia.post('/ru/chats', {title: newTitle, users: [id]})
            this.$inertia.post('/ru/chats', {title: '', users: [id]})
        },

        storeGroup() {
            this.$inertia.post('/ru/chats', {title: this.title, users: this.userIds})
        },

        // типовой метод сбора значений чекбоксов в массив!!!
        toggleUsers(id) {
            let index = this.userIds.indexOf(id)
            if (index === -1) {
                this.userIds.push(id)
            } else {
                this.userIds.splice(index, 1)
            }
        },
    },
    mounted() {
        window.Echo.private(`users.${this.$page.props.auth.user.id}`)
            .listen('.store-message-status', res => {
                this.chats.filter(chat => {
                    if (chat.id === res.chat_id) {
                        chat.unread_count = res.count
                        chat.last_message = res.new_message
                    }
                })
            })
    },
}
</script>
