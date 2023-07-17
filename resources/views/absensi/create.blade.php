@extends('layouts.masterlayout')

@section('header')
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Absensi</div>
        <div class="right"></div>
    </div>




@section('content')
    <style>
        .webcam,
        .webcam video {
            display: inline-block;
            width: 100% !important;
            height: 100% !important;
            margin: auto;
            border-radius: 15px
        }

        #map {
            height: 350px;
        }

        .jam-digital {

            background-color: #27272783;
            position: absolute;
            top: 65px;
            right: 5px;
            z-index: 9999;
            width: 150px;
            border-radius: 10px;
            padding: 5px;
        }



        .jam-digital p {
            color: #fff;
            font-size: 10px;
            text-align: justify;
            margin-top: 0.5;
            margin-bottom: 0;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <div class="row" style="margin-top: 60px">
        <div class="col">
            <input type="hidden" name="lokasi" id="lokasi">
            <div class="webcam"></div>
        </div>
    </div>

    <div class="jam-digital">
        <p>{{ date('d-m-Y') }}</p>
        <p id="jam"></p>
        <p>{{ $jamKerja->nama_jamKerja }}</p>
        <p>Awal Masuk : {{ date('H:i', strtotime($jamKerja->awal_jamMasuk)) }}</p>
        <p>Masuk : {{ date('H:i', strtotime($jamKerja->set_jamMasuk)) }}</p>
        <p>Akhir Absen Masuk : {{ date('H:i', strtotime($jamKerja->akhir_jamMasuk)) }}</p>
        <p>Jam Pulang : {{ date('H:i', strtotime($jamKerja->set_jamPulang)) }}</p>

    </div>

    <div class="row">
        @if ($cek > 0)
            <div class="col mt-2">
                <button id="takeAbsen" class="btn btn-danger btn-block">
                    <ion-icon name="camera"></ion-icon> Absen Pulang
                </button>
            </div>
        @else
            <div class="col mt-2">
                <button id="takeAbsen" class="btn btn-primary btn-block">
                    <ion-icon name="camera"></ion-icon> Absen Masuk
                </button>
            </div>
        @endif
    </div>
    <div class="row mt-7">
        <div class="col">
            <div id="map"></div>
        </div>
    </div>
    <audio id="notifMasuk">
        <source src="{{ asset('assets/songs/masuk.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="notifKeluar">
        <source src="{{ asset('assets/songs/keluar.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="notifRadius">
        <source src="{{ asset('assets/songs/radius.mp3') }}" type="audio/mpeg">
    </audio>

@endsection

@push('myScript')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        var notifMasuk = document.getElementById('notifMasuk');
        var notifKeluar = document.getElementById('notifKeluar');
        var notifRadius = document.getElementById('notifRadius');
        Webcam.set({
            width: 480,
            height: 720,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
        Webcam.attach('.webcam');

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

        $('#takeAbsen').click(function() {
            Webcam.snap(function(uri) {
                image = uri;
            })
            var lokasi = $('#lokasi').val();
            $.ajax({
                type: 'POST',
                url: '/absensi/store',
                data: {
                    _token: "{{ csrf_token() }}",
                    image: image,
                    lokasi: lokasi
                },
                cache: false,
                success: function(respond) {
                    var status = respond.split("|")
                    if (status[0] == "success") {
                        if (status[2] == "masuk") {
                            notifMasuk.play();
                        } else {
                            notifKeluar.play();
                        }
                        Swal.fire({
                            title: 'Success!',
                            text: status[1],
                            icon: 'success',
                        })
                        setTimeout("location.href='/dashboard'", 3000);
                    } else {
                        if (status[2] == "radius") {
                            notifRadius.play();
                        }
                        Swal.fire({
                            title: 'Error!',
                            text: status[1],
                            icon: 'error',
                        })
                        setTimeout("location.href='/absensi/create'", 5000);
                    }
                }
            })
        })
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
