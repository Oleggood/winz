<?php

return [
    // создание маршрута
    'crt_tx1' => 'Cancel the last point',

    'crt_tx4' => 'Cancel',

    'crt_tx9' => 'Delete all points',


    'crt_tx11' => 'Country',
    'crt_tx11_1' => ' (begin typing)',
    'crt_tx12' => 'Region',
    'crt_tx13' => 'Add new route',
    'crt_tx13_1' => 'Edit route',
    'crt_tx13_2' => 'Route',
    'crt_tx14' => 'Distance, km (approximately)',
    'crt_tx14_2' => 'km',
    'crt_tx15_2' => 'Choose transport',
    'crt_tx15_3' => 'Suitable transport',

    'crt_tx21' => 'Within a radius of {distance}km from this point found existing routes ({quantity}pcs). Click the link to view them',
    'crt_tx22' => 'Route author',
    'crt_tx17' => 'Availability period',
    'crt_tx18' => 'Available',
    'crt_tx19' => 'Not available',

    'crt_lb2' => 'Surface type',


    'crt_lb4' => 'Level of difficulty',


    'crt_lb5' => 'How long will it take?',
    'crt_lb6' => 'Estimated duration',
    'crt_lb6_1' => 'Duration',
    'crt_vars3' => [
        [
            'id' => 1,
            'name' => '1-5 hours'
        ], [
            'id' => 5,
            'name' => '6-10 hours'
        ], [
            'id' => 10,
            'name' => 'no more than 1 day'
        ], [
            'id' => 20,
            'name' => '1-2 days'
        ], [
            'id' => 30,
            'name' => '3-4 days'
        ], [
            'id' => 40,
            'name' => '5-6 days'
        ], [
            'id' => 50,
            'name' => '1 week'
        ], [
            'id' => 60,
            'name' => '2 weeks'
        ], [
            'id' => 70,
            'name' => 'more 3 weeks'
        ],
    ],

    'crt_lb8' => 'Short description',
    'crt_lb10_1' => 'Photo of the area',
    'crt_lb10_2' => 'Photos from the event',

    'crt_lb50' => 'Route rating',
    'crt_lb51' => 'Author rating',
    'crt_lb51_2' => 'Event rating',
    'crt_lb52' => 'User reviews of events on the route',

    'crt_err1' => 'The photo must be in jpg, png or gif format',
    'crt_err2' => 'Photo size should not exceed 2 MB',
    'crt_err3' => 'Choose at least one option',
    'crt_err4' => 'Select the months when the route is available',
    'crt_err5' => 'Specify at least one point on the map',
    'crt_err6' => 'An error occurred when determining the distance',
    'crt_err6_1' => 'An error occurred while determining the region',
    'crt_err6_2' => 'An error occurred when determining the country',
    'crt_err7' => '<div class="col0"><p class="fz16 mb20 lh14">Nothing found.<br>Try to change the filtering conditions</p></div>',

    'crt_lb15' => 'Possible difficulties and dangers',
    'crt_lb16' => 'add',
    'crt_lb17' => '—',
    'crt_lb18' => 'Need a guide?',

    'availabilities' => [
        [
            'id' => 1,
            'name' => 'January'
        ], [
            'id' => 2,
            'name' => 'February'
        ], [
            'id' => 3,
            'name' => 'March'
        ], [
            'id' => 4,
            'name' => 'April'
        ], [
            'id' => 5,
            'name' => 'May'
        ], [
            'id' => 6,
            'name' => 'June'
        ], [
            'id' => 7,
            'name' => 'July'
        ], [
            'id' => 8,
            'name' => 'August'
        ], [
            'id' => 9,
            'name' => 'September'
        ], [
            'id' => 10,
            'name' => 'October'
        ], [
            'id' => 11,
            'name' => 'November'
        ], [
            'id' => 12,
            'name' => 'December'
        ],
    ],

    'transport__surfaces' => [
        [
            'id' => 10,
            'name' => 'Autobahn, highway'
        ], [
            'id' => 20,
            'name' => 'Asphalt road'
        ], [
            'id' => 30,
            'name' => 'Broken asphalt road'
        ], [
            'id' => 40,
            'name' => 'Smooth dirt road'
        ], [
            'id' => 50,
            'name' => 'Broken dirt road'
        ], [
            'id' => 60,
            'name' => 'Off-road'
        ], [
            'id' => 70,
            'name' => 'Off-road with fords across the rivers'
        ], [
            'id' => 80,
            'name' => 'Off-road with bottleneck'
        ], [
            'id' => 90,
            'name' => 'Off-road with bottleneck and fords across the rivers'
        ], [
            'id' => 100,
            'name' => 'Rocks'
        ], [
            'id' => 110,
            'name' => 'Rocks with dirt'
        ], [
            'id' => 120,
            'name' => 'Rocks with bottleneck'
        ], [
            'id' => 130,
            'name' => 'Rocks with fords across the rivers'
        ], [
            'id' => 140,
            'name' => 'Rocks with snow and ice'
        ], [
            'id' => 150,
            'name' => 'Snow and ice'
        ], [
            'id' => 160,
            'name' => 'Water (river, lake)'
        ], [
            'id' => 170,
            'name' => 'Water with rapids and waterfalls on the river'
        ], [
            'id' => 180,
            'name' => 'Water - artificial reservoir'
        ], [
            'id' => 190,
            'name' => 'Water - ocean, sea'
        ], [
            'id' => 200,
            'name' => 'Cave, underground'
        ], [
            'id' => 210,
            'name' => 'Bicycle lane'
        ], [
            'id' => 220,
            'name' => 'Sidewalk'
        ], [
            'id' => 230,
            'name' => 'Stadium'
        ], [
            'id' => 240,
            'name' => 'Race track'
        ], [
            'id' => 250,
            'name' => 'Fly'
        ]
    ],

    'difficult' => [
        [
            'id' => 10,
            'name' => 'For beginners'
        ], [
            'id' => 20,
            'name' => 'Need initial skills'
        ], [
            'id' => 30,
            'name' => 'For advanced'
        ], [
            'id' => 40,
            'name' => 'For experienced'
        ], [
            'id' => 50,
            'name' => 'For experts'
        ], [
            'id' => 60,
            'name' => 'Extreme'
        ], [
            'id' => 100,
            'name' => '-Unknown-'
        ],
    ],

    'transport_categories' => [
        [
            'id' => 2,
            'name' => 'Ground transport'
        ], [
            'id' => 3,
            'name' => 'Water transport'
        ], [
            'id' => 4,
            'name' => 'Air transport'
        ], [
            'id' => 5,
            'name' => 'Animals'
        ],
    ],

    'escort' => [
        [
            'id' => 1,
            'name' => 'Required'
        ], [
            'id' => 10,
            'name' => 'Desirable'
        ], [
            'id' => 20,
            'name' => 'Not required'
        ]
    ],

    'lst_tx1' => 'from',
    'lst_tx2' => 'to',
    'lst_tx3' => 'Distance, km',

    'lst_tx6_1' => 'Distance<br> from the previous point, km: ',
    'lst_tx6_2' => '<br>from the starting point, km: ',


    'edt_tx1' => 'Saved successfully',
    'edt_tx2' => 'Are you sure you want to delete?',
    'edt_tx3' => 'Unable to delete',
    'edt_tx4' => 'Yes, delete',


    'cre_tx1' => 'Add event',

    'vw_txt1' => 'Events on this route',
    'vw_txt2' => 'Start date',
    'vw_txt3' => 'Duration',
    'vw_txt4' => 'Author',

    'vw_txt50' => 'Edit route',
    'vw_txt51' => 'See',
    'vw_txt52' => 'Complaint about a travel',

    'ntf_tx1' => 'Added a new route',
    'ntf_tx2' => 'Go to route',
    'ntf_tx3' => 'Hello',


    'ntf_cns_tx1' => 'Travel status changed',
    'ntf_cns_tx2' => 'Reason',
    'ntf_cns_tx3' => 'New status',
    'ntf_cns_tx4' => 'Name',

    'states' => [
        [
            'id' => 1,
            'name' => 'Active'
        ], [
            'id' => 2,
            'name' => 'Disabled at user\'s request'
        ], [
            'id' => 3,
            'name' => 'Disabled by administrator'
        ],
    ],
];
