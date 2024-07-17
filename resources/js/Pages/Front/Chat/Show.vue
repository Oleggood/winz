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
                        <Link :href="route('chats.index')" class="pl-6 text-sky-500 font-semibold">
                            Чаты
                        </Link>
                        <div class="mx-auto">
                            <div class="flex justify-evenly">
                                <!--левый блок - начало-->
                                <div class="px-4">
                                    <h3 class="font-semibold">Пользователи:</h3>
                                    <div v-if="users.length > 0" class="text-sm">
                                        <div v-for="user in users" class="">
                                            <p @click.prevent="store(user.id)" class="my-3 px-3 bg-sky-200 rounded-full cursor-pointer hover:bg-violet-300">
                                                {{ user.id }} {{ user.lastname }} {{ user.name }} {{ user.nickname }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--левый блок - конец-->

                                <!--правый блок - начало-->
                                <div class="px-4">
                                    222
                                </div>
                                <!--правый блок - конец-->
                            </div>
                        </div>
                        <br>
                        сделать лайаут-ссылки (видос 4, середина)????
                        <br>



                    </div>
                </div>
            </div>
        </div>
    </FrontAuthenticatedLayout>
</template>


<script>
import {Head, Link} from '@inertiajs/vue3';
import FrontAuthenticatedLayout from "@/Layouts/FrontAuthenticatedLayout.vue";

export default {
    components: {
        FrontAuthenticatedLayout,
        Head,
        Link
    },
    props: [
        'users',
    ],

    data() {
        return {}
    },
    computed: {},
    watch: {},
    methods: {
        store(id) {
            this.$inertia.post('/ru/chats', {title: null, users: [id]})
        },
    },
    mounted() {

    }
}
</script>
