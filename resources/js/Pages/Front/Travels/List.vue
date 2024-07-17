<template>
    <Head title="Dashboard222" />

    <BackAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">travels - Admin</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">Это разметка АДМИНКИ с авторизацией </div>
                </div>
            </div>
        </div>
    </BackAuthenticatedLayout>
</template>


<script>
import BackAuthenticatedLayout from '@/Layouts/BackAuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';

export default {
    components: {
        BackAuthenticatedLayout,
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
