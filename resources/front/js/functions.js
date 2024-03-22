//const, var
window.BING_API_KEY = 'AiQWMlHxXeZhWVDpu23bjn2xcl7rKmqdmKbPfYkTE6CqLfSoaMSqCNRRv-How-Ir';
window.travels_per_page = 10;
window.events_per_page = 10;
window.page_was_edited = false;
window.redIcon = L.icon({
    iconUrl: '/front/img/pin.svg',
    iconSize: [30, 30], // size of the icon
    iconAnchor: [15, 30], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -30] // point from which the popup should open relative to the iconAnchor
});

window.smallIcon = L.icon({
    iconUrl: '/front/img/pin.svg',
    iconSize: [16, 16], // size of the icon
    iconAnchor: [8, 16], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -16] // point from which the popup should open relative to the iconAnchor
});

window.flagStart = L.icon({
    iconUrl: '/front/img/flag_start.svg',
    iconSize: [30, 30], // size of the icon
    iconAnchor: [15, 30], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -30] // point from which the popup should open relative to the iconAnchor
});

window.flagEnd = L.icon({
    iconUrl: '/front/img/flag_end.svg',
    iconSize: [30, 30], // size of the icon
    iconAnchor: [15, 30], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -30] // point from which the popup should open relative to the iconAnchor
});

window.max_between_points = 50; //макс. расстояние между точками при построении маршрута, км
window.min_between_points = .02; //мин. --//--
window.near_routes_radius = 3; //радиус для поиска "похожих" маршрутов, км

const D = $(document);

D.ready(function ($) {

    $('.input-mask-2').mask('00');
    $('.input-mask-3').mask('000');
    $('.input-mask-7').mask('0000000', {reverse: true});

    $('.js-copy-text').on('click', function (e) {
        e.preventDefault();
        let object = $(this);
        let left = object[0].getBoundingClientRect().left,
            top = object[0].getBoundingClientRect().top + object[0].getBoundingClientRect().height / 2;
        e.preventDefault();
        copyToClipboard($(this).find('.js-text-to-copy')[0]);
        $('.copied-wrap').css({'left': left, 'top': top}).show();
        copyToClipboard($(this).find('.js-text-to-copy')[0]);
        $('.copied-wrap').fadeIn();
        setTimeout(function () {
            $('.copied-wrap').fadeOut()
        }, 2000);
    });

    $('body').on('click', '.copied__close', function (e) {
        e.preventDefault();
        $('.copied-wrap').fadeOut();
    });

    $('.categ__tabs a').tabs();

    $('.js-map-fullscreen').on('click', function (e) {
        e.preventDefault();
        $(this).hide();
        window.dispatchEvent(new Event('resize'));
        $('.js-map-window').show();
        $('.map__frame').addClass('map__frame_big');
    })

    // свертуть карту
    $('.js-map-window').on('click', function (e) {
        e.preventDefault();
        $(this).hide();
        window.dispatchEvent(new Event('resize'));
        $('.js-map-fullscreen').show();
        $('.map__frame').removeClass('map__frame_big');
    });

    //menu mobile
    $('.menu-burger').on('click', function () {
        $('body').addClass('fixed_body');
        $('.body-shadow').addClass('body-shadow_opened');
        setTimeout(function () {
            $('.menu-wrap').addClass('menu-wrap_opened');
        }, 200)
    });

    $('.menu-close').on('click', function () {
        closeMenu();
    });

    $(document).mouseup(function (e) {
        if ($('.menu-burger').is(':visible')) {
            let div = $('.menu-wrap');
            if (!div.is(e.target)
                && div.has(e.target).length === 0
                && !$('.menu-burger').is(e.target)
                && $('.menu-burger').has(e.target).length === 0
            ) {
                closeMenu();
            }
        }
    });

    //filter
    $('.catalog__filter-button').on('click', function () {
        if ($('.catalog__filter_opened').length) {
            closeFilter();
        } else {
            $('body').addClass('fixed_body');
            $('.catalog__filter-shadow').addClass('catalog__filter-shadow_opened');
            setTimeout(function () {
                $('.catalog__filter').addClass('catalog__filter_opened');
            }, 200);
        }
    });

    D.on('click', '.catalog__filter-shadow_opened, .catalog__filter-close', function () {
        closeFilter();
    });

    D.on('click', '.account-menu__trigger', function (e) {
        e.preventDefault();
        $('.account-menu__wrap').slideDown();
    });

    D.mouseup(function (e) {
        var div = $('.account-menu__wrap');
        if (!div.is(e.target)
            && div.has(e.target).length === 0) {
            div.hide();
        }
    });


});

