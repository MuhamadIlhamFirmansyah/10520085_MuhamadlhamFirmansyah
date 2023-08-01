<?php

namespace App\Http\Controllers;

use App\models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
public function index(Request $request)
{
    $q = $request->get('q');

    $data['result'] = Produk::where(function($query)use($q){
        $query->where('kategori_produk', 'like', '%' . $q . '%');
        $query->orWhere('nama_produk', 'like', '%' . $q . '%');
        $query->orWhere('stok', 'like', '%' . $q . '%');
        $query->orWhere('kategori_produk', 'like', '%' . $q . '%');
    })->paginate();

    $data['q'] = $q;
    return view('produk.list', $data);
}
public function create()
{
    return view('produk.form');
}
public function show()
{
    return view('produk.show');
}

public function store(Request $request, Produk $produk = null){

    $rules = [
        'kategori_produk' => 'required',
        'harga_produk' => 'required|numeric|min:1000',
    ];

    if($request->hasFile('foto_produk')) {
        $rules['foto_produk'] = 'required|mimes:jpg|max:1024';
    }

    $this->validate($request, $rules);

    $input = $request->all();

    if($request->hasFile('foto_produk')) {
        $fileName = $request->foto_produk->getClientOriginalName();
        $request->foto_produk->storeAs('produk', $fileName);
        $input['foto_produk'] = $fileName;
    }

    Produk::updateOrCreate(['id' => @$produk->id], $input);
    return redirect('/produk')->with('success', 'DATA BERHASIL DI SIMPAN!!');
}

public function edit(produk $produk)
{
    return view('produk.form', compact('produk'));
}

public function destroy(Produk $produk)
{
    $produk->delete();
    return redirect('/produk')->with('succes', 'DATA BERHASIL DIHAPUS');
}
}