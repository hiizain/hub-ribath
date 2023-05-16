<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgramModel as Program;
use App\Models\TahapProgramModel as TahapProgram;
use App\Models\SantriModel as Santri;
use App\Models\User;
use App\Models\PendaftaranModel as Pendaftaran;
use App\Models\BlogModel as Blog;
use App\Models\BlogXUserModel as Kontributor;
use App\Models\KegiatanProgramModel as KegiatanProgram;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProgramController extends Controller
{
    public function index(){
        $data['title'] = 'Program';
        // $programs = Program::orderBy('nama_program', 'asc')->tahap()->where("nama_tahap LIKE 'Pendaftaran'")->get();
        // $programs = Program::orderBy('nama_program', 'asc')->get()->tahap()->where("nama_tahap LIKE 'Pendaftaran'")->get();
        $programs = Program::join('program_tahap','program_tahap.program_id','=','program.id')->join('ref_tahap','program_tahap.tahap_id','=','ref_tahap.id')->where('mulai', '<=', date('Y-m-d h:m:s'))->where('selesai', '>=', date('Y-m-d h:m:s'))->where("nama_tahap", 'LIKE', 'Pendaftaran')->orderBy('nama_program', 'asc')->get();
        return view('program/index', ['data' => $data, 'program' => $programs]);
    }

    public function pendaftaran(Request $request){
        $data['title'] = 'Daftar Program';

        $program = Program::where('id', $request->programId)->first();
        $tahap = TahapProgram::where('program_id', $request->programId)->orderBy('mulai', 'asc')->get();
        $santri = null;
        if(Santri::where('user_id', $request->userId)->first()){
            $santri = Santri::where('user_id', $request->userId)->first();
        } else {
            $santri = new Santri([
                'user_id' => $request->userId,
            ]);
            $santri->save();
            $santri = Santri::where('user_id', $request->userId)->first();
        }
        // $tahap = TahapProgram::where('program_id', $id)->where('mulai', '<=', date('Y-m-d h:m:s'))->where('selesai', '>=', date('Y-m-d h:m:s'))->first();
        return view('program/daftar', ['data' => $data, 'program' => $program, 'tahap' => $tahap, 'santri' => $santri]);
    }

    public function pendaftaranAction(Request $request){
        $request->validate([
            'nik' => 'required',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'nama_wali' => 'required',
            'no_hp_wali' => 'required',
            'program_id' => 'required',
            'user_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $santri = Santri::where('user_id', $request->user_id)->first();
            $santri->update([
                'nik'=>$request->nik,
                'nama'=>$request->nama,
                'jenis_kelamin'=>$request->jenis_kelamin,
                'tempat_lahir'=>$request->tempat_lahir,
                'tanggal_lahir'=>$request->tanggal_lahir,
                'alamat'=>$request->alamat,
                'nama_wali'=>$request->nama_wali,
                'no_hp_wali'=>$request->no_hp_wali,
            ]);

            $pendaftaran = new Pendaftaran([
                'program_id' => $request->program_id,
                'santri_id' => $santri->id,
                'is_setuju' => '1',
            ]);
            $pendaftaran->save();
        
            DB::commit();

            // all good
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil ditambahkan',
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            // something went wrong
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal ditambahkan',
            ]);
        }
    }

    public function show($id){
        $data['title'] = 'Detail Program';
        $program = Program::where('id', $id)->first();
        $tahap = TahapProgram::where('program_id', $id)->where('mulai', '<=', date('Y-m-d h:m:s'))->where('selesai', '>=', date('Y-m-d h:m:s'))->first();
        return view('aplication/program/detail', ['data' => $data, 'program' => $program, 'tahap' => $tahap]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'deskripsi' => 'required',
            'kegiatan' => 'required',
        ],[
            'deskripsi.required' => 'Kolom deskripsi harus diisi!',
            'kegiatan.required' => 'Kolom kategori harus diisi!',
        ]);

        if(Program::where('id', $id)){
            if(Program::where('id', $id)->update([
                'deskripsi'=>$request->deskripsi
                ])
            ){
                if($request->kegiatan){
                    if(KegiatanProgram::where('program_id', $id)->delete()){
                        $kegiatan = [];
                        foreach($request->kegiatan as $item){
                            $kegiatan [] = [
                                'program_id'=>$id, 
                                'kegiatan_id'=>$item
                            ];
                        }
                        if(KegiatanProgram::insert($kegiatan)){
                            return response()->json([
                                'status' => 'success',
                                'message' => 'Data berhasil diupdate',
                            ]);
                        }
                    }
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data gagal diupdate',
                ]);
            }
        } 
        return response()->json([
            'status' => 'error',
            'message' => 'ID tidak ditemukan',
        ]);
        // $data['title'] = 'Detail Program';
        // $program = Program::where('id', $id)->first();
        // $tahap = TahapProgram::where('program_id', $id)->where('mulai', '<=', date('Y-m-d h:m:s'))->where('selesai', '>=', date('Y-m-d h:m:s'))->first();
        // return view('aplication/program/detail', ['data' => $data, 'program' => $program, 'tahap' => $tahap]);
    }

    public function updateDateTahapProgram(Request $request, $id){
        // $data = [
        //     'id' => $request->id,
        //     'mulai' => $request->mulai,
        //     'selesai' => $request->selesai,
        // ];
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Data tahap_program berhasil ditemukan',
        //     'data' => $data
        // ]);
        // $request->validate([
        //     'deskripsi' => 'required',
        //     'kegiatan' => 'required',
        // ],[
        //     'deskripsi.required' => 'Kolom deskripsi harus diisi!',
        //     'kegiatan.required' => 'Kolom kategori harus diisi!',
        // ]);

        if(TahapProgram::where('program_id', $id)->where('tahap_id', $request->id)){
            if(TahapProgram::where('program_id', $id)->where('tahap_id', $request->id)->update([
                    'is_actived'=>'0'
                ])
            ){
                $tahapProgram = new TahapProgram([
                    'program_id' => $id,
                    'tahap_id' => $request->id,
                    'mulai' => $request->mulai,
                    'selesai' => $request->selesai,
                    'is_actived' => '1',
                ]);
                if($tahapProgram->save()){
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Data berhasil diupdate',
                    ]);
                } else{
                    TahapProgram::where('program_id', $id)->where('tahap_id', $request->id)->update([
                        'is_actived'=>'1'
                    ]);
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Data gagal diupdate',
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data gagal diupdate',
                ]);
            }
        } 
        return response()->json([
            'status' => 'error',
            'message' => 'ID tidak ditemukan',
        ]);
        // $data['title'] = 'Detail Program';
        // $program = Program::where('id', $id)->first();
        // $tahap = TahapProgram::where('program_id', $id)->where('mulai', '<=', date('Y-m-d h:m:s'))->where('selesai', '>=', date('Y-m-d h:m:s'))->first();
        // return view('aplication/program/detail', ['data' => $data, 'program' => $program, 'tahap' => $tahap]);
    }

    public function createKategori(){
        $data['title'] = 'Create Kategori';

        return view('application/create/kategori', ['data' => $data]);
    }

    public function createKategori_action(Request $request)
    {
        $request->validate([
            'kategori' => 'required',
        ],[
            'kategori.required' => 'Kolom kategori harus diisi!',
        ]);
        
        $kategori = new Kategori([
            'category' => $request->kategori,
        ]);

        if(auth()->user()->hasPermissionTo('createKategori')){
            if($kategori->save()){
                return redirect()->route('kategori')->with('createSuccess', 'Data berhasil ditambahkan');
            } else {
                return back()->with('createError', 'Data gagal ditambahkan');
            }
        } else {
            return back()->with('createError', 'Anda tidak memiliki permission untuk menambah data');
        }
    }

    public function editKategori($idKategori){
        $data['title'] = 'Edit Kategori';

        $kategoriFound = Kategori::where('id', $idKategori)->first();

        return view('application/edit/kategori', ['data' => $data, 'kategori' => $kategoriFound]);
    }

    public function editKategori_action(Request $request)
    {
        $request->validate([
            'kategori' => 'required',
        ],[
            'kategori.required' => 'Kolom kategori harus diisi!',
        ]);

        if(Kategori::where('id', $request->id_kategori)){
            if(auth()->user()->hasPermissionTo('updateKategori')){
                if(Kategori::where('id', $request->id_kategori)->update([
                    'category'=>$request->kategori
                    ])
                ){
                    return redirect()->route('kategori')->with('createSuccess', 'Perubahan berhasil disimpan');
                } else {
                    return back()->with('createError', 'Data gagal diupdate');
                }
            } else {
                return back()->with('createError', 'Anda tidak memiliki permission untuk mengedit data');
            }
        } return back()->with('createError', 'ID tidak ditemukan');
    }

    public function deleteKategori_action(Request $request)
    {
        if(Kategori::where('id', $request->id_kategori)){
            if(auth()->user()->hasPermissionTo('deleteKategori')){
                if(Kategori::where('id', $request->id_kategori)->delete()){
                    return redirect()->route('kategori')->with('createSuccess', 'Data berhasil dihapus');
                } else {
                    return back()->with('createError', 'Data gagal dihapus');
                }
            } else {
                return back()->with('createError', 'Anda tidak memiliki permission untuk menghapus data');
            }
        } return back()->with('createError', 'Data tidak ditemukan');
    }

    // get data
    public function getKategori(){
        $kategoris = Kategori::all();
        $arrNamaKategori = array();
        $i = 0;
        if($kategoris){
            foreach($kategoris as $item){
                $arrNamaKategori [$i]['id'] = $item->id;
                $arrNamaKategori [$i]['text'] = $item->category;
                $i++;
            }
        }
        // var_dump( json_encode($arrNamaKategori));
        return json_encode($arrNamaKategori);
    }

    public function getKategoriBlog($idBlog){
        $kategoris = Kategori::where('blog_id', $idBlog)->get();
        $arrNamaKategori = array();
        $i = 0;
        if($kategoris){
            foreach($kategoris as $item){
                $arrNamaKategori [$i]['id'] = $item->id;
                $arrNamaKategori [$i]['text'] = $item->category;
                $i++;
            }
        }
        // var_dump( json_encode($arrNamaKategori));
        return json_encode($arrNamaKategori);
    }
}
