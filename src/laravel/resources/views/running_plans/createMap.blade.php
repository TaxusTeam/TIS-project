<?php
$GMAP_API_KEY = "AIzaSyDo5pBIiXi0VjW3c07_VtZ8-ecc9GABLEk";
?>

<input class="col-xs-12 col-sm-8" id="gmap--address" type="textbox" value="vysoke tatry" placeholder="Hľadaj na mape">
<input class="col-xs-12 col-sm-4" id="gmap--geocode" type="button" value="Hľadaj na mape">

<div id="map"></div>

<input class="col-xs-12 col-sm-4" id="gmap--locate" type="button" value="Lokalizuj aktuálnu polohu">
<div class="col-xs-12 col-sm-4" id="gmap--distance"></div>
<input class="col-xs-12 col-sm-4" id="gmap--clear-path" type="button" value="Vymaž trasu">

<h2 class="gmap--instructions">Kliknutím ľavým tlačidlom myši pridáte koncový bod trasy.</h2>
<h2 class="gmap--instructions">Trasu môžete tvarovať jej ťahaním.</h2>
<h2 class="gmap--instructions">Ak sa Vám nedarí vytvárať koncové body trasy, ubezpečte sa prosím, že skutočne iba klikáte a nie ťaháte myš so stlačeným tlačidlom.</h2>

<script>
    function initMap() {

        var fmfiLatlng = {lat: 48.1512219, lng: 17.0701161};

        var map = new google.maps.Map(document.getElementById('map'), {
            center: fmfiLatlng,
            zoom: 16,
        });

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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

        $(document).ready(function () {
            $("#gmap--locate").click(function () {
                geolocate();
            });
        });

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        var geocoder = new google.maps.Geocoder();

        function geocodeAddress(geocoder, resultsMap) {
            var address = document.getElementById('gmap--address').value;

            geocoder.geocode({'address': address, 'region': 'SK'}, function(results, status) {
                if (status === 'OK') {
                    resultsMap.setCenter(results[0].geometry.location);
                } else {
                    alert('Nepodarilo sa nájsť zadanú adresu z dôvodu: ' + status);
                }
            });
        }

        var autocomplete = new google.maps.places.Autocomplete(document.getElementById('gmap--address'), {});

        $(document).ready(function () {
           $("#gmap--geocode").click(function () {
               geocodeAddress(geocoder, map);
           });
        });

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////


        var directionsDisplay = new google.maps.DirectionsRenderer({
            preserveViewport: true,
            draggable: true,
        });

        var directionsService = new google.maps.DirectionsService();

        var routeStart = null;
        var routeEnd = null;
        var routeStartMarker = new google.maps.Marker({
            map: map,
        });
        var routeEndMarker = new google.maps.Marker({
            map: map,
        });

        map.addListener('click', function (e) {
            if (routeStart == null) {
                routeStart = e.latLng;

                routeStartMarker.setMap(map);
                routeStartMarker.setPosition(routeStart);
            } else if (routeEnd == null) {
                routeEnd = e.latLng;

                routeEndMarker.setMap(map);
                routeEndMarker.setPosition(routeEnd);

                initRoute();
            }
        });

        $(document).ready(function () {
            $("#gmap--clear-path").click(function () {
                routeStart = null;
                routeEnd = null;

                routeStartMarker.setMap(null);
                routeEndMarker.setMap(null);

                directionsDisplay.setMap(null);

                $(document).ready(function () {
                    $("input[type='submit']").attr("disabled", "disabled");
                });
            });
        });



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

                    //updateRoute(result);

                    routeStartMarker.setMap(null);
                    routeEndMarker.setMap(null);

                    $(document).ready(function () {
                        $("input[type='submit']").removeAttr("disabled");
                    });
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
            var totalDistanceValue = directionsResult.routes[0].legs[0].distance.value;

            var path = [];

            for (var i = 0; i < steps.length; i++) {
                path.push(steps[i]);
            }

            $(document).ready(function () {
                $("#gmap--distance").html("celková vzdialenosť: " + totalDistanceText);
            });

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////

            localStorage.setItem("totalDistanceText", totalDistanceText);
            localStorage.setItem("totalDistanceValue", totalDistanceValue);
            localStorage.setItem("totalGeoLocationsLength", path.length);
            for (var i = 0; i < path.length; i++) {
                localStorage.setItem("geoLocation_" + i + "_Lat", path[i].lat());
                localStorage.setItem("geoLocation_" + i + "_Lng", path[i].lng());
            }
        }
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?= $GMAP_API_KEY ?>&callback=initMap&language=sk&region=SK&libraries=places"
        async defer>
</script>
