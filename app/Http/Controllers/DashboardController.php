<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penduduk;

class DashboardController extends Controller
{
    public function index()
    {
        $rekapitulasi = Penduduk::getRekapitulasi();
        return view('dashboard', compact('rekapitulasi'));
    }

    public function rekapitulasi()
    {
        $rekapitulasi = Penduduk::getRekapitulasi();
        return view('rekapitulasi', compact('rekapitulasi'));
    }

    public function penduduk(Request $request)
    {
        $search = $request->get('search');
        
        if ($search) {
            // Jika ada pencarian, filter berdasarkan nama
            $datang2024 = Penduduk::searchByName('datang2024', $search);
            $datang2025 = Penduduk::searchByName('datang2025', $search);
            $pindah2024 = Penduduk::searchByName('pindah2024', $search);
            $pindah2025 = Penduduk::searchByName('pindah2025', $search);
        } else {
            // Jika tidak ada pencarian, ambil data seperti biasa
            $datang2024 = Penduduk::getDataByTable('datang2024');
            $datang2025 = Penduduk::getDataByTable('datang2025');
            $pindah2024 = Penduduk::getDataByTable('pindah2024');
            $pindah2025 = Penduduk::getDataByTable('pindah2025');
        }
        
        return view('penduduk', compact('datang2024', 'datang2025', 'pindah2024', 'pindah2025', 'search'));
    }

    public function tambahDatang(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'tanggal_datang' => 'required|date',
            'tahun' => 'required|in:2024,2025'
        ]);

        $table = 'datang' . $request->tahun;
        
        // Sesuaikan dengan struktur tabel database test
        Penduduk::insertData($table, [
            'NAMA_LENGKAP' => $request->nama,
            'ALAMAT_TUJUAN' => $request->alamat,
            'TGL_DATANG' => $request->tanggal_datang,
        ]);

        return back()->with('success', 'Data penduduk datang berhasil ditambahkan!');
    }

    public function tambahPindah(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat_asal' => 'required',
            'alamat_tujuan' => 'required',
            'tanggal_pindah' => 'required|date',
            'tahun' => 'required|in:2024,2025'
        ]);

        $table = 'pindah' . $request->tahun;
        
        // Sesuaikan dengan struktur tabel database test
        Penduduk::insertData($table, [
            'NAMA_LENGKAP' => $request->nama,
            'ALAMAT_ASAL' => $request->alamat_asal,
            'ALAMAT_TUJUAN' => $request->alamat_tujuan,
            'TGL_PINDAH' => $request->tanggal_pindah,
        ]);

        return back()->with('success', 'Data penduduk pindah berhasil ditambahkan!');
    }
}
