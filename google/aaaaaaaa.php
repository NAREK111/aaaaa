<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>API Google Maps v3 добавление меток пользователями и вывод их по категориям</title>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

    <script src="../jquery.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        function initialize() {
            var myLatlng = new google.maps.LatLng(56.32,44.004);
            var myOptions = {
                zoom: 15,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

            var html = "<table>" +
                "<tr><td>Наименование:</td> <td><input type='text' id='name'/> </td> </tr>" +
                "<tr><td>Адрес:</td> <td><input type='text' id='address'/></td> </tr>" +
                "<tr><td>Тип:</td> <td><select id='type'>" +
                "<option value='bar' SELECTED>Бар</option>" +
                "<option value='restaurant'>Ресторан</option>" +
                "<option value='cafe'>Кафе</option>" +
                "</select> </td></tr>" +
                "<tr><td></td><td><input type='button' value='Сохранить' onclick='saveData()'/></td></tr></form>";

            infowindow = new google.maps.InfoWindow({
                content: html
            });

            google.maps.event.addListener(map, "click", function(event) {
                marker = new google.maps.Marker({
                    position: event.latLng,
                    map: map
                });
                google.maps.event.addListener(marker, "click", function() {
                    infowindow.open(map, marker);
                });
            });
        }

        function saveData() {
            var name = escape(document.getElementById("name").value);
            var address = escape(document.getElementById("address").value);
            var type = document.getElementById("type").value;
            var latlng = marker.getPosition();

            var url = "phpsqlinfo_addrow.php?name=" + name + "&address=" + address +
                "&type=" + type + "&lat=" + latlng.lat() + "&lng=" + latlng.lng();
            downloadUrl(url, function(data, responseCode) {
                if (responseCode == 200 && data.length <= 1) {
                    infowindow.close();
                    document.getElementById("message").innerHTML = "Данные добавлены.";
                }
            });
        }

        function downloadUrl(url, callback) {
            var request = window.ActiveXObject ?
                new ActiveXObject('Microsoft.XMLHTTP') :
                new XMLHttpRequest;

            request.onreadystatechange = function() {
                if (request.readyState == 4) {
                    request.onreadystatechange = doNothing;
                    callback(request.responseText, request.status);
                }
            };

            request.open('GET', url, true);
            request.send(null);
        }

        function doNothing() {}

    </script>

    <style type="text/css" media="screen">
        #map_canvas { float:left; width:600px; height:400px; border:1px solid #000;}
        ul#markerTypes { float:left; width:500px; list-style:none; padding:0; }
        ul#markerTypes li { padding:10px; }
        ul#markerTypes li label{ color: #000; }
    </style>

</head>
<body onload="initialize()">
<div id="map_canvas"></div>

<ul id="markerTypes">
    <li><label for="viv_bars"><input id="barbox" type="checkbox" value="bar" /> Бары</label></li>
    <li><label for="viv_cafe"><input id="cafebox" type="checkbox" value="cafe" /> Кафе</label></li>
    <li><label for="viv_rest"><input id="restaurantbox" type="checkbox" value="restaurant" /> Рестораны</label></li>
</ul>

<div id="message"></div>
</body>
</html>
В переменную html мы добавляем код формы для ввода параметров метки.

И в балун добавляем нашу переменную html.

Затем мы обрабатываем события клика по карте, при этом событии на карту добавляется маркер, а при клике на маркере открывается балун с нашей формой.

После нажатия на кнопку Сохранить, введенные в форму параметры предаются в функцию saveData.

В ней методом GET данные передаются в файл phpsqlinfo_addrow.php для записи в базу данных.

Если запись прошла успешно, то выводится сообщение о добавлении данных.

Последний этап это реализация вывода маркеров из базы данных по категориям.

