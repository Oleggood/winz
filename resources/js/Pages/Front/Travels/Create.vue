<template>
    <Head title="Winzi - создать маршрут"/>
    <FrontAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Добавить новый маршрут</h2>
        </template>
        <div class="">
            <!--map-->
            <div class="h-[45rem]">
                <div id="map"></div>
            </div>
            <!--/map-->
            <div class="py-2 w-full">
                <div class="mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 text-sm">
                            <span>
                            Вы можете создать маршрут добавляя точки на карте, либо загрузив трек в формате gpx. После загрузки трека вы можете его отредактировать - подвинуть или добавить точки.
                            </span>
                        </div>
                        <div class="">Кнопка загрузки трека</div>
                        <div class="">Кнопка записи трека</div>
                        <!--form-->
                        <div class="ml-3">
                            <InputLabel class="mt-2" for="new_travel_name" value="Название:"/>
                            <TextInput
                                id="new_travel_name"
                                type="text"
                                class="block"
                                required
                                v-model="formLocalCreate.name"
                            />
                        </div>
                        <!--/form-->
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

export default {
    components: {
        TextInput,
        InputLabel,
        FrontAuthenticatedLayout,
        Head
    },

    name: 'TravelCreate',

    data() {
        return {
            formLocalCreate: {
                'id': '',
                'name': '',
                'region': '',
                'start_point': '',
                'end_point': '',
                'points': '',
                'distance': '',
                'surface': '',
                'difficult': '',
                'escort': '',
                'description1': '',
                'description2': '',
                'availability': '',
                'draft': '',
                'secret': '',
                'notifications_sent': '',
                'status': '',
                'type': '',
            },
        }
    },

    mounted() {
        const script = document.createElement('script');
        script.src = "https://api-maps.yandex.ru/2.1/?lang=ru_RU";
        script.onload = () => {
            ymaps.ready(() => {
                const myMap = new ymaps.Map('map', {
                    center: [55.753994, 37.620094],
                    zoom: 10
                });

                // console.log(myMap);

                this.initDrawingTools(myMap);
            });
        };
        document.head.appendChild(script);

    },

    methods: {
        initDrawingTools(myMap) {
            let drawnCoordinates = []; // Array to store all drawn coordinates

            let drawLineButton = new ymaps.control.Button({
                data: {
                    content: 'Draw Line',
                    title: 'Click to draw a line on the map'
                }
            });

            drawLineButton.events.add('click', () => {
                let polyline = new ymaps.Polyline([], {}, {
                    strokeColor: '#0000ff',
                    strokeWidth: 5,
                    draggable: true
                });
                myMap.geoObjects.add(polyline);


                polyline.editor.startDrawing();
                polyline.editor.events.add('geometrychange', (e) => {
                    let coordinates = polyline.geometry.getCoordinates();

                    drawnCoordinates = coordinates; // Update the array with the latest coordinates
                    // Add any other logic you want to perform with the coordinates here
                    // return drawnCoordinates;
                });
                console.log(drawnCoordinates);
            });

            let drawPolygonButton = new ymaps.control.Button({
                data: {
                    content: 'Draw Polygon',
                    title: 'Click to draw a polygon on the map'
                }
            });

            drawPolygonButton.events.add('click', () => {
                let polygon = new ymaps.Polygon([[]], {}, {
                    fillColor: '#00ff00',
                    strokeColor: '#ff0000',
                    strokeWidth: 5,
                    draggable: true
                });

                myMap.geoObjects.add(polygon);

                polygon.editor.startDrawing();

                polygon.editor.events.add('geometrychange', (e) => {
                    let coordinates = polygon.geometry.getCoordinates()[0];
                    console.log(coordinates);
                    drawnCoordinates = coordinates; // Update the array with the latest coordinates
                    // Add any other logic you want to perform with the coordinates here
                });
            });

            myMap.controls.add(drawLineButton, { float: 'left' });
            myMap.controls.add(drawPolygonButton, { float: 'left' });
        }

    },
}

</script>


<style scoped>
html, body {
//margin: 0; //padding: 0; //height: 100%; //width: 100%;
}

#map {
    height: 100%;
}
</style>
