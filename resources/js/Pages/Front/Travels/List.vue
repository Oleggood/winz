<template>
    <Head title="Winzi - маршруты"/>
    <FrontAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">travels Index - User</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">Это разметка ПОЬЗОВАТЕЛЕЙ с авторизацией </div>
                </div>
            </div>
        </div>


    </FrontAuthenticatedLayout>
</template>

<script>
import {Head} from '@inertiajs/vue3';
import FrontAuthenticatedLayout from "@/Layouts/FrontAuthenticatedLayout.vue";

export default {
    components: {
        FrontAuthenticatedLayout,
        Head
    },

    name: 'TravelIndex',

    mounted() {

    }
}
</script>
