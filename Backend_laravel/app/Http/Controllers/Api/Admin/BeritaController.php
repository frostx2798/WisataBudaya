<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Berita;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\BeritaResource;
use Illuminate\Support\Facades\Validator;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get beritas
        $beritas = Berita::when(request()->q, function($beritas) {
            $beritas = $beritas->where('judul', 'like', '%'. request()->q . '%');
        })->latest()->paginate(5);
        
        //return with Api Resource
        return new BeritaResource(true, 'List Data beritas', $beritas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul'         => 'required',
            'isi'           => 'required',
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:8000',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/beritas', $image->hashName());

        //create Berita
        $berita = Berita::create([
            'judul'         => $request->judul,
            'slug'          => Str::slug($request->judul, '-'),
            'user_id'       => auth()->guard('api')->user()->id,
            'isi'           => $request->isi,
            'image'         => $image->hashName(),
        ]);

        if($berita) {
            //return success with Api Resource
            return new BeritaResource(true, 'Data Berita Berhasil Disimpan!', $berita);
        }

        //return failed with Api Resource
        return new BeritaResource(false, 'Data Berita Gagal Disimpan!', null);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $berita = Berita::whereId($id)->first();
        
        if($berita) {
            //return success with Api Resource
            return new BeritaResource(true, 'Detail Data Berita!', $berita);
        }

        //return failed with Api Resource
        return new BeritaResource(false, 'Detail Data Berita Tidak Ditemukan!', null);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Berita $berita)
    {
        $validator = Validator::make($request->all(), [
            'judul'         => 'required',
            'isi'           => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        //check image update
        if ($request->file('image')) {

            //remove old image
            Storage::disk('local')->delete('public/beritas/'.basename($berita->image));
        
            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/beritas', $image->hashName());

            //update Berita with new image
            $berita->update([
                'judul' => $request->judul,
                'slug'  => Str::slug($request->judul, '-'),
                'isi'   => $request->isi,
                'image' => $image->hashName(),
            ]);

        }

        //update Berita without image
        $berita->update([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul, '-'),
            'isi' => $request->isi,
        ]);

        if($berita) {
            //return success with Api Resource
            return new BeritaResource(true, 'Data Berita Berhasil Diupdate!', $berita);
        }

        //return failed with Api Resource
        return new BeritaResource(false, 'Data Berita Gagal Diupdate!', null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Berita $berita)
    {
        //remove image
        Storage::disk('local')->delete('public/beritas/'.basename($berita->image));

        if($berita->delete()) {
            //return success with Api Resource
            return new BeritaResource(true, 'Data Berita Berhasil Dihapus!', null);
        }

        //return failed with Api Resource
        return new BeritaResource(false, 'Data Berita Gagal Dihapus!', null);
    }
}