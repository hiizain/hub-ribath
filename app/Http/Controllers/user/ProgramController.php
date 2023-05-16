<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Models\BlogModel as Blog;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ProgramModel as Program;
use App\Models\BlogXUserModel as Kontributor;
use App\Models\TahapProgramModel as TahapProgram;
use App\Models\KegiatanProgramModel as KegiatanProgram;
use App\Models\PendaftaranModel as Pendaftaran;

class ProgramController extends Controller
{
    public function index(){
        $data['title'] = 'Program';
        $program = Pendaftaran::select(['pendaftaran.*', 'santri.user_id as user_id', 'program.nama_program as nama_program', 'program.tahun as tahun', 'program.deskripsi as deskripsi'])->join('santri', 'santri.id', '=', 'pendaftaran.santri_id')->join('program', 'program.id', '=', 'pendaftaran.program_id')->where('user_id', Auth::user()->id)->get();
        return view('user/program/index', ['data' => $data, 'program' => $program]);
    }

    public function program(Request $request){
        $data['title'] = 'Detail Program';

        $program = Program::where('id', $request->programId)->first();
        $tahap = TahapProgram::where('program_id', $request->programId)->orderBy('mulai', 'asc')->get();
        // $tahap = TahapProgram::where('program_id', $id)->where('mulai', '<=', date('Y-m-d h:m:s'))->where('selesai', '>=', date('Y-m-d h:m:s'))->first();
        return view('program/daftar', ['data' => $data, 'program' => $program, 'tahap' => $tahap]);
    }

    public function create(){
        $data['title'] = 'Detail Program';
        // $program = Program::where('id', $id)->first();
        // $tahap = TahapProgram::where('program_id', $id)->where('mulai', '<=', date('Y-m-d h:m:s'))->where('selesai', '>=', date('Y-m-d h:m:s'))->first();
        return view('aplication/program/tambah', ['data' => $data]);
    }

