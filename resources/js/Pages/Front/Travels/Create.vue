<template>
    <Head title="Dashboard222"/>
    <FrontAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">travels - User</h2>
        </template>
        <div class="h-[45rem]">
            <div id="map"></div>
        </div>
    </FrontAuthenticatedLayout>
</template>

<script>
import {Head} from '@inertiajs/vue3';
import FrontAuthenticatedLayout from "@/Layouts/FrontAuthenticatedLayout.vue";

// Define function outside export block
function initDrawingTools(myMap) {
    var drawLineButton = new ymaps.control.Button({
        data: {
            content: 'Draw Line',
            title: 'Click to draw a line on the map'
        }
    });

    drawLineButton.events.add('click', function () {
        var polyline = new ymaps.Polyline([], {}, {
            strokeColor: '#0000ff',
            strokeWidth: 5,
            draggable: true
        });

        myMap.geoObjects.add(polyline);

        polyline.editor.startDrawing();
    });

    var drawPolygonButton = new ymaps.control.Button({
        data: {
            content: 'Draw Polygon',
            title: 'Click to draw a polygon on the map'
        }
    });

    drawPolygonButton.events.add('click', function () {
        var polygon = new ymaps.Polygon([[]], {}, {
            fillColor: '#00ff00',
            strokeColor: '#ff0000',
            strokeWidth: 5,
            draggable: true
        });

        myMap.geoObjects.add(polygon);

        polygon.editor.startDrawing();
    });

    myMap.controls.add(drawLineButton, {float: 'left'});
    myMap.controls.add(drawPolygonButton, {float: 'left'});
}

export default {
    components: {
        FrontAuthenticatedLayout,
        Head
    },
    mounted() {
        const script = document.createElement('script');
        script.src = "https://api-maps.yandex.ru/2.1/?lang=en_US";
        script.onload = () => {
            ymaps.ready(() => {
                const myMap = new ymaps.Map('map', {
                    center: [55.753994, 37.620094],
                    zoom: 10
                });

                initDrawingTools(myMap);
            });
        };
        document.head.appendChild(script);
    }
}
</script>

<style>
html, body {
    margin: 0;
    padding: 0;
    height: 100%;
    width: 100%;
}

#map {
    height: 100%;
}
</style>
