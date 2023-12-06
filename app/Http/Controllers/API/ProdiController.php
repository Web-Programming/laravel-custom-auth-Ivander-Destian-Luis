<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;

class ProdiController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prodis = Prodi::all();
        return $this->sendResponse($prodis, "Data Prodi");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = $request->validate([
            'name' => 'required|min:5|max:20',
            'foto' => 'required|file|image|max:5000'
        ]);

        $ext = $request->foto->getClientOriginalExtension();
        $nama_file = "foto-" . time() . "." . $ext;
        $path = $request->foto->storeAs('public', $nama_file);

        $prodi = new Prodi();
        $prodi->name = $validasi['name'];
        $prodi->foto = $nama_file;

        if ($prodi->save()) {
            $success['data'] = $prodi;
            return $this->sendResponse($success, 'Data prodi berhasil disimpan');
        } else {
            return $this->sendError('Error', ['error' => 'Data prodi gagal disimpan']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $prodis = Prodi::all();
        return $this->sendResponse($prodis, "Data Prodi");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validasi = $request->validate([
            'name' => 'required|min:5|max:20',
        ]);


        $prodi = Prodi::find($id);
        $prodi->name = $validasi['name'];

        if ($prodi->save()) {
            $success['data'] = $prodi;
            return $this->sendResponse($success, 'Data prodi berhasil diperbarui');
        } else {
            return $this->sendError('Error', ['error' => 'Data prodi gagal diperbarui']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prodi = Prodi::findOrFail($id);
        if ($prodi->delete()) {
            $success['data'] = [];
            return $this->sendResponse($success, "Data prodi dengan $id berhasil dihapus");
        } else {
            return $this->sendError('Error', ['error' => 'Data prodi gagal dihapus']);
        }
    }
}
