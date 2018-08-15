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
            <div class="ibox " style="height: 600px;">
                <div class="ibox-title">
                    <h5>Google Maps</h5>
                </div>
                <div class="ibox-content">
                    <div class="google-map" id="map" style="height: 600px;"></div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWpgFJDJJkgFS0XsgPZGlMChqkB1aafb4" type="text/javascript"></script>
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
                    $.post('{{ route('nearest.cities') }}', {
                        city_id: item.geonameid
                    }, function (obj) {
                        google.maps.event.addDomListener(window, 'load', initialize(obj));
                    }, 'json');
                    return item;
                }
            })
        });
        google.maps.event.addDomListener(window, 'load', initialize());
        function initialize(locations = []) {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: new google.maps.LatLng(55, 32),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            addMarker(locations, map);
        }

        function addMarker(locations, map) {
            var marker;
            for (var i = 0; i < locations.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i].latitude, locations[i].longtitude),
                    label: locations[i].name,
                    map: map
                });
            }
            if (locations[0] !== undefined) {
                map.panTo( new google.maps.LatLng( locations[0].latitude, locations[0].longtitude ) );
            }
        }

        </script>
@endsection