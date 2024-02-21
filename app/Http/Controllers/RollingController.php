<?php

namespace App\Http\Controllers;

use App\Models\Warung;
use App\Models\Setting;
use Illuminate\Http\Request;
use PDF;

class RollingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allData = Warung::all();
        return view('rolling.index', compact('allData'));
    }

    public function data()
    {
        $warung = Warung::orderBy('kode_warung')->get();

        return datatables()
            ->of($warung)
            ->addIndexColumn()
            ->addColumn('select_all', function ($produk) {
                return '
                    <input type="checkbox" name="id_warung[]" value="' . $produk->id_warung . '">
                ';
            })
            ->addColumn('kode_warung', function ($warung) {
                return '<span class="label label-success">' . $warung->kode_warung . '<span>';
            })
            ->addColumn('aksi', function ($warung) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`' . route('warung.update', $warung->id_warung) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button type="button" onclick="deleteData(`' . route('warung.destroy', $warung->id_warung) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'select_all', 'kode_warung'])
            ->make(true);
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
        $warung = Warung::latest()->first() ?? new Warung();
        $kode_warung = (int) $warung->kode_warung + 1;

        $warung = new Warung();
        $warung->kode_warung = tambah_nol_didepan($kode_warung, 5);
        $warung->nama = $request->nama;
        $warung->telepon = $request->telepon;
        $warung->alamat = $request->alamat;
        $warung->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $warung = Warung::find($id);

        return response()->json($warung);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $warung = Warung::find($id)->update($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $warung = Warung::find($id);
        $warung->delete();

        return response(null, 204);
    }

    // public function cetakMember(Request $request)
    // {
    //     $datamember = collect(array());
    //     foreach ($request->id_member as $id) {
    //         $member = Member::find($id);
    //         $datamember[] = $member;
    //     }

    //     $datamember = $datamember->chunk(2);
    //     $setting    = Setting::first();

    //     $no  = 1;
    //     $pdf = PDF::loadView('member.cetak', compact('datamember', 'no', 'setting'));
    //     $pdf->setPaper(array(0, 0, 566.93, 850.39), 'potrait');
    //     return $pdf->stream('member.pdf');
    // }
}