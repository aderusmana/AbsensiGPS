@if ($history->isEmpty())
    <div class="alert alert-warning">
        <p>Data Belum Ada</p>
    </div>
@endif
<ul class="listview image-listview">
    @foreach ($history as $h)
        <li>
            <div class="item">
                @php
                    $path = Storage::url('uploads/absensi/' . $h->foto_masuk);
                @endphp
                <img src="{{ url($path) }}" alt="" width="50px" height="50px">
                <div class="in ml-2">
                    <div>
                        <small><b>{{ $h->karyawan->nama_lengkap }}</b></small><br>
                        <small class="text-muted">{{ $h->tgl_absensi }}</small>
                    </div>
                    <div class="ml-2" style="display: flex;justify-content: space-between ">
                        <span class="text-white badge mr-1 {{ $h->jam_masuk < '07:00' ? 'bg-success' : 'bg-danger' }}">
                            {{ $h->jam_masuk }} </span>
                        <span class="text-white badge {{ $h->jam_keluar < '07:00' ? 'bg-success' : 'bg-danger' }}">
                            {{ $h->jam_keluar }} </span>
                    </div>
                </div>
            </div>
        </li>
    @endforeach
</ul>
