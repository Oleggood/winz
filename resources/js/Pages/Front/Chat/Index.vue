<template>
    <Head title="Dashboard222" />

    <FrontAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">travels - User</h2>
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
    props: {},
    data() {
        return {}
    },
    computed: {},
    watch: {},
    methods: {},
    mounted() {

    }
}
</script>
