<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Cabang;
use App\Models\JamById;
use App\Models\JamsById;
use App\Models\Karyawan;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    public function getHari()
    {
        $hari = date('D');
        $namaHari = '';

        switch ($hari) {
            case 'Sun':
                $namaHari = "Minggu";
                break;
            case 'Mon':
                $namaHari = "Senin";
                break;
            case 'Tue':
                $namaHari = "Selasa";
                break;
            case 'Wed':
                $namaHari = "Rabu";
                break;
            case 'Thu':
                $namaHari = "Kamis";
                break;
            case 'Fri':
                $namaHari = "Jumat";
                break;
            case 'Sat':
                $namaHari = "Sabtu";
                break;
            default:
                $namaHari = "Tidak Diketahui";
                break;
        }

        return $namaHari;
    }

    public function create()
    {
        $hariIni = date('Y-m-d');
        $karyawan = Auth::guard('karyawan')->user();
        $cek = Absensi::where('tgl_absensi', $hariIni)->where('karyawan_id', $karyawan->id)->count();
        $lokasi = Cabang::find($karyawan->cabang_id);
        $jamKerja = JamsById::where('karyawan_id', $karyawan->id)
            ->join('jams', 'jams_by_ids.jam_id', '=', 'jams.id')
            ->where('hari', $this->getHari())
            ->first();

        return view('absensi.create', compact('cek', 'lokasi', 'jamKerja'));
    }


    public function store(Request $request)
    {
        $karyawan = Auth::guard('karyawan')->user();
        $nik = $karyawan->nik;
        $tglAbsensi = date("Y-m-d");
        $jam = date("H:i:s");

        $lokasiKantor = Cabang::find($karyawan->cabang_id);
        [$latitudeKantor, $longitudeKantor] = explode(",", $lokasiKantor->lokasi_kantor);

        $lokasi = $request->lokasi;
        [$latitudeUser, $longitudeUser] = explode(",", $lokasi);
        $jarak = $this->distance($latitudeKantor, $longitudeKantor, $latitudeUser, $longitudeUser);
        $radius = round($jarak['meters']);

        $namaHari = $this->getHari();
        $jamKerja = JamsById::where('karyawan_id', $karyawan->id)
            ->join('jams', 'jams_by_ids.jam_id', '=', 'jams.id')
            ->where('hari', $namaHari)->first();

        $cek = Absensi::where('tgl_absensi', $tglAbsensi)->where('karyawan_id', $karyawan->id)->count();
        $ket = ($cek > 0) ? "keluar" : "masuk";

        $image = $request->image;
        $folderPath = "public/uploads/absensi/";
        $formatName = $nik . "-" . $tglAbsensi . "-" . $ket;
        [$imageType, $imageData] = explode(";base64,", $image);
        $file = $folderPath . $formatName . ".png";

        if ($radius > $lokasiKantor->radius) {
            echo "error|Maaf, Anda berada di luar radius kantor. Jarak Anda " . $radius . " meter dari kantor|radius";
        } else {
            if ($cek > 0) {
                if ($jam < $jamKerja->set_jamPulang) {
                    echo "Error | Maaf, belum waktunya pulang |masuk";
                } else {
                    $dataPulang = [
                        'jam_keluar' => $jam,
                        'foto_keluar' => $formatName . ".png",
                        'lokasi_keluar' => $lokasi,
                    ];
                    $update = Absensi::where('tgl_absensi', $tglAbsensi)->where('karyawan_id', $karyawan->id)->update($dataPulang);
                    if ($update) {
                        echo "success|Terima Kasih, Hati-hati di jalan|keluar";
                        Storage::put($file, base64_decode($imageData));
                    } else {
                        echo 1;
                    }
                }
            } else {
                if ($jam < $jamKerja->awal_jamMasuk) {
                    echo "Error | Maaf, belum waktunya melakukan absensi |masuk";
                } elseif ($jam > $jamKerja->akhir_jamMasuk) {
                    echo "Error | Maaf, Anda sudah melewati batas waktu absensi |masuk";
                } else {
                    $dataMasuk = [
                        'karyawan_id' => $karyawan->id,
                        'jam_id' => $jamKerja->jam_id,
                        'tgl_absensi' => $tglAbsensi,
                        'jam_masuk' => $jam,
                        'foto_masuk' => $formatName . ".png",
                        'lokasi_masuk' => $lokasi,
                    ];
                    $simpan = Absensi::create($dataMasuk);
                    if ($simpan) {
                        echo "success|Absensi berhasil, Selamat bekerja|masuk";
                        Storage::put($file, base64_decode($imageData));
                    } else {
                        echo "Error | Maaf, gagal melakukan absensi, silahkan hubungi tim IT |masuk";
                    }
                }
            }
        }
    }

    // Menghitung Jarak
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;

        return compact('meters');
    }


    public function edit()
    {
        $karyawanId = Auth::guard('karyawan')->user()->id;
        $karyawan = Karyawan::where('id', $karyawanId)->first();
        return view('absensi.edit', compact('karyawan'));
    }

    public function update(Request $request)
    {

        $karyawan = Auth::guard('karyawan')->user();
        $karyawanId = $karyawan->id;
        $nik = $karyawan->nik;
        $namaLengkap = $request->nama_lengkap;
        $noTelp = $request->no_telp;
        $password = $request->password ? Hash::make($request->password) : $karyawan->password;
        $avatar = $request->hasFile('avatar') ? $nik . "." . $request->file('avatar')->getClientOriginalExtension() : $karyawan->avatar;

        $data = [
            'nama_lengkap' => $namaLengkap,
            'no_telp' => $noTelp,
            'password' => $password,
            'avatar' => $avatar
        ];

        $update = Karyawan::where('id', $karyawanId)->update($data);
        if ($update) {
            if ($request->hasFile('avatar')) {
                $folderPath = "public/uploads/karyawan/";
                $request->file('avatar')->storeAs($folderPath, $avatar);
            }
            return Redirect::back()->with('success', 'Data Profile berhasil diupdate');
        } else {
            return Redirect::back()->with('error', "Data profile gagal diupdate, cek kembali");
        }
    }


    public function history()
    {
        $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('absensi.history', compact('namaBulan'));
    }

    public function getHistory(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $karyawanId = Auth::guard('karyawan')->user()->id;
        $history = Absensi::whereRaw('MONTH(tgl_absensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_absensi)="' . $tahun . '"')
            ->where('karyawan_id', $karyawanId)->orderBy('tgl_absensi')->get();

        return view('absensi.getHistory', compact('history'));
    }

    public function monitoring()
    {
        $absensi = Absensi::all();
        return view('dashboard.admin.monitoring.index', compact('absensi'));
    }

    public function getAbsensi(Request $request)
    {
        $tanggal = $request->tanggal;
        $absensi = DB::table('absensis')
            ->select('absensis.*', 'nik', 'nama_lengkap', 'nama_department', 'akhir_jamMasuk', 'nama_jamKerja', 'set_jamPulang')
            ->join('karyawans', 'absensis.karyawan_id', '=', 'karyawans.id')
            ->join('jams', 'absensis.jam_id', '=', 'jams.id')
            ->join('departments', 'karyawans.department_id', '=', 'departments.id')
            ->where('tgl_absensi', $tanggal)
            ->get();

        return view('dashboard.admin.monitoring.getAbsensi', compact('absensi'));
    }

    public function getMap(Request $request)
    {
        $id = $request->id;
        $absensi = Absensi::where('id', $id)->first();

        return view('dashboard.admin.monitoring.getMap', compact('absensi'));
    }

    public function laporanAbsensi()

    {
        $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $karyawan = Karyawan::orderBy("nama_lengkap")->get();
        return view('dashboard.admin.laporan.laporanabsensi', compact('namaBulan', 'karyawan'));
    }
    public function cetakLaporan(Request $request)
    {
        $karyawanId = $request->id;
        $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $karyawan = Karyawan::with('department')->where('id', $karyawanId)->first();
        $absensi = Absensi::where('karyawan_id', $karyawanId)
            ->join('jams', 'absensis.jam_id', '=', 'jams.id')
            ->whereRaw('MONTH(tgl_absensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_absensi)="' . $tahun . '"')
            ->orderBy('tgl_absensi')
            ->get();


        return view('dashboard.admin.laporan.cetakLaporan', compact('namaBulan', 'tahun', 'bulan', 'karyawan', 'absensi'));
    }

    public function rekapAbsensi()
    {
        $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        return view('dashboard.admin.laporan.rekapAbsensi', compact('namaBulan',));
    }

    public function cetakRekap(Request $request)
    {
        $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $rekap = DB::table('absensis')
            ->selectRaw('absensis.karyawan_id,nik,nama_lengkap,akhir_jamMasuk,set_jamPulang,
        MAX(IF(DAY(tgl_absensi) = 1,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_1,
        MAX(IF(DAY(tgl_absensi) = 2,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_2,
        MAX(IF(DAY(tgl_absensi) = 3,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_3,
        MAX(IF(DAY(tgl_absensi) = 4,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_4,
        MAX(IF(DAY(tgl_absensi) = 5,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_5,
        MAX(IF(DAY(tgl_absensi) = 6,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_6,
        MAX(IF(DAY(tgl_absensi) = 7,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_7,
        MAX(IF(DAY(tgl_absensi) = 8,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_8,
        MAX(IF(DAY(tgl_absensi) = 9,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_9,
        MAX(IF(DAY(tgl_absensi) = 10,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_10,
        MAX(IF(DAY(tgl_absensi) = 11,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_11,
        MAX(IF(DAY(tgl_absensi) = 12,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_12,
        MAX(IF(DAY(tgl_absensi) = 13,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_13,
        MAX(IF(DAY(tgl_absensi) = 14,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_14,
        MAX(IF(DAY(tgl_absensi) = 15,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_15,
        MAX(IF(DAY(tgl_absensi) = 16,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_16,
        MAX(IF(DAY(tgl_absensi) = 17,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_17,
        MAX(IF(DAY(tgl_absensi) = 18,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_18,
        MAX(IF(DAY(tgl_absensi) = 19,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_19,
        MAX(IF(DAY(tgl_absensi) = 20,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_20,
        MAX(IF(DAY(tgl_absensi) = 21,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_21,
        MAX(IF(DAY(tgl_absensi) = 22,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_22,
        MAX(IF(DAY(tgl_absensi) = 23,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_23,
        MAX(IF(DAY(tgl_absensi) = 24,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_24,
        MAX(IF(DAY(tgl_absensi) = 25,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_25,
        MAX(IF(DAY(tgl_absensi) = 26,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_26,
        MAX(IF(DAY(tgl_absensi) = 27,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_27,
        MAX(IF(DAY(tgl_absensi) = 28,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_28,
        MAX(IF(DAY(tgl_absensi) = 29,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_29,
        MAX(IF(DAY(tgl_absensi) = 30,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_30,
        MAX(IF(DAY(tgl_absensi) = 31,CONCAT(jam_masuk,"-",IFNULL(jam_keluar,"00:00:00")),"")) as tgl_31')
            ->join('karyawans', 'absensis.karyawan_id', '=', 'karyawans.id')
            ->join('jams', 'absensis.jam_id', '=', 'jams.id')
            ->whereRaw('MONTH(tgl_absensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_absensi)="' . $tahun . '"')
            ->groupByRaw('absensis.karyawan_id,nama_lengkap,akhir_jamMasuk,set_jamPulang')
            ->get();

        if (isset($_POST['exportExcel'])) {
            $time = date('d-M-Y H:i:s');
            // Fungsi header dengan mengirimkan raw data excel
            header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            // Mendefinisikan nama file export "hasil-export.xls"
            header("Content-Disposition: attachment; filename=Rekap Absensi Karyawan $time.xls");
        }

        return view('dashboard.admin.laporan.cetakRekap', compact('namaBulan', 'tahun', 'bulan', 'rekap'));
    }

    public function lokasi()
    {
        $hariIni = date('Y-m-d');
        $karyawan = Auth::guard('karyawan')->user();
        $cek = Absensi::where('tgl_absensi', $hariIni)->where('karyawan_id', $karyawan->id)->count();
        $lokasi = Cabang::find($karyawan->cabang_id);
        $jamKerja = JamsById::where('karyawan_id', $karyawan->id)
            ->join('jams', 'jams_by_ids.jam_id', '=', 'jams.id')
            ->where('hari', $this->getHari())
            ->first();

        return view('absensi.lokasi', compact('cek', 'lokasi', 'jamKerja'));
    }
}
