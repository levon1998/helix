@extends('layouts.user.app')

@section('title')

@endsection

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Search City</h5>
        </div>
        <div class="ibox-content">
            <input type="text" placeholder="Type Something..." class="typeahead form-control" id="autocomplate_search"/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Google Maps</h5>
                </div>
                <div class="ibox-content">
                    <div class="google-map" id="map"></div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAbLElcpD0p-DrD_XEDWv0RsCdicd2HiUk" type="text/javascript"></script>
    <script src="{{asset('js/plugins/typehead/bootstrap3-typeahead.min.js')}}"></script>
    <script type="text/javascript">

        $(document).ready(function(){
            var inputField = $('#autocomplate_search');
            var query = inputField.val();
            $('.typeahead').typeahead({
                source: function (query, process) {
                   return $.post('{{ route('search') }}', {
                       word: query
                   }, function (obj) {
                       return process(obj);
                   }, 'json');
                },
                updater: function(item) {
                    return $.post('{{ route('nearest.cities') }}', {
                        city_id: item.geonameid
                    }, function (obj) {
                        console.log(obj);
                    }, 'json');
                    return item;
                }
            })
        });
        // When the window has finished loading google map
        google.maps.event.addDomListener(window, 'load', init);

        function init() {
            // Options for Google map
            // More info see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions

            var mapElement = document.getElementById('map');
            var mapOptions = {
                zoom: 11,
                center: new google.maps.LatLng(40.6700, -73.9400),
                // Style for Google Maps
                styles: [{"featureType":"water","stylers":[{"saturation":43},{"lightness":-11},{"hue":"#0088ff"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"hue":"#ff0000"},{"saturation":-100},{"lightness":99}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"color":"#808080"},{"lightness":54}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ece2d9"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#ccdca1"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#767676"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#b8cb93"}]},{"featureType":"poi.park","stylers":[{"visibility":"on"}]},{"featureType":"poi.sports_complex","stylers":[{"visibility":"on"}]},{"featureType":"poi.medical","stylers":[{"visibility":"on"}]},{"featureType":"poi.business","stylers":[{"visibility":"simplified"}]}]
            };

            var map = new google.maps.Map(mapElement, mapOptions);
        }

        </script>
@endsection