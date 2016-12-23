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
            var granularity = 10;       // v m (metroch)
            var offset = 0;
            var initLength = initPath.length;
            for (var i = 0; i < initLength - 1; i++) {
                offset += generateInterpolationPath(initPath, i + offset, granularity);
            }
        }


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

        @foreach($runners as $runner)
            var runnerMarker_{{ $runner->id }} = new google.maps.Marker({
                map: map,
                icon: "/uploads/map_avatars/{{ Auth::user()->avatar }}",
            });
        @endforeach

        function updateRoute(directionsResult) {
            var steps = directionsResult.routes[0].overview_path;

            var path = [];

            for (var i = 0; i < steps.length; i++) {
                path.push(steps[i]);
            }

            setGeoPath(path);

            @foreach($runners as $runner)
                var progress = Math.floor((path.length - 1) * Number( {{ min($runner->total_distance, $runningPlan->distance_value) / $runningPlan->distance_value }} ));
                var pos_{{ $runner->id }} = path[progress];
                runnerMarker_{{ $runner->id }}.setPosition(pos_{{ $runner->id }});

                $(document).ready(function() {
                    $(".js__runner-box--{{ $runner->id }}").click(function () {
                        map.panTo(pos_{{ $runner->id }});
                    });
                });
            @endforeach
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
