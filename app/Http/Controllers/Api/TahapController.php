<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TahapModel as Tahap;
// use App\Models\KategoriModel as Kategori;
// use App\Models\BlogModel as Blog;
// use App\Models\BlogXUserModel as Kontributor;
use Illuminate\Support\Facades\Auth;

class TahapController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

    public function index(){
        $tahap = Tahap::all();
        if(count($tahap)){
            return response()->json([
                'status' => 'success',
                'message' => 'Data list tahap berhasil didapat',
                'data' => $tahap
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Data tidak ada',
        ], 401);
    }

    public function create(Request $request)
    {
        $request->validate([
            'category' => 'required',
        ],[
            'category.required' => 'Kolom category harus diisi!',
        ]);
        if(Auth::guard('api')->user()->hasPermissionTo('createKategori')){
            $kategori = new Kategori([
                'category' => $request->category,
            ]);

            if($kategori->save()){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data berhasil ditambahkan',
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data gagal ditambahkan',
                ], 401);
            }
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Anda tidak memiliki permission untuk menambah data kategori',
        ], 401);
    }

    public function show($id){
        if(Auth::guard('api')->user()->hasPermissionTo('readKategori')){
            $kategori = Kategori::where('id', $id)->get();
            if(count($kategori)){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data kategori berhasil ditemukan',
                    'data' => $kategori
                ]);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'ID tidak ditemukan',
            ], 401);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Anda tidak memiliki permission untuk melihat data kategori',
        ], 401);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required',
        ],[
            'category.required' => 'Kolom category harus diisi!',
        ]);

        if(Auth::guard('api')->user()->hasPermissionTo('updateKategori')){
            if(Kategori::where('id', $id)){
                if(Kategori::where('id', $id)->update([
                    'category'=>$request->category
                    ])
                ){
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Data kategori berhasil diupdate'
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Data kategori gagal diupdate'
                    ], 401);
                }
            } 
            return response()->json([
                'status' => 'error',
                'message' => 'ID tidak ditemukan'
            ], 401);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Anda tidak memiliki permission untuk mengubah data kategori',
        ], 401);
    }

    public function destroy($id)
    {
        if(Auth::guard('api')->user()->hasPermissionTo('deleteKategori')){
            if(Kategori::where('id', $id)){
                if(Kategori::where('id', $id)->delete()){
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Data kategori berhasil dihapus'
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Data kategori gagal dihapus'
                    ], 401);
                }
            }
            return response()->json([
                'status' => 'error',
                'message' => 'ID tidak ditemukan'
            ], 401);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Anda tidak memiliki permission untuk menghapus data kategori',
        ], 401);
    }
}