Окончательный код файла phpsqlinfo_add.html

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>API Google Maps v3 добавление меток пользователями и вывод их по категориям</title>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

    <script src="../jquery.min.js" type="text/javascript"></script>

    <script type="text/javascript">

        var map, marker, gmarkers = [];

        var customIcons = {
            restaurant: {
                icon: 'http://webmap-blog.ru/files/gmap/gicon/mm_20_blue.png',
                shadow: 'http://webmap-blog.ru/files/gmap/gicon/mm_20_shadow.png'
            },
            bar: {
                icon: 'http://webmap-blog.ru/files/gmap/gicon/mm_20_red.png',
                shadow: 'http://webmap-blog.ru/files/gmap/gicon/mm_20_shadow.png'
            },
            cafe: {
                icon: 'http://webmap-blog.ru/files/gmap/gicon/mm_20_green.png',
                shadow: 'http://webmap-blog.ru/files/gmap/gicon/mm_20_shadow.png'
            }
        };

        function initialize() {
            var myLatlng = new google.maps.LatLng(56.32,44.004);
            var myOptions = {
                zoom: 15,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }

            map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

            $('#markerTypes input[type="checkbox"]').bind('click', function () {

                var markersType = $(this).val();

                if($(this).attr("checked")) {

                    if(!gmarkers[markersType]) {

                        gmarkers[markersType] = [];

                        $.getJSON("http://localhost/gmaps/gmaps-dob/upload.php", {markersType:markersType}, function(data){

                            setMarkers(data, markersType);

                        });

                    }
                    else {
                        show(markersType);
                    }

                }
                else {
                    hide(markersType);
                }
            });

            var html = "<table>" +
                "<tr><td>Наименование:</td> <td><input type='text' id='name'/> </td> </tr>" +
                "<tr><td>Адрес:</td> <td><input type='text' id='address'/></td> </tr>" +
                "<tr><td>Тип:</td> <td><select id='type'>" +
                "<option value='bar' SELECTED>Бар</option>" +
                "<option value='restaurant'>Ресторан</option>" +
                "<option value='cafe'>Кафе</option>" +
                "</select> </td></tr>" +
                "<tr><td></td><td><input type='button' value='Сохранить' onclick='saveData()'/></td></tr></form>";
            infowindow = new google.maps.InfoWindow({
                content: html
            });

            google.maps.event.addListener(map, "click", function(event) {
                marker = new google.maps.Marker({
                    position: event.latLng,
                    map: map
                });
                google.maps.event.addListener(marker, "click", function() {
                    infowindow.open(map, marker);
                });
            });
        }

        function saveData() {
            var name = escape(document.getElementById("name").value);
            var address = escape(document.getElementById("address").value);
            var type = document.getElementById("type").value;
            var latlng = marker.getPosition();

            var url = "phpsqlinfo_addrow.php?name=" + name + "&address=" + address +
                "&type=" + type + "&lat=" + latlng.lat() + "&lng=" + latlng.lng();
            downloadUrl(url, function(data, responseCode) {
                if (responseCode == 200 && data.length <= 1) {
                    infowindow.close();
                    document.getElementById("message").innerHTML = "Данные добавлены.";
                }
            });
        }

        function downloadUrl(url, callback) {
            var request = window.ActiveXObject ?
                new ActiveXObject('Microsoft.XMLHTTP') :
                new XMLHttpRequest;

            request.onreadystatechange = function() {
                if (request.readyState == 4) {
                    request.onreadystatechange = doNothing;
                    callback(request.responseText, request.status);
                }
            };

            request.open('GET', url, true);
            request.send(null);
        }

        function doNothing() {}

        function setMarkers(data, category) {

            var infoWindow = new google.maps.InfoWindow;
            var baseIcon = customIcons[category];

            var marker_point = new Array();
            var html = new Array();

            for(var i = 0; i < data.markers.length; i++) {
                marker_point[i] = new google.maps.LatLng(data.markers[i].lat, data.markers[i].lon);
                html[i] = '<strong>'+data.markers[i].mname+'</strong><br />'+data.markers[i].address;
                createMarker(marker_point[i], html[i], baseIcon, infoWindow, category);
            }

        }

        function createMarker(point, html, icon, infoWindow, category) {
            var marker = new google.maps.Marker({
                map: map,
                position: point,
                icon: icon.icon,
                shadow: icon.shadow
            });

            marker.mycategory = category;

            google.maps.event.addListener(marker, 'click', function() {
                infoWindow.setContent(html);
                infoWindow.open(map, marker);
            });
            gmarkers.push(marker);
            return marker;
        }


        function show(category) {
            for (var i=0; i<gmarkers.length; i++) {
                if (gmarkers[i].mycategory == category) {
                    gmarkers[i].setVisible(true);
                }
            }
            // == check the checkbox ==
            document.getElementById(category+"box").checked = true;
        }

        // == hides all markers of a particular category, and ensures the checkbox is cleared ==
        function hide(category) {
            for (var i=0; i<gmarkers.length; i++) {
                if (gmarkers[i].mycategory == category) {
                    gmarkers[i].setVisible(false);
                }
            }
            // == clear the checkbox ==
            document.getElementById(category+"box").checked = false;
            // == close the info window, in case its open on a marker that we just hid
            infowindow.close();
        }

    </script>

    <style type="text/css" media="screen">
        #map_canvas { float:left; width:600px; height:400px; border:1px solid #000;}
        ul#markerTypes { float:left; width:500px; list-style:none; padding:0; }
        ul#markerTypes li { padding:10px; }
        ul#markerTypes li label{ color: #000; }
    </style>

</head>
<body onload="initialize()">
<div id="map_canvas"></div>

<ul id="markerTypes">
    <li><label for="viv_bars"><input id="barbox" type="checkbox" value="bar" /> Бары</label></li>
    <li><label for="viv_cafe"><input id="cafebox" type="checkbox" value="cafe" /> Кафе</label></li>
    <li><label for="viv_rest"><input id="restaurantbox" type="checkbox" value="restaurant" /> Рестораны</label></li>
</ul>

<div id="message"></div>
</body>
</html>