function closeMenu() {
    $('.menu-wrap').removeClass('menu-wrap_opened');
    setTimeout(function () {
        $('.body-shadow').removeClass('body-shadow_opened');
    }, 200)
    $('body').removeClass('fixed_body');
}

window.closeFilter = function () {
    $('body').removeClass('fixed_body');
    $('.catalog__filter').removeClass('catalog__filter_opened');
    setTimeout(function () {
        $('.catalog__filter-shadow').removeClass('catalog__filter-shadow_opened');
    }, 200)
}

function copyToClipboard(elem) {
    // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            //target.style.top = "0";
            target.id = targetId;
            elem.closest(".js-copy-text").appendChild(target);
        }
        target.textContent = elem.textContent;
    }

    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);

    // copy the selection
    var succeed;
    try {
        succeed = document.execCommand("copy");
    } catch (e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }

    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }
    return succeed;
}

/**
 * Инициализация тултипов, после обновления DOM
 */
window.initTooltip = function () {
    if (window.matchMedia("(min-width: 551px)").matches) {
        $('.tooltip-top').tooltip({direction: 'top'});
        $('.tooltip-bottom').tooltip({direction: 'bottom'});
        $('.tooltip-right').tooltip({direction: 'right'});
        $('.tooltip-left').tooltip({direction: 'left'});
    }
}

/**
 * Формирует строку для get-запроса, добавляет историю браузера
 * @param data
 * @param url
 * @returns {*}
 */
window.getQueryString = function (url, data) {
    const getQueryArray = (obj, path = [], result = []) =>
        Object.entries(obj).reduce((acc, [k, v]) => {
            path.push(k);
            if (v || v === 0 && !(k == 'page' && v == 1)) { //убрать page=1 из запроса
                if (v instanceof Object) {
                    getQueryArray(v, path, acc);
                } else {
                    acc.push(`${path.map((n, i) => i ? `[${n}]` : n).join('')}=${v}`);
                }
            }
            path.pop();
            return acc;
        }, result);
    const getQueryString = obj => getQueryArray(obj).join('&');
    const string = getQueryString(data);
    if (string != window.location.search) {
        let full_url = string ? url + '?' + string : url;
        window.history.pushState("", "", full_url);
    }
    return string;
}

/**
 * Добавляет маркеры на карту
 * @param local_points - точки
 * @param local_markers - маркеры (объекты карты)
 * @param local_icon - значок маркера
 * @returns {*}
 */
window.addMarkers = function (local_points, local_markers, local_icon) {
    for (let i = 0; i < local_points.length; i++) {
        local_markers.push(L.marker([local_points[i][0], local_points[i][1]], {icon: local_icon}));
        local_markers[local_markers.length - 1].addTo(map).bindPopup(local_points[i][2]);
    }

    return local_markers;
}

/**
 * Удаляет маркеры
 * @param local_markers - маркеры, нанесенные на карту
 * @returns {*[]}
 */
window.removeMarkers = function (local_markers) {
    if (local_markers) {
        for (let i = 0; i < local_markers.length; i++) {
            local_markers[i].remove(map)
        }
    }
    return [];
}

/**
 * Добавляет линии маршрутов на карту
 * @param local_points - координаты точек, разбитые на подмассивы
 * @returns {*[]}
 */
window.addLines = function (local_points) {
    if (local_points) {
        let lines = [];
        for (let i = 0; i < local_points.length; i++) {
            if (local_points[i][0] != local_points[i][local_points[i].local_points - 1]) {
                for (let k = 1; k < local_points[i].length; k++) {
                    lines.push(L.polyline([
                        [local_points[i][k - 1][0], local_points[i][k - 1][1]],
                        [local_points[i][k][0], local_points[i][k][1]]
                    ], {
                        color: 'green',
                        weight: 3,
                    }));
                    lines[lines.length - 1].addTo(map);
                }
            }
        }
        return lines;
    }
}

/**
 * Скрывает линии маршрутов
 * @param local_lines
 * @returns {*[]}
 */
window.removeLines = function (local_lines) {
    if (local_lines) {
        for (let i = 0; i < local_lines.length; i++) {
            local_lines[i].remove(map)
        }
    }
    return [];
}


window.initMap = function () {
    window.map = L.map('mapdiv').setView([54, 38], 2);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
        prefix: false
    }).addTo(map);
    L.control.locate().addTo(map);
}

/**
 * Вычисление расстояния между двумя точками по координатам
 * @param lat1
 * @param lon1
 * @param lat2
 * @param lon2
 * @returns {number}
 */
window.getDistanceFromLatLonInKm = function (lat1, lon1, lat2, lon2) {
    let R = 6371; // Radius of the earth in km
    let dLat = deg2rad(lat2 - lat1);  // deg2rad below
    let dLon = deg2rad(lon2 - lon1);
    let a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2)
    ;
    let c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c;
}

