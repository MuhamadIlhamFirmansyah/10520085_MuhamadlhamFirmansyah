<?php

namespace App\Http\Controllers;

use App\models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function buat(){
        return view ('pelanggan.isi');
    }
    public function index(Request $request)
    {
        $q = $request->get('q');

        $data['result'] = Pelanggan::where(function($query) use ($q){
            $query->Where('nama_lengkap', 'like', '%' . $q . '%');
            $query->orWhere('jenis_kelamin', 'like', '%' . $q . '%');
            $query->Where('nomor_hp', 'like', '%' . $q . '%');
            $query->Where('alamat', 'like', '%' . $q . '%');
            $query->Where('email', 'like', '%' . $q . '%');
    })->paginate();

    $data['q'] = $q;
    return view('pelanggan.list', $data);
}
public function create()
{
    return view('pelanggan.form');
}
public function show()
{
    return view('pelanggan.show');
}

public function store(Request $request, Pelanggan $pelanggan = null){

    $rules = [
        'nama_lengkap' => 'required',
        'jenis_kelamin' => 'required',
        'nomor_hp' => 'required',
        'alamat' => 'required',
        'email' => 'required'
    ];
    $this->validate($request, $rules);

    Pelanggan::updateOrCreate(['id' => @$pelanggan->id], $request->all());

    return redirect('/pelanggan')->with('success', 'DATA BERHASIL DI SIMPAN!!');
}

public function edit(Pelanggan $pelanggan)
{
    return view('pelanggan.form', compact('pelanggan'));
}

public function destroy(Pelanggan $pelanggan)
{
    $pelanggan->delete();
    return redirect('/pelanggan')->with('succes', 'DATA BERHASIL DIHAPUS');
}
}