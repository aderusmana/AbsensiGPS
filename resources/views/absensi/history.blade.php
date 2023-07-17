@extends('layouts.masterlayout')

@section('header')
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">History Absensi</div>
        <div class="right"></div>
    </div>

@section('content')
    <div class="row" style="margin-top:70px">
        <div class="col">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <select name="bulan" id="bulan" class="form-control">
                            <option value="">Bulan</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value={{ $i }} {{ date('m') == $i ? 'selected' : '' }}>
                                    {{ $namaBulan[$i] }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <select name="tahun" id="tahun" class="form-control">
                            <option value="">Tahun</option>
                            @php
                                $tahunMulai = 2022;
                                $tahunSkrg = date('Y');
                            @endphp
                            @for ($tahun = $tahunMulai; $tahun <= $tahunSkrg; $tahun++)
                                <option value={{ $tahun }} {{ date('Y') == $tahun ? 'selected' : '' }}>
                                    {{ $tahun }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" id="getData">
                            <ion-icon name="search-outline"></ion-icon>Search
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col" id="showHistory"></div>
    </div>

@endsection

@push('myScript')
    <script>
        $(function() {
            $('#getData').click(function(e) {
                var bulan = $('#bulan').val()
                var tahun = $('#tahun').val()
                $.ajax({
                    type: "POST",
                    url: '/absensi/getHistory',
                    data: {
                        _token: "{{ csrf_token() }}",
                        bulan: bulan,
                        tahun: tahun,
                    },
                    cache: false,
                    success: function(respond) {
                        $('#showHistory').html(respond);
                    }
                });
            })
        })
    </script>
@endpush
