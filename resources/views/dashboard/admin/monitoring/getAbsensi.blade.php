@php
    function selisih($jam_masuk, $jam_keluar)
    {
        [$h, $m, $s] = explode(':', $jam_masuk);
        $dtAwal = mktime($h, $m, $s, '1', '1', '1');
        [$h, $m, $s] = explode(':', $jam_keluar);
        $dtAkhir = mktime($h, $m, $s, '1', '1', '1');
        $dtSelisih = $dtAkhir - $dtAwal;
        $totalmenit = $dtSelisih / 60;
        $jam = explode('.', $totalmenit / 60);
        $sisamenit = $totalmenit / 60 - $jam[0];
        $sisamenit2 = $sisamenit * 60;
        $jml_jam = $jam[0];
        return $jml_jam . ':' . round($sisamenit2);
    }
@endphp

@foreach ($absensi as $absen)
    @php
        $pathMasuk = Storage::url('uploads/absensi/' . $absen->foto_masuk);
        $pathKeluar = Storage::url('uploads/absensi/' . $absen->foto_keluar);
    @endphp
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $absen->nik }}</td>
        <td>{{ $absen->nama_lengkap }}</td>
        <td>{{ $absen->nama_department }}</td>
        <td><small>
                {{ $absen->nama_jamKerja }} <br> ( {{ $absen->akhir_jamMasuk }} - {{ $absen->set_jamPulang }})
            </small>
        </td>
        <td>
            <span class="badge badge-outline text-blue text-center">{{ $absen->akhir_jamMasuk }}</span>
        </td>
        <td><img src="{{ url($pathMasuk) }}" alt="" class="avatar"></td>
        <td><span
                class="badge badge-outline text-red">{{ $absen->jam_keluar != null ? $absen->jam_keluar : 'Belum Absen Pulang' }}</span>
        </td>

        <td>
            @if ($absen->jam_keluar != null)
                <img src="{{ url($pathKeluar) }}" alt="" class="avatar">
            @else
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-hourglass-high text-warning"
                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M6.5 7h11"></path>
                    <path d="M6 20v-2a6 6 0 1 1 12 0v2a1 1 0 0 1 -1 1h-10a1 1 0 0 1 -1 -1z"></path>
                    <path d="M6 4v2a6 6 0 1 0 12 0v-2a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1z"></path>
                </svg>
        </td>
@endif
<td>
    @if ($absen->jam_masuk >= $absen->akhir_jamMasuk)
        @php
            $jam_terlambat = selisih($absen->akhir_jamMasuk, $absen->jam_masuk);
        @endphp
        <span class="badge bg-red">Terlambat - {{ $jam_terlambat }}</span>
    @else
        <span class="badge bg-green">Tepat Waktu</span>
    @endif
</td>
<td>
    <a href="#" class="btn btn-primary map" id="{{ $absen->id }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-2" width="24" height="24"
            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
            stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5"></path>
            <path d="M9 4v13"></path>
            <path d="M15 7v5.5"></path>
            <path
                d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z">
            </path>
            <path d="M19 18v.01"></path>
        </svg>
    </a>
</td>

</tr>
@endforeach


<script>
    $(function() {
        $(".map").click(function(e) {
            var id = $(this).attr("id")
            $.ajax({
                type: "POST",
                url: "/admin/getMap",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                cache: false,
                success: function(respond) {
                    $("#loadMap").html(respond)
                }
            })
            $("#modal-map").modal("show");
        });
    });
</script>