    public function store(Request $request){
        $request->validate([
            'nama_program' => 'required',
            'tahun' => 'required',
            'deskripsi' => 'required',
            'kegiatan' => 'required',
            'tahap' => 'required',
        ],[
            'nama_program.required' => 'Kolom nama program harus diisi!',
            'tahun.required' => 'Kolom tahun harus diisi!',
            'deskripsi.required' => 'Kolom deskripsi harus diisi!',
            'kegiatan.required' => 'Kolom kegiatan harus dipilih!',
            'tahap.required' => 'Kolom tahap harus diinisialisasi!',
        ]);

        // var_dump($request->tahun);
        // die();

        // $program = new Program([
        //     'nama_program' => $request->nama_program,
        //     'tahun' => $request->tahun,
        //     'deskripsi' => $request->deskripsi,
        // ]);
        // $program->save();

        // $program_id = Program::where('nama_program', $request->nama_program)->where('tahun', $request->tahun)->where('deskripsi', $request->deskripsi)->first()->id;
        
        // $kegiatan = [];
        // foreach($request->kegiatan as $item){
        //     $kegiatan [] = [
        //         'program_id'=>$program_id, 
        //         'kegiatan_id'=>$item
        //     ];
        // }
        // KegiatanProgram::insert($kegiatan);
        
        // $tahap = [];
        // // var_dump(json_decode($request->tahap));
        // foreach(json_decode($request->tahap) as $item){
        //     $tahap [] = [
        //         'program_id'=>$program_id, 
        //         'tahap_id'=>$item->tahap_id,
        //         'mulai'=>$item->mulai,
        //         'selesai'=>$item->selesai,
        //         'is_actived'=>'1',
        //     ];
        // }
        // TahapProgram::insert($tahap);

        // $program_id = Program::where('nama_program', 'Pondok Ramadhan')->where('tahun', '2023')->where('deskripsi', 'Kegiatan pesantren pada bulan ramadhan')->first()->id;
        // var_dump($program_id);
        DB::beginTransaction();
        try {
            $program = new Program([
                'nama_program' => $request->nama_program,
                'tahun' => $request->tahun,
                'deskripsi' => $request->deskripsi,
            ]);
            $program->save();
    
            $program_id = Program::where('nama_program', $request->nama_program)->where('tahun', $request->tahun)->where('deskripsi', $request->deskripsi)->first()->id;
            
            $kegiatan = [];
            foreach($request->kegiatan as $item){
                $kegiatan [] = [
                    'program_id'=>$program_id, 
                    'kegiatan_id'=>$item
                ];
            }
            KegiatanProgram::insert($kegiatan);
            
            $tahap = [];
            // var_dump(json_decode($request->tahap));
            foreach(json_decode($request->tahap) as $item){
                $tahap [] = [
                    'program_id'=>$program_id, 
                    'tahap_id'=>$item->tahap_id,
                    'mulai'=>$item->mulai,
                    'selesai'=>$item->selesai,
                    'is_actived'=>'1',
                ];
            }
            TahapProgram::insert($tahap);
        
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
        
        // $program = new Program([
        //     'nama_program' => $request->nama_program,
        //     'tahun' => $request->tahun,
        //     'deskripsi' => $request->deskripsi,
        // ]);

        // if($program->save()){
        //     return response()->json([
        //         'status' => 'success',
        //         'message' => 'Data berhasil ditambahkan',
        //     ]);
        // } else {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Data gagal ditambahkan',
        //     ]);
        // }
        // var_dump(json_decode($request->dataTahap));
        // die();
        // $data['title'] = 'Detail Program';
        // $program = Program::where('id', $id)->first();
        // $tahap = TahapProgram::where('program_id', $id)->where('mulai', '<=', date('Y-m-d h:m:s'))->where('selesai', '>=', date('Y-m-d h:m:s'))->first();
        // return view('aplication/program/detail', ['data' => $data, 'program' => $program, 'tahap' => $tahap]);
    }

    public function show($id){
        $data['title'] = 'Detail Program';
        $program = Program::where('id', $id)->first();
        $tahap = TahapProgram::where('program_id', $id)->where('mulai', '<=', date('Y-m-d h:m:s'))->where('selesai', '>=', date('Y-m-d h:m:s'))->first();
        return view('aplication/program/edit', ['data' => $data, 'program' => $program, 'tahap' => $tahap]);
    }

    public function detail($id){
        $data['title'] = 'Detail Program';
        $program = Program::where('id', $id)->first();
        // $tahap = TahapProgram::where('program_id', $id)->where('mulai', '<=', date('Y-m-d h:m:s'))->where('selesai', '>=', date('Y-m-d h:m:s'))->first();
        $tahap = TahapProgram::where('program_id', $id)->orderBy('mulai', 'asc')->get();
        // var_dump($tahap);
        // die();
        return view('user/program/detail', ['data' => $data, 'program' => $program, 'tahap' => $tahap]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'nama_program' => 'required',
            'tahun' => 'required',
            'deskripsi' => 'required',
            'kegiatan' => 'required',
            'tahap' => 'required',
        ],[
            'nama_program.required' => 'Kolom nama program harus diisi!',
            'tahun.required' => 'Kolom tahun harus diisi!',
            'deskripsi.required' => 'Kolom deskripsi harus diisi!',
            'kegiatan.required' => 'Kolom kegiatan harus diisi!',
            'tahap.required' => 'Kolom tahap harus diisi!',
        ]);

        DB::beginTransaction();
        try {
            Program::where('id', $id)->update([
                'nama_program' => $request->nama_program,
                'tahun' => $request->tahun,
                'deskripsi'=>$request->deskripsi
            ]);
    
            KegiatanProgram::where('program_id', $id)->delete();
            $kegiatan = [];
            foreach($request->kegiatan as $item){
                $kegiatan [] = [
                    'program_id'=>$id, 
                    'kegiatan_id'=>$item
                ];
            }
            KegiatanProgram::insert($kegiatan);
            
            // $tahap = [];
            $tahapNow = TahapProgram::where('program_id', $id)->get();
            $arrTahapId = [];
            foreach($tahapNow as $item){
                $arrTahapId[] = $item->tahap_id;
            }
            if(count(json_decode($request->tahap)) >= count($arrTahapId)){
                foreach(json_decode($request->tahap) as $item){
                    TahapProgram::updateOrCreate(
                        ['program_id' => $id, 'tahap_id' =>$item->tahap_id],
                        ['mulai' => $item->mulai, 'selesai' => $item->selesai, 'is_actived' => '1']
                    );
                    // $tahap [] = [
                    //     'program_id'=>$id, 
                    //     'tahap_id'=>$item->tahap_id,
                    //     'mulai'=>$item->mulai,
                    //     'selesai'=>$item->selesai,
                    //     'is_actived'=>'1',
                    // ];
                }
            } else if(count(json_decode($request->tahap))>0) {
                foreach(json_decode($request->tahap) as $item){
                    if(array_search($item->tahap_id, $arrTahapId)){
                        TahapProgram::updateOrCreate(
                            ['mulai' => $item->mulai, 'selesai' => $item->selesai, 'is_actived' => '1'],
                            ['program_id' => $id, 'tahap_id' =>$item->tahap_id]
                        );
                    } else {
                        TahapProgram::where('tahap_id', $item->tahap_id)->delete();
                    }
                }
            } else if(count(json_decode($request->tahap))==0) {
                DB::rollback();

                return response()->json([
                    'status' => 'error',
                    'message' => 'Data gagal ditambahkan',
                ]);
            }
            // TahapProgram::insert($tahap);
        
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

        // if(Program::where('id', $id)){
        //     if(Program::where('id', $id)->update([
        //         'deskripsi'=>$request->deskripsi
        //         ])
        //     ){
        //         if($request->kegiatan){
        //             if(KegiatanProgram::where('program_id', $id)->delete()){
        //                 $kegiatan = [];
        //                 foreach($request->kegiatan as $item){
        //                     $kegiatan [] = [
        //                         'program_id'=>$id, 
        //                         'kegiatan_id'=>$item
        //                     ];
        //                 }
        //                 if(KegiatanProgram::insert($kegiatan)){
        //                     return response()->json([
        //                         'status' => 'success',
        //                         'message' => 'Data berhasil diupdate',
        //                     ]);
        //                 }
        //             }
        //         }
        //     } else {
        //         return response()->json([
        //             'status' => 'error',
        //             'message' => 'Data gagal diupdate',
        //         ]);
        //     }
        // } 
        // return response()->json([
        //     'status' => 'error',
        //     'message' => 'ID tidak ditemukan',
        // ]);
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
