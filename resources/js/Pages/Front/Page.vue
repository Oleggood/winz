<template>
    <Head title="Dashboard222"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Маршруты</h2>
        </template>

    <!--контент внутри этого div:-->
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">---Маршруты</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';

export default {
    components: {
        AuthenticatedLayout,
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
