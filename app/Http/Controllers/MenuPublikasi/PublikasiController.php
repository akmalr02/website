<?php

namespace App\Http\Controllers\MenuPublikasi;

use App\Http\Controllers\Controller;
use App\Models\backend\MenuPublikasi\PublikasiModel;
use App\Models\backend\ref_kategori;
use App\Models\backend\ref_status;
use App\Models\backend\ref_tipe;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PublikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = PublikasiModel::with(['kategori', 'status', 'tipe'])->select('*');
        if (request()->ajax()) {
            return datatables()->of($query)

                ->addColumn('image_publikasi', function ($query) {
                    $url = asset('storage/romadan_gambar_web/' . $query->image);
                    return '<a href="' . $url . '"><img src="' . $url . '" border="0" width="100" class="img-rounded" align="center""/></a>';
                })
                ->addColumn('file_publikasi', function ($query) {
                    $url = asset('storage/romadan_file_web/' . $query->file);
                    return '<a href="' . $url . '" target="_blank">' . $query->judul . '</a>';
                })
                ->addColumn('opsi', function ($query) {
                    $preview = route('publikasi.show', encrypt($query->id));
                    $edit = route('publikasi.edit', encrypt($query->id));
                    $hapus = route('publikasi.destroy', encrypt($query->id));
                    return '<div class="d-inline-flex">
											<div class="dropdown">
												<a href="#" class="text-body" data-bs-toggle="dropdown">
													<i class="ph-list"></i>
												</a>

												<div class="dropdown-menu dropdown-menu-end">
													<a href="' . $preview . '" class="dropdown-item">
														<i class="ph-detective me-2"></i>
														Preview
													</a>
													<a href="' . $edit . '" class="dropdown-item">
														<i class="ph-note-pencil me-2"></i>
														Edit
													</a>
													<form action="' . $hapus . '" method="POST">
													' . @csrf_field() . '
													' . @method_field('DELETE') . '
													<button type="submit" name="submit" class="dropdown-item"> <i class="ph-trash me-2"></i> Hapus</button>
													</form>
												</div>
											</div>
										</div>
                ';
                })

                ->editColumn('created_at', function ($query) {
                    return date('d-M-Y H:i:s', strtotime($query->created_at));
                })


                ->rawColumns(['opsi', 'image_publikasi', 'file_publikasi'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('backend.publikasi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $kategori = ModelsRef_kategori::get();
        $kategori = ref_kategori::get();
        $tipe = ref_tipe::get();
        return view('backend.publikasi.create', compact(['kategori', 'tipe']));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            // VALIDASI DATA
            $request->validate([
                'judul' => 'required|unique:publikasi',
                'sub_judul' => 'required',
                'kategori' => 'required',
                'tipe' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:10240|dimensions:min_width=1024,min_height=600',
                'isi' => 'required',
                'backdate' => 'date|date_format:Y-m-d\TH:i',
                'file' => 'mimes:pdf|max:10240',
            ], [
                'judul.required' => 'Judul Wajib diisi.',
                'judul.unique' => 'Judul ini sudah digunakan sebelumnya.',
                'sub_judul.required' => 'Sub judul Wajib diisi.',
                'kategori.required' => 'Kategori Wajib dipilih.',
                'tipe.required' => 'Tipe Wajib dipilih.',
                'image.required' => 'Gambar Wajib diunggah.',
                'image.image' => 'File yang diunggah Wajib berupa gambar.',
                'image.mimes' => 'File gambar Wajib berformat jpeg, png, jpg, atau svg.',
                'image.max' => 'Ukuran gambar tidak boleh melebihi 10MB (10240 KB).',
                'image.dimensions' => 'Dimensi gambar minimal ukuran 1024x600 piksel.',
                'isi.required' => 'Isi Publikasi Wajib diisi.',
                // 'file.required'=>'File Wajib Diisi',
                'file.max' => 'Ukuran File tidak boleh melebihi 10MB (10240 KB)',
                'file.mimes' => 'File yang diunggah Wajib berupa PDF'

            ]);

            //UPLOAD IMAGE
            $image = $request->file('image');
            $image->storeAs('public/romadan_gambar_web', $image->hashName());

            //UPLOAD FILE
            // $file = $request->file('file');
            // $file->storeAs('public/romadan_file_web', $file->hashName());
            // Proses file jika diunggah
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $file = $file->storeAs('public/romadan_file_web', $file->hashName());
            } else {
                $file = null; // atau atur default value lainnya
            }

            // SLUG

            $slug = Str::slug($request->judul);


            // TAMPUNGAN REQUEST DATA DARI FORM
            $data = [
                'judul' => $request->judul,
                'sub_judul' => $request->sub_judul,
                'kategori' => $request->kategori,
                'tipe' => $request->tipe,
                'image' => $image->hashName(),
                'isi' => $request->isi,
                'slug' => $slug,
                'penulis' => Auth::user()->name,
                'static_random_string' => Str::random(10) . uniqid() . Str::random(4),
                'backdate' => Carbon::parse($request->backdate)->format('Y-m-d H:i'),
                'file' => $file,

            ];

            if ($request->has('backdate') && !empty($request->backdate)) {
                $data['backdate'] = Carbon::parse($request->backdate)->format('Y-m-d H:i');
                $data['status'] = 'published';
            } else {
                $data['status'] = 'draft';
            }


            PublikasiModel::create($data);

            //redirect to index
            return redirect()->back()->with(['success' => 'Data Publikasi Berhasil Disimpan!']);
        } catch (ValidationException $e) {
            // Validation failed, return to previous page with errors and input data
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            return redirect()->back()->with(['failed' => 'Data Publikasi Gagal Disimpan! | Pesan Error: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = PublikasiModel::findOrFail(decrypt($id));
        // dd($data);

        return view('backend.publikasi.show', compact(['data']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kategori = ref_kategori::all();
        $status = ref_status::all();
        $tipe = ref_tipe::all();
        $publikasi = PublikasiModel::with(['kategori', 'status', 'tipe'])->findOrFail(decrypt($id));


        // dd($publikasi['created_at']);

        // dd(Carbon::parse($publikasi->created_at)->format('Y-m-d H:i:s'));

        return view('backend.publikasi.edit', compact(['publikasi', 'kategori', 'status', 'tipe']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // VALIDASI DATA
            $request->validate([
                'judul' => 'required',
                'sub_judul' => 'required',
                'kategori' => 'required',
                'tipe' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,svg|max:4096|dimensions:min_width=1024,min_height=600',
                'isi' => 'required',
                'created_at' => 'required|date|before:now|date_format:Y-m-d\TH:i:s',
                'file' => 'mimes:pdf|max:10240',
            ], [
                'image.required' => 'Gambar Wajib diunggah.',
                'image.image' => 'File yang diunggah Wajib berupa gambar.',
                'image.mimes' => 'File gambar Wajib berformat jpeg, png, jpg, atau svg.',
                'image.max' => 'Ukuran gambar tidak boleh melebihi 4MB (4096KB).',
                'image.dimensions' => 'Dimensi gambar minimal ukuran 1024x600 piksel.',
                'file.mimes' => 'File hanya diperbolehkan berekstensi PDF',
                'file.max' => 'Ukuran File tidak boleh melebihi 10MB (10240 KB)',
            ]);

            // TEMUKAN DATA PUBLIKASI
            $publikasi = PublikasiModel::findOrFail(decrypt($id));

            // TAMPUNGAN REQUEST DATA DARI FORM
            $data = [
                'judul' => $request->judul,
                'sub_judul' => $request->sub_judul,
                'kategori' => $request->kategori,
                'tipe' => $request->tipe,
                'isi' => $request->isi,
                'status' => $request->status,
                'pengedit' => Auth::user()->name,
                'created_at' => Carbon::parse($request->created_at)->format('Y-m-d H:i:s'),
            ];

            // UPLOAD IMAGE JIKA ADA
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image->storeAs('public/romadan_gambar_web', $image->hashName());

                // Hapus gambar lama
                File::delete(public_path('storage/romadan_gambar_web/') . $publikasi->image);

                // Tambahkan nama file gambar ke dalam data
                $data['image'] = $image->hashName();
            }

            // UPLOAD FILE JIKA ADA
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $file->storeAs('public/romadan_file_web', $file->hashName());

                // Hapus file lama
                File::delete(public_path('storage/romadan_file_web/') . $publikasi->file);

                // Tambahkan nama file ke dalam data
                $data['file'] = $file->hashName();
            }
            // dd($data);
            // UPDATE DATA DI DATABASE
            $publikasi->update($data);

            return redirect()->route('publikasi.index')->with('success', "Publikasi $request->judul berhasil diupdate!");
        } catch (Exception $e) {
            return redirect()->route('publikasi.index')->with(['failed' => 'Data Publikasi Gagal Di Update! error :' . $e->getMessage()]);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data['status'] = 'draft';
            PublikasiModel::findOrFail(decrypt($id))->update($data);
            PublikasiModel::findOrFail(decrypt($id))->delete($data);
            return redirect()->route('publikasi.index')->with('success', "Publikasi berhasil dihapus!");
        } catch (Exception $e) {
            return redirect()->route('publikasi.index')->with(['failed' => 'Data Yang Dihapus Tidak Ada ! error :' . $e->getMessage()]);
        }
    }

    public function publikasiSampah(Request $request)
    {
        $query = PublikasiModel::onlyTrashed()->with(['kategori', 'status', 'tipe']);
        // dd($query);
        if (request()->ajax()) {
            return datatables()->of($query)
                ->addColumn('image_publikasi', function ($query) {
                    $url = asset('storage/romadan_gambar_web/' . $query->image);
                    return '<a href="' . $url . '"><img src="' . $url . '" border="0" width="100" class="img-rounded" align="center""/></a>';
                })
                ->addColumn('opsi', function ($query) {
                    // $preview = route('berita.show', $query->id);
                    $restore = route('publikasi.restore', encrypt($query->id));
                    $paksahapus = route('publikasi.force-delete', encrypt($query->id));
                    return '<div class="d-inline-flex">
											<div class="dropdown">
												<a href="#" class="text-body" data-bs-toggle="dropdown">
													<i class="ph-list"></i>
												</a>

												<div class="dropdown-menu dropdown-menu-end">
													<form action="' . $restore . '" method="POST">
													' . @csrf_field() . '
													<button type="submit" name="submit" class="dropdown-item"> <i class="ph-trash me-2"></i> Restore</button>
													</form>
													<form action="' . $paksahapus . '" method="POST">
													' . @csrf_field() . '
													' . @method_field('DELETE') . '
													<button type="submit" name="submit" class="dropdown-item"> <i class="ph-trash me-2"></i> Paksa Hapus</button>
													</form>
												</div>
											</div>
										</div>
                ';
                })
                ->rawColumns(['opsi', 'image_publikasi'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('backend.publikasi.sampah', compact('query'));
    }

    public function restorePublikasi($id)
    {
        try {
            $data['status'] = 'draft';
            PublikasiModel::onlyTrashed()->findOrFail(decrypt($id))->update($data);
            PublikasiModel::onlyTrashed()->findOrFail(decrypt($id))->restore();
            return redirect()->route('publikasi.sampah')->with('success', "Data publikasi berhasil direstore!, silahkan cek pada publikasi aktif yah guys!");
        } catch (Exception $e) {
            return redirect()->route('publikasi.sampah')->with(['failed' => 'Data publikasi GAGAL di Restore ! error :' . $e->getMessage()]);
        }
    }

    public function restoreAllPublikasi()
    {

        $dataterhapus = PublikasiModel::onlyTrashed()->with(['kategori', 'status', 'tipe'])->get();

        if (count($dataterhapus) > 0) {
            try {
                $data['status'] = 'draft';
                PublikasiModel::onlyTrashed()->update($data);
                PublikasiModel::onlyTrashed()->restore();
                return redirect()->route('publikasi.sampah')->with('success', "Semua Data publikasi berhasil direstore!, silahkan cek pada publikasi aktif yah guys!");
            } catch (Exception $e) {
                return redirect()->route('publikasi.sampah')->with(['failed' => 'Semua Data publikasi GAGAL di Restore ! error :' . $e->getMessage()]);
            }
        }
        return redirect()->route('publikasi.sampah')->with(['failed' => 'Data yang direstore gak ada :( ']);
    }
    public function forceDeletePublikasi($id)
    {
        try {
            $data_gambar = PublikasiModel::withTrashed()->findOrFail(decrypt($id));
            File::delete(public_path('storage/romadan_gambar_web/') . $data_gambar->image);
            PublikasiModel::withTrashed()->findOrFail(decrypt($id))->forceDelete();
            return redirect()->route('publikasi.sampah')->with('success', "Data Berhasil dihapus PERMANEN");
        } catch (Exception $e) {
            return redirect()->route('publikasi.sampah')->with(['failed' => 'Data GAGAL dihapus Permanen ! error :' . $e->getMessage()]);
        }
    }
}
