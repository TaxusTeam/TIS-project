<?php
$GMAP_API_KEY = "AIzaSyB3rIhgEx90wqPIo7LzAkloA4YK8GxwJHQ";
?>

<div id="map"></div>

<script>
    function initMap() {

        var origin = {
            lat: Number( {{ $runningPlan->origin_lat }} ),
            lng: Number( {{ $runningPlan->origin_lng }} )
        };

        var destination = {
            lat: Number( {{ $runningPlan->destination_lat }} ),
            lng: Number( {{ $runningPlan->destination_lng }} )
        };

        var map = new google.maps.Map(document.getElementById('map'), {
            center: origin,
            zoom: 16,
        });

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////


        var directionsDisplay = new google.maps.DirectionsRenderer({
            preserveViewport: true,
            draggable: false,
        });

        var directionsService = new google.maps.DirectionsService();

        initRoute();

        function initRoute() {
            var request = {
                origin: origin,
                destination: destination,
                travelMode: 'WALKING',
                unitSystem: google.maps.UnitSystem.METRIC,
            };

            directionsService.route(request, function(result, status) {
                if (status == 'OK') {
                    directionsDisplay.setDirections(result);
                    directionsDisplay.setMap(map);

                    //updateRoute(result);
                }
            });
        }

        directionsDisplay.addListener('directions_changed', function (e) {
            var directionsResult = directionsDisplay.getDirections();

            updateRoute(directionsResult);
        });

        function updateRoute(directionsResult) {
            var steps = directionsResult.routes[0].overview_path;

            var path = [];

            for (var i = 0; i < steps.length; i++) {
                path.push(steps[i]);
            }
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        var navigate = destination;

        map.addListener('click', function (e) {
            map.panTo(navigate);

            if (navigate == destination) {
                navigate = origin;
            }
            else {
                navigate = destination;
            }
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?= $GMAP_API_KEY ?>&callback=initMap&language=sk&region=SK&libraries=places"
        async defer>
</script>
