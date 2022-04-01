<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Datatables;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = Barang::all();
        if(request()->ajax()) {
            return Datatables()->of($barang)
            ->addColumn('action', 'barang-action')
            ->addColumn('image', function ($barang) {
                $url= asset('storage/images/'.$barang->foto);
                return '<img src="'.$url.'" border="0" width="40" class="img-rounded" align="center" />';
            })
            ->rawColumns(['action', 'image'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('barangs');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'foto'     => 'required|image|mimes:png,jpg,jpeg|max:100',
        ]);

        //upload image
        $image = $request->file('foto');
        $image->storeAs('public/images', $image->hashName());

        $barangId = $request->id;

        $barang = Barang::updateOrCreate(['id' => $barangId],
            [
                'foto' => $image->hashName(),
                'nama' => $request->nama,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'stok' => $request->stok
            ]);

            return Response()->json($barang);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $barang = Barang::where($where)->first();

        return response()->json($barang);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Barang $barang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $barang = Barang::where('id', $request->id)->delete();

        return response()->json($barang);
    }
}
