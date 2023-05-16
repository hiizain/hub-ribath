<?php

namespace App\Http\Controllers\back;

use Illuminate\Http\Request;
use App\Models\BlogModel as Blog;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ProgramModel as Program;
use App\Models\PendaftaranModel as Pendaftaran;
use App\Models\SewaModel as Sewa;
use App\Models\SafariModel as Safari;
use App\Models\BlogXUserModel as Kontributor;
use App\Models\TahapProgramModel as TahapProgram;
use App\Models\KegiatanProgramModel as KegiatanProgram;

class LayananController extends Controller
{
    public function sewa()
    {
        $data['title'] = 'Sewa Media';
        $sewa = Sewa::orderBy('created_at', 'asc')->get();
        return view('aplication/layanan/media/sewa', ['data' => $data, 'sewa' => $sewa]);
    }

    public function aksiSewa(Request $request)
    {
        if (Sewa::where('id', $request->id_sewa)->update([
            'is_accepted' => $request->value
        ])) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil ditambahkan',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal ditambahkan',
            ]);
        }
        // var_dump($request->value);
        // die();
        // $data['title'] = 'Detail Program';
        // $program = Program::where('id', $id)->first();
        // $tahap = TahapProgram::where('program_id', $id)->where('mulai', '<=', date('Y-m-d h:m:s'))->where('selesai', '>=', date('Y-m-d h:m:s'))->first();
        // return view('aplication/program/tambah', ['data' => $data]);
    }

    public function safari()
    {
        $data['title'] = 'Booking Majlis';
        $safari = Safari::orderBy('created_at', 'asc')->get();
        return view('aplication/layanan/safari/book', ['data' => $data, 'safari' => $safari]);
    }

    public function aksiSafari(Request $request)
    {
        if (Safari::where('id', $request->id_safari)->update([
            'is_accepted' => $request->value
        ])) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil ditambahkan',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal ditambahkan',
            ]);
        }
        // var_dump($request->value);
        // die();
        // $data['title'] = 'Detail Program';
        // $program = Program::where('id', $id)->first();
        // $tahap = TahapProgram::where('program_id', $id)->where('mulai', '<=', date('Y-m-d h:m:s'))->where('selesai', '>=', date('Y-m-d h:m:s'))->first();
        // return view('aplication/program/tambah', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_program' => 'required',
            'tahun' => 'required',
            'deskripsi' => 'required',
            'kegiatan' => 'required',
            'tahap' => 'required',
        ], [
            'nama_program.required' => 'Kolom nama program harus diisi!',
            'tahun.required' => 'Kolom tahun harus diisi!',
            'deskripsi.required' => 'Kolom deskripsi harus diisi!',
            'kegiatan.required' => 'Kolom kegiatan harus dipilih!',
            'tahap.required' => 'Kolom tahap harus diinisialisasi!',
        ]);

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
            foreach ($request->kegiatan as $item) {
                $kegiatan[] = [
                    'program_id' => $program_id,
                    'kegiatan_id' => $item
                ];
            }
            KegiatanProgram::insert($kegiatan);

            $tahap = [];
            // var_dump(json_decode($request->tahap));
            foreach (json_decode($request->tahap) as $item) {
                $tahap[] = [
                    'program_id' => $program_id,
                    'tahap_id' => $item->tahap_id,
                    'mulai' => $item->mulai,
                    'selesai' => $item->selesai,
                    'is_actived' => '1',
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
    }

    public function show($id)
    {
        $data['title'] = 'Detail Program';
        $program = Program::where('id', $id)->first();
        $tahap = TahapProgram::where('program_id', $id)->where('mulai', '<=', date('Y-m-d h:m:s'))->where('selesai', '>=', date('Y-m-d h:m:s'))->first();
        return view('aplication/program/edit', ['data' => $data, 'program' => $program, 'tahap' => $tahap]);
    }

    public function detail($id)
    {
        $data['title'] = 'Detail Program';
        $program = Program::where('id', $id)->first();
        // $tahap = TahapProgram::where('program_id', $id)->where('mulai', '<=', date('Y-m-d h:m:s'))->where('selesai', '>=', date('Y-m-d h:m:s'))->first();
        $tahap = TahapProgram::where('program_id', $id)->orderBy('mulai', 'asc')->get();
        // var_dump($tahap);
        // die();
        return view('aplication/program/detail', ['data' => $data, 'program' => $program, 'tahaps' => $tahap]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_program' => 'required',
            'tahun' => 'required',
            'deskripsi' => 'required',
            'kegiatan' => 'required',
            'tahap' => 'required',
        ], [
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
                'deskripsi' => $request->deskripsi
            ]);

            KegiatanProgram::where('program_id', $id)->delete();
            $kegiatan = [];
            foreach ($request->kegiatan as $item) {
                $kegiatan[] = [
                    'program_id' => $id,
                    'kegiatan_id' => $item
                ];
            }
            KegiatanProgram::insert($kegiatan);

            // $tahap = [];
            $tahapNow = TahapProgram::where('program_id', $id)->get();
            $arrTahapId = [];
            foreach ($tahapNow as $item) {
                $arrTahapId[] = $item->tahap_id;
            }
            if (count(json_decode($request->tahap)) >= count($arrTahapId)) {
                foreach (json_decode($request->tahap) as $item) {
                    TahapProgram::updateOrCreate(
                        ['program_id' => $id, 'tahap_id' => $item->tahap_id],
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
            } else if (count(json_decode($request->tahap)) > 0) {
                foreach (json_decode($request->tahap) as $item) {
                    if (array_search($item->tahap_id, $arrTahapId)) {
                        TahapProgram::updateOrCreate(
                            ['mulai' => $item->mulai, 'selesai' => $item->selesai, 'is_actived' => '1'],
                            ['program_id' => $id, 'tahap_id' => $item->tahap_id]
                        );
                    } else {
                        TahapProgram::where('tahap_id', $item->tahap_id)->delete();
                    }
                }
            } else if (count(json_decode($request->tahap)) == 0) {
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
    }

    public function seleksi()
    {
        $data['title'] = 'Seleksi Program';

        $now = date("Y-m-d H:i:s");
        $program = Program::select(['program.*', 'program_tahap.mulai as mulai', 'program_tahap.selesai as selesai', 'ref_tahap.nama_tahap as nama_tahap'])->join('program_tahap', 'program_tahap.program_id', '=', 'program.id')->join('ref_tahap', 'ref_tahap.id', '=', 'program_tahap.tahap_id')->where('mulai', '<=', $now)->where('selesai', '>=', $now)->where('nama_tahap', 'LIKE', 'Seleksi')->get();
        return view('aplication/program/seleksi', ['data' => $data, 'program' => $program]);
    }

    public function seleksiShow($id)
    {
        // var_dump($id);
        // die();
        $data['title'] = 'Proses Seleksi Program';
        $peserta = Pendaftaran::where('program_id', $id)->orderBy('created_at', 'asc')->paginate(1);
        // var_dump($peserta);
        // die();
        return view('aplication/program/prosesSeleksi', ['data' => $data, 'peserta' => $peserta]);
    }

    public function updateDateTahapProgram(Request $request, $id)
    {
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

        if (TahapProgram::where('program_id', $id)->where('tahap_id', $request->id)) {
            if (TahapProgram::where('program_id', $id)->where('tahap_id', $request->id)->update([
                'is_actived' => '0'
            ])) {
                $tahapProgram = new TahapProgram([
                    'program_id' => $id,
                    'tahap_id' => $request->id,
                    'mulai' => $request->mulai,
                    'selesai' => $request->selesai,
                    'is_actived' => '1',
                ]);
                if ($tahapProgram->save()) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Data berhasil diupdate',
                    ]);
                } else {
                    TahapProgram::where('program_id', $id)->where('tahap_id', $request->id)->update([
                        'is_actived' => '1'
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

    public function createKategori()
    {
        $data['title'] = 'Create Kategori';

        return view('application/create/kategori', ['data' => $data]);
    }

    public function createKategori_action(Request $request)
    {
        $request->validate([
            'kategori' => 'required',
        ], [
            'kategori.required' => 'Kolom kategori harus diisi!',
        ]);

        $kategori = new Kategori([
            'category' => $request->kategori,
        ]);

        if (auth()->user()->hasPermissionTo('createKategori')) {
            if ($kategori->save()) {
                return redirect()->route('kategori')->with('createSuccess', 'Data berhasil ditambahkan');
            } else {
                return back()->with('createError', 'Data gagal ditambahkan');
            }
        } else {
            return back()->with('createError', 'Anda tidak memiliki permission untuk menambah data');
        }
    }

    public function editKategori($idKategori)
    {
        $data['title'] = 'Edit Kategori';

        $kategoriFound = Kategori::where('id', $idKategori)->first();

        return view('application/edit/kategori', ['data' => $data, 'kategori' => $kategoriFound]);
    }

    public function editKategori_action(Request $request)
    {
        $request->validate([
            'kategori' => 'required',
        ], [
            'kategori.required' => 'Kolom kategori harus diisi!',
        ]);

        if (Kategori::where('id', $request->id_kategori)) {
            if (auth()->user()->hasPermissionTo('updateKategori')) {
                if (Kategori::where('id', $request->id_kategori)->update([
                    'category' => $request->kategori
                ])) {
                    return redirect()->route('kategori')->with('createSuccess', 'Perubahan berhasil disimpan');
                } else {
                    return back()->with('createError', 'Data gagal diupdate');
                }
            } else {
                return back()->with('createError', 'Anda tidak memiliki permission untuk mengedit data');
            }
        }
        return back()->with('createError', 'ID tidak ditemukan');
    }

    public function deleteKategori_action(Request $request)
    {
        if (Kategori::where('id', $request->id_kategori)) {
            if (auth()->user()->hasPermissionTo('deleteKategori')) {
                if (Kategori::where('id', $request->id_kategori)->delete()) {
                    return redirect()->route('kategori')->with('createSuccess', 'Data berhasil dihapus');
                } else {
                    return back()->with('createError', 'Data gagal dihapus');
                }
            } else {
                return back()->with('createError', 'Anda tidak memiliki permission untuk menghapus data');
            }
        }
        return back()->with('createError', 'Data tidak ditemukan');
    }

    // get data
    public function getKategori()
    {
        $kategoris = Kategori::all();
        $arrNamaKategori = array();
        $i = 0;
        if ($kategoris) {
            foreach ($kategoris as $item) {
                $arrNamaKategori[$i]['id'] = $item->id;
                $arrNamaKategori[$i]['text'] = $item->category;
                $i++;
            }
        }
        // var_dump( json_encode($arrNamaKategori));
        return json_encode($arrNamaKategori);
    }

    public function getKategoriBlog($idBlog)
    {
        $kategoris = Kategori::where('blog_id', $idBlog)->get();
        $arrNamaKategori = array();
        $i = 0;
        if ($kategoris) {
            foreach ($kategoris as $item) {
                $arrNamaKategori[$i]['id'] = $item->id;
                $arrNamaKategori[$i]['text'] = $item->category;
                $i++;
            }
        }
        // var_dump( json_encode($arrNamaKategori));
        return json_encode($arrNamaKategori);
    }
}
