<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Prodi;

class ProdiController extends Controller
{
    public function allJoinFacade()
    {
        $kampus = "Universitas Multi Data Palembang";
        $result = DB::select('select mahasiswas.* , prodis.name as nama_prodi from prodis, mahasiswas where prodis.id = mahasiswas.prodi_id');
        return view('prodi.index', ['allmahasiswaprodi' => $result, 'kampus' => $kampus]);
    }

    public function create()
    {
        return view('prodi.create');
    }

    public function store(Request $request, Prodi $prodi)
    {
        // echo $request->nama;
        $this->authorize('create', $prodi);

        $validateData = $request->validate([
            'name' => 'required|min:5|max:20',
            'foto' => 'required|file|image|max:10000',
        ]);
        // dump($validateData);
        // echo $validateData['nama'];
        $ext = $request->foto->getClientOriginalExtension();
        $nama_file = "foto-" . time() . "." . $ext;
        $path = $request->foto->storeAs('public', $nama_file);
        $prodi = new Prodi();
        $prodi->name = $validateData['name'];
        $prodi->foto = $nama_file;
        $prodi->save();

        session()->flash('info', "Data prodi $prodi->name berhasil disimpan ke database");

        return redirect('prodi/create');
    }

    public function index()
    {

        $prodis = Prodi::all();
        return view('prodi.index', ['prodis' => $prodis, 'kampus' => 'Universitas Multi Data Palembang']);
    }

    public function show(Prodi $prodi)
    {
        return view('prodi.show', ['prodi' => $prodi, 'kampus' => 'Universitas Multi Data Palembang']);
    }

    public function edit(Prodi $prodi)
    {

        $this->authorize('update', $prodi);

        return view('prodi.edit', ['prodi' => $prodi,]);
    }

    public function update(Request $request, Prodi $prodi)
    {
        $validateData = $request->validate([
            'name' => 'required|min:5|max:20',
        ]);

        Prodi::where('id', $prodi->id)->update($validateData);
        session()->flash('info', "Data prodi $prodi->name berhasil diubah");
        return redirect()->route('prodi.index');
    }

    public function destroy(Prodi $prodi)
    {
        $this->authorize('delete', $prodi);

        $prodi->delete();
        return redirect()->route('prodi.index')->with("info", "Prodi $prodi->name Berhasil Dihapus");
    }
}
