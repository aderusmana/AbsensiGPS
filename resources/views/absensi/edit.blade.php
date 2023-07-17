@extends('layouts.masterlayout')

@section('header')
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Edit Profile</div>
        <div class="right"></div>
    </div>



@section('content')
    <form action="/absensi/{{ $karyawan->id }}/updateprofile" method="POST" enctype="multipart/form-data"
        style="margin-top:5rem">
        @csrf

        @if (session('error'))
            <div class="alert alert-outline alert-danger">
                <p>{{ session('error') }}</p>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-outline alert-success">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        <div class="col">
            <div class="form-group boxed">
                <div class="input-wrapper">
                    <input type="text" class="form-control" value="{{ $karyawan->nama_lengkap }}" name="nama_lengkap"
                        placeholder="Nama Lengkap" autocomplete="off">
                </div>
            </div>
            <div class="form-group boxed">
                <div class="input-wrapper">
                    <input type="number" class="form-control" value="{{ $karyawan->no_telp }}" name="no_telp"
                        placeholder="No. HP" autocomplete="off">
                </div>
            </div>
            <div class="form-group boxed">
                <div class="input-wrapper">
                    <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off">
                </div>
            </div>
            <div class="custom-file-upload" id="fileUpload1">
                <input type="file" name="avatar" id="fileuploadInput" accept=".png, .jpg, .jpeg">
                <label for="fileuploadInput">
                    <span>
                        <strong>
                            <ion-icon name="cloud-upload-outline" role="img" class="md hydrated"
                                aria-label="cloud upload outline"></ion-icon>
                            <i>Tap to Upload</i>
                        </strong>
                    </span>
                </label>
            </div>
            <div class="form-group boxed">
                <div class="input-wrapper">
                    <button type="submit" class="btn btn-primary btn-block">
                        <ion-icon name="refresh-outline"></ion-icon>
                        Update
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection
