<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TahapProgramModel as TahapProgram;
// use App\Models\KategoriModel as Kategori;
// use App\Models\BlogModel as Blog;
// use App\Models\BlogXUserModel as Kontributor;
use Illuminate\Support\Facades\Auth;

class TahapProgramController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

    public function index(){
        $tahap_program = TahapProgram::all();
        if(count($tahap_program)){
            return response()->json([
                'status' => 'success',
                'message' => 'Data list tahap_program berhasil didapat',
                'data' => $tahap_program
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

    public function showByProgram($id){
        $tahap_program = TahapProgram::join('ref_tahap','ref_tahap.id','=','program_tahap.tahap_id')->where('program_id', $id)->where('is_actived', '1')->orderBy('mulai', 'asc')->get();
        // var_dump($tahap_program);
        // die();
        if(count($tahap_program)){
            return response()->json([
                'status' => 'success',
                'message' => 'Data tahap_program berhasil ditemukan',
                'data' => $tahap_program
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Data tidak ditemukan',
        ]);
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
