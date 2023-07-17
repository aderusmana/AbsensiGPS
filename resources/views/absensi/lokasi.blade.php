@extends('layouts.masterlayout')

@section('header')
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Lokasi</div>
        <div class="right"></div>
    </div>




@section('content')
    <style>
        #map {
            height: 610px;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <div class="row" style="margin-top: 60px">
        <div class="col">
            <input type="hidden" name="lokasi" id="lokasi">
        </div>
    </div>
    <div class="row mt-7">
        <div class="col">
            <div id="map"></div>
        </div>
    </div>

@endsection

@push('myScript')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        var lokasi = document.getElementById('lokasi');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallBack, errorCallback);
        }

        function successCallBack(position) {
            lokasi.value = position.coords.latitude + "," + position.coords.longitude;
            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 17);
            var lokasi_kantor = "{{ $lokasi->lokasi_kantor }}";
            var lok = lokasi_kantor.split(",");
            // alert(lok);
            var lang_kantor = lok[0];
            var long_kantor = lok[1];
            var radius = "{{ $lokasi->radius }}";
            L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(map);
            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);

            // diisi dengan titik koordinat kantor
            var circle = L.circle([lang_kantor, long_kantor], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: radius
            }).addTo(map);


        }

        function errorCallback() {

        }
    </script>
    <script type="text/javascript">
        window.onload = function() {
            jam();
        }

        function jam() {
            var e = document.getElementById('jam'),
                d = new Date(),
                h, m, s;
            h = d.getHours();
            m = set(d.getMinutes());
            s = set(d.getSeconds());

            e.innerHTML = h + ':' + m + ':' + s;

            setTimeout('jam()', 1000);
        }

        function set(e) {
            e = e < 10 ? '0' + e : e;
            return e;
        }
    </script>
@endpush
