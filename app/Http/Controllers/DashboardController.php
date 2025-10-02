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

    public function penduduk()
    {
        $datang2024 = Penduduk::getDataByTable('datang2024');
        $datang2025 = Penduduk::getDataByTable('datang2025');
        $pindah2024 = Penduduk::getDataByTable('pindah2024');
        $pindah2025 = Penduduk::getDataByTable('pindah2025');
        
        return view('penduduk', compact('datang2024', 'datang2025', 'pindah2024', 'pindah2025'));
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
        Penduduk::insertData($table, [
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'tanggal_datang' => $request->tanggal_datang,
            'created_at' => now(),
            'updated_at' => now()
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
        Penduduk::insertData($table, [
            'nama' => $request->nama,
            'alamat_asal' => $request->alamat_asal,
            'alamat_tujuan' => $request->alamat_tujuan,
            'tanggal_pindah' => $request->tanggal_pindah,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Data penduduk pindah berhasil ditambahkan!');
    }
}
