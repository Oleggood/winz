<template>
    <div class="hp-b01 flex1 flex-v-center">
        555
        <div class="min-h-screen bg-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <Link :href="route('home')">
                                <ApplicationLogo
                                    class="block h-9 w-auto fill-current text-gray-800"
                                />
                            </Link>
                        </div>

                    </div>

                </div>

                333
            </div>


            <!-- Page Content -->
            <main>
                444
            </main>
        </div>
    </div>


    <!--    <div class="bg-gray-100">-->
    <!--        <div class="container">-->
    <!--            <div class="flex justify-between h-16">-->
    <!--                <div class="flex">-->
    <!--                    <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800">-->
    <!--                    </ApplicationLogo>-->
    <!--                </div>-->
    <!--                <p>111</p>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
</template>

<script>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import {Link} from "@inertiajs/vue3";

export default {
    components: {
        ApplicationLogo,
        Link,
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
