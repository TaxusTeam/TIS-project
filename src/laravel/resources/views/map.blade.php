@extends('app')

@section('content')
    <h1>Zapisnik</h1>
    <p id="mapText">Vizualizacia naplnanie cielov a vkladanie odbehnutej vzdialenosti.</p>

    <?php
    $GMAP_API_KEY = "AIzaSyDo5pBIiXi0VjW3c07_VtZ8-ecc9GABLEk";
    ?>

    <h3>MAPA</h3>
    <div id="floating-panel">
        <input id="address" type="textbox" value="vysoke tatry">
        <input id="submit" type="button" value="Geocode">
    </div>
    <div id="map"></div>
    <script>
        function initMap() {

            function toDegrees (r) {
                return r * (180 / Math.PI);
            }

            function toRadians (d) {
                return d * (Math.PI / 180);
            }

            /**
             * counts approximate air distance between two points
             * @param a - LatLng Object
             * @param b - LatLng Object
             * @returns {number} - distance between a and b in metres
             */
            function geoDistance (a, b) {
                var R = 6371e3;
                var phi_a = toRadians(a.lat());
                var phi_b = toRadians(b.lat());
                var delta_phi = toRadians((b.lat() - a.lat()));
                var delta_lambda = toRadians((b.lng() - a.lng()));

                var aa = Math.sin(delta_phi / 2) * Math.sin(delta_phi / 2) +
                        Math.cos(phi_a) * Math.cos(phi_b) *
                        Math.sin(delta_lambda / 2) * Math.sin(delta_lambda / 2);
                var cc = 2 * Math.atan2(Math.sqrt(aa), Math.sqrt(1 - aa));

                return R * cc;
            }

            /**
             * counts approximate center between two points
             * @param a - LatLng Object
             * @param b - LatLng Object
             * @returns {LatLng} - LatLng object midPoint between a and b
             */
            function geoMidPoint(a, b) {
                var delta_lng = toRadians(b.lng() - a.lng());

                var lat_a = toRadians(a.lat());
                var lat_b = toRadians(b.lat());
                var lng_a = toRadians(a.lng());

                var x = Math.cos(lat_b) * Math.cos(delta_lng);
                var y = Math.cos(lat_b) * Math.sin(delta_lng);
                var lat_mid = Math.atan2(Math.sin(lat_a) + Math.sin(lat_b),
                        Math.sqrt((Math.cos(lat_a) + x) * (Math.cos(lat_a) + x) + y * y));
                var lng_mid = lng_a + Math.atan2(y, Math.cos(lat_a) + x);

                var center = new google.maps.LatLng({
                    lat: toDegrees(lat_mid),
                    lng: toDegrees(lng_mid)
                });

                return center;
            }

            function generateInterpolationPath(path, ix, distance) {
                if (geoDistance(path[ix], path[ix+1]) <= distance) {
                    return 0;
                }

                path.splice(ix+1, 0, geoMidPoint(path[ix], path[ix+1]));
                var leftBranch = generateInterpolationPath(path, ix, distance);
                var rightBranch = generateInterpolationPath(path, ix + leftBranch + 1, distance);

                return leftBranch + 1 + rightBranch;
            }

            function setGeoPath(initPath) {
                var granularity = 10;
                var offset = 0;
                var initLength = initPath.length;
                for (var i = 0; i < initLength - 1; i++) {
                    offset += generateInterpolationPath(initPath, i + offset, granularity);
                }
            }

            /////////////////////////////////////////////////////////////////////////////////////////////////////

            var myLatlng = {lat: 48.1512219, lng: 17.0701161};

            var map = new google.maps.Map(document.getElementById('map'), {
                center: myLatlng,
                zoom: 16,
            });

            function geolocate() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var geolocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };

                        map.setCenter(geolocation);
                    });
                }
            }

            geolocate(); // nefunguje v Chrome pre insecure locations (na https servri to pojde ???) vo FF ide ok



            var geocoder = new google.maps.Geocoder();

            document.getElementById('submit').addEventListener('click', function() {
                geocodeAddress(geocoder, map);
            });

            function geocodeAddress(geocoder, resultsMap) {
                var address = document.getElementById('address').value;
                geocoder.geocode({'address': address, 'region': 'SK'}, function(results, status) {
                    if (status === 'OK') {
                        resultsMap.setCenter(results[0].geometry.location);
                    } else {
                        alert('Geocode was not successful for the following reason: ' + status);
                    }
                });
            }

            var autocomplete = new google.maps.places.Autocomplete(document.getElementById('address'), {});


            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////


            var directionsDisplay = new google.maps.DirectionsRenderer({
                preserveViewport: true,
                draggable: true,
            });

            var directionsService = new google.maps.DirectionsService();

            var routeStart = null;
            var routeEnd = null;

            map.addListener('click', function (e) {
                if (routeStart == null) {
                    routeStart = e.latLng;
                } else if (routeEnd == null) {
                    routeEnd = e.latLng;

                    initRoute();
                }
            });

            var playerMarker = new google.maps.Marker({
                map: map,
            });

            var slider = document.getElementById('slider');

            var infoText = document.getElementById('text');

            function initRoute() {
                var request = {
                    origin: routeStart,
                    destination: routeEnd,
                    travelMode: 'WALKING',
                    unitSystem: google.maps.UnitSystem.METRIC,
                };

                directionsService.route(request, function(result, status) {
                    if (status == 'OK') {
                        directionsDisplay.setDirections(result);
                        directionsDisplay.setMap(map);

                        updateRoute(result)
                    }
                });
            }

            directionsDisplay.addListener('directions_changed', function (e) {
                var directionsResult = directionsDisplay.getDirections();

                updateRoute(directionsResult);
            });

            function updateRoute(directionsResult) {
                var steps = directionsResult.routes[0].overview_path;
                var totalDistanceText = directionsResult.routes[0].legs[0].distance.text;

                var path = [];

                for (var i = 0; i < steps.length; i++) {
                    path.push(steps[i]);
                }

                setGeoPath(path);

                slider.setAttribute("max", path.length);

                var pos = path[slider.value];
                playerMarker.setPosition(pos);
                infoText.innerHTML = "celková vzdialenosť: " + totalDistanceText + "<br />" + (slider.value / path.length)*100 + "%";

                slider.addEventListener('change', function () {
                    var pos = path[slider.value];
                    playerMarker.setPosition(pos);
                    infoText.innerHTML = "celková vzdialenosť: " + totalDistanceText + "<br />" + (slider.value / path.length)*100 + "%";
                });

                slider.addEventListener('input', function () {
                    var pos = path[slider.value];
                    playerMarker.setPosition(pos);
                    infoText.innerHTML = "celková vzdialenosť: " + totalDistanceText + "<br />" + (slider.value / path.length)*100 + "%";
                });
            }
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?= $GMAP_API_KEY ?>&callback=initMap&language=sk&region=SK&libraries=places"
            async defer>
    </script>
    <div id="info">
        <div id="text"></div>
        <input type="range" id="slider" min="0" value="0">
    </div>


@endsection