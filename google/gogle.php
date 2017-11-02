<!DOCTYPE html >
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <script src="../js/jquery.min.js" type="text/javascript"></script>

    <title>Using MySQL and PHP with Google Maps</title>
    <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 100%;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
<div id="map"></div>

<script>
    var customLabel = {
        restaurant: {
            label: 'R'
        },
        bar: {
            label: 'B'
        }
    };

    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: new google.maps.LatLng(-33.863276, 151.207977),
            zoom: 12
        });
        var infoWindow = new google.maps.InfoWindow;

        // Change this depending on the name of your PHP or XML file
        downloadUrl('xml.php', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
                var name = markerElem.getAttribute('name');
                var address = markerElem.getAttribute('address');
                var type = markerElem.getAttribute('type');
                var point = new google.maps.LatLng(
                    parseFloat(markerElem.getAttribute('lat')),
                    parseFloat(markerElem.getAttribute('lng')));

                var infowincontent = document.createElement('div');
                var strong = document.createElement('strong');
                strong.textContent = name
                infowincontent.appendChild(strong);
                infowincontent.appendChild(document.createElement('br'));

                var text = document.createElement('text');
                text.textContent = address
                infowincontent.appendChild(text);
                var icon = customLabel[type] || {};
                var marker = new google.maps.Marker({
                    map: map,
                    position: point,
                    label: icon.label
                });
                marker.addListener('click', function() {
                    infoWindow.setContent(infowincontent);
                    infoWindow.open(map, marker);
                });
            });
        });

        var html = "<table>" +
            "<tr><td>Наименование:</td> <td><input type='text' id='name'/> </td> </tr>" +
            "<tr><td>Адрес:</td> <td><input type='text' id='address'/></td> </tr>" +
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
        var latlng = marker.getPosition();
        var data = {
            "name": name,
            "address": address,
            "lat" : latlng.lat(),
            "log" : latlng.lng()
        };
        $.ajax({
            url:'uplode.php',
            method:'post',
            dataType:'json',
            data:data,
            success: function (response) {
                console.log(response);
            }
        })

    }

    function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                request.onreadystatechange = doNothing;
                callback(request, request.status);
            }
        };

        request.open('GET', url, true);
        request.send(null);
    }

    function doNothing() {}
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAk5B_hXhXQ_S6Jj8xh-qc_buguESn4ZM0&callback=initMap">
</script>
</body>
</html>