/**
 * Переводит градусы в радианы
 * @param deg
 * @returns {number}
 */
window.deg2rad = function (deg) {
    return deg * (Math.PI / 180)
}

/**
 * Сохраняет куки
 * @param name
 * @param value
 * @param options
 */
window.setCookie = function (name, value, options) {
    options = options || {};

    var expires = options.expires;

    if (typeof expires == "number" && expires) {
        var d = new Date();
        d.setTime(d.getTime() + expires * 1000);
        expires = options.expires = d;
    }
    if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
    }

    if (!options.path) {
        options.path = '/';
    }

    value = encodeURIComponent(value);

    var updatedCookie = name + "=" + value;

    for (var propName in options) {
        updatedCookie += "; " + propName;
        var propValue = options[propName];
        if (propValue !== true) {
            updatedCookie += "=" + propValue;
        }
    }
    document.cookie = updatedCookie;
}

/**
 * Читает куки
 * @param name
 * @returns {string|undefined}
 */
window.getCookie = function (name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}


/**
 * Отправка отчета об ошибке (запись в лог и телеграм)
 * @param title - название ошибки
 * @param data - содержимое (на сервере сериализуется
 * @param filename - название файла без расширения (если не существует - будет создан)
 */
window.sendErrorReport = function (title, data, filename) {
    $.ajax({
        url: '/error_report',
        method: 'get',
        data: {
            'title': title,
            'data': data,
            'filename': filename,
        }
    });
}

/**
 * Подставляет полученные данные в html-шаблон
 * @param name
 * @param data
 * @returns {string}
 */
window.renderTemplate = function (name, data) {
    let template = document.getElementById(name).innerHTML;
    for (let property in data) {
        if (data.hasOwnProperty(property)) {
            let search = new RegExp('{' + property + '}', 'g');
            template = template.replace(search, data[property]);
        }
    }
    return template;
}

window.showRequestErrors = function (error) {
    $('.ajax-loader').hide();
    setTimeout(function () {
        if (error.status == 422) {
            let from_top, from_top_temp;
            $('.st-input1_error, .checkbox-group__error, .form-item_select__error').each(function () {
                from_top_temp = $(this).offset().top;
                if (!from_top || from_top > from_top_temp)
                    from_top = from_top_temp;
            })
            $('html,body').stop().animate({scrollTop: (from_top - 100)}, 600);
        } else if (error.status == 403) {
            Swal.fire({
                icon: 'error',
                text: error_403
            })
        } else if (error.status == 500) {
            Swal.fire({
                icon: 'error',
                text: error_other
            })
        }
    }, 200)
}

window.formSendResponce = function (msg) {
    $('.ajax-loader').hide();
    if (msg.success) {
        Swal.fire({
            icon: 'success',
            text: msg.success,
            timer: 1500
        })
        window.page_was_edited = false;
    }
    if (msg.error) {
        Swal.fire({
            icon: 'error',
            text: msg.error
        })
    }
    if (msg.redirect)
        window.location = msg.redirect;
}

window.onscroll = function () {
    let scrolled = window.pageYOffset || document.documentElement.scrollTop;
    if (scrolled > 100) {
        $('.header_fixed').removeClass('header_home')
    } else {
        $('.header_fixed').addClass('header_home')
    }
}

window.getMapLocale = function () {
    let locales = {
            'ru': [
                'RU', 'BY', 'KZ', 'KG', 'UZ', 'TJ', 'UA', 'GE', 'AB', 'OS', 'MD', 'AM', 'AZ', 'TM', 'MN'
            ]
        },
        country = window.getCookie('country');
    for (let i in locales) {
        if (locales[i].indexOf(country) >= 0) {
            return i;
        }
    }
    return 'en';

}

window.preventExitPage = function (text, yes, no) {
    D.on('click', 'a', function (e) {
        if (window.page_was_edited) {
            e.preventDefault();
            let href = $(this).attr('href');
            Swal.fire({
                html: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e55353',
                cancelButtonColor: '#ddd',
                confirmButtonText: yes,
                cancelButtonText: no
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = href;
                }
            })
        }
    });
    setTimeout(function () {
        window.page_was_edited = false;
        D.ready(function () {
            D.on('change', 'textarea, input, select, .multiselect__single', function () {
                window.page_was_edited = true;
            })
        })
    }, 1000)
}
window.scrollToTop = function () {
    $('html,body').stop().animate({scrollTop: 0}, 600);
}

window.getIDs = function (arr) {
    let ids = [];
    for (let i in arr) {
        ids.push(arr[i]['id'])
    }
    return ids;
}

window.getNameById = function (id, scope) {
    for (let i in scope) {
        if (scope[i].id == id)
            return scope[i].name;
    }
    return '';
}
