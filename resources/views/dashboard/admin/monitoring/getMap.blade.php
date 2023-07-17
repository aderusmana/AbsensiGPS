<style>
    #map {
        height: 250px;
    }
</style>
<div id="map"></div>


<script>
    var lokasi = "{{ $absensi->lokasi_masuk }}"
    var log = lokasi.split(",");
    var latitude = log[0]
    var longitude = log[1]
    var map = L.map('map').setView([latitude, longitude], 16);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    var marker = L.marker([latitude, longitude]).addTo(map);
    var circle = L.circle([-6.15641162761241, 106.86762039451382], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 50
    }).addTo(map);

    var popup = L.popup()
        .setLatLng([latitude, longitude])
        .setContent("Saya Disini {{ $absensi->karyawan->nama_lengkap }}.")
        .openOn(map);
</script>
