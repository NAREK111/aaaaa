<?php
session_start();
include '../function/function.php';
if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    die();
}
$arr = json_array('../register.json');
$maps = $arr[$_SESSION['user_id']]['maps'];
echo '<pre>';
var_dump($maps);
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>API Google Maps v3 добавление меток пользователями и вывод их по категориям</title>
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAk5B_hXhXQ_S6Jj8xh-qc_buguESn4ZM0&callback=initMap"></script>

    <script src="../js/jquery.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        var map, marker, gmarkers = [];

        /* var customIcons = {
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
         };*/

        function initialize() {
            var myLatlng = new google.maps.LatLng(40.175725518346916, 44.50286865234375);
            var myOptions = {
                zoom: 9,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }

            map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);


            var html = "<table>" +
                "<tr><td>Наименование:</td> <td><input type='text' id='name'/> </td> </tr>" +
                "<tr><td>Адрес:</td> <td><input type='text' id='address'/></td> </tr>" +
                "</select> </td></tr>" +
                "<tr><td></td><td><input type='button' value='Сохранить' onclick='saveData()'/></td></tr></form>";
            infowindow = new google.maps.InfoWindow({
                content: html
            });

            google.maps.event.addListener(map, "click", function (event) {
                marker = new google.maps.Marker({
                    position: event.latLng,
                    map: map
                });
                google.maps.event.addListener(marker, "click", function () {
                    infowindow.open(map, marker);
                });
            });
        }


        function saveData() {
            var name = escape(document.getElementById("name").value);
            var address = escape(document.getElementById("address").value);
            var latlng = marker.getPosition();
            var data = {
                "name": name,
                "address": address,
                "lat": latlng.lat(),
                "log": latlng.lng()
            };
            $.ajax({
                url: 'uplode.php',
                method: 'post',
                dataType: 'json',
                data: data,
                success: function (response) {
                    console.log(response);
                }
            })

        }

        /*   function downloadUrl(url, callback) {
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
   */
        /*  function setMarkers(data, category) {

              var infoWindow = new google.maps.InfoWindow;
              var baseIcon = customIcons[category];

              var marker_point = new Array();
              var html = new Array();

              for(var i = 0; i < data.markers.length; i++) {
                  marker_point[i] = new google.maps.LatLng(data.markers[i].lat, data.markers[i].lon);
                  html[i] = '<strong>'+data.markers[i].mname+'</strong><br />'+data.markers[i].address;
                  createMarker(marker_point[i], html[i], baseIcon, infoWindow, category);
              }

          }*/

        /*   function createMarker(point, html, icon, infoWindow, category) {
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
   */
        /*
                function show(category) {
                    for (var i=0; i<gmarkers.length; i++) {
                        if (gmarkers[i].mycategory == category) {
                            gmarkers[i].setVisible(true);
                        }
                    }
                    // == check the checkbox ==
                    document.getElementById(category+"box").checked = true;
                }*/

        // == hides all markers of a particular category, and ensures the checkbox is cleared ==
        /* function hide(category) {
             for (var i=0; i<gmarkers.length; i++) {
                 if (gmarkers[i].mycategory == category) {
                     gmarkers[i].setVisible(false);
                 }
             }
             // == clear the checkbox ==
             document.getElementById(category+"box").checked = false;
             // == close the info window, in case its open on a marker that we just hid
             infowindow.close();
         }*/

    </script>

    <style type="text/css" media="screen">
        #map_canvas {
            float: left;
            width: 600px;
            height: 400px;
            border: 1px solid #000;
        }

        ul#markerTypes {
            float: left;
            width: 500px;
            list-style: none;
            padding: 0;
        }

        ul#markerTypes li {
            padding: 10px;
        }

        ul#markerTypes li label {
            color: #000;
        }
    </style>

</head>
<body onload="initialize()">
<div id="map_canvas"></div>

<!--<ul id="markerTypes">
    <li><label for="viv_bars"><input id="barbox" type="checkbox" value="bar" /> Бары</label></li>
    <li><label for="viv_cafe"><input id="cafebox" type="checkbox" value="cafe" /> Кафе</label></li>
    <li><label for="viv_rest"><input id="restaurantbox" type="checkbox" value="restaurant" /> Рестораны</label></li>
</ul>-->

<div id="message"></div>
</body>
</html>