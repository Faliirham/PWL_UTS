<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PositionController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Jabatan',
            'list' => ['Home', 'Position']
        ];

        $page = (object)[
            'title' => 'Daftar jabatan yang tersedia dalam sistem'
        ];

        $activeMenu = 'position';

        return view('position.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $position = Position::query();

        return DataTables::of($position)
            ->addIndexColumn()
            ->addColumn('aksi', function ($position) {
                // $btn = '<a href="' . url('/position/' . $position->id) . '" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="' . url('/position/' . $position->id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/position/' . $position->id) . '">' .
                //     csrf_field() . method_field('DELETE') .
                //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin hapus jabatan ini?\')">Hapus</button></form>';
                $btn = '<button onclick="modalAction(\''.url('/position/' . $position->id .'/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';

                $btn .= '<button onclick="modalAction(\''.url('/position/' . $position->id .'/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';

                $btn .= '<button onclick="modalAction(\''.url('/position/' . $position->id .'/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Jabatan',
            'list' => ['Home', 'Position', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Jabatan Baru'
        ];

        $activeMenu = 'position';

        return view('position.create', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string'
        ]);

        Position::create([
            'name'        => $request->name,
            'description' => $request->description
        ]);

        return redirect('/position')->with('success', 'Jabatan berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $position = Position::findOrFail($id);

        $breadcrumb = (object)[
            'title' => 'Detail Jabatan',
            'list' => ['Home', 'Position', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Jabatan'
        ];

        $activeMenu = 'position';

        return view('position.show', compact('breadcrumb', 'page', 'position', 'activeMenu'));
    }

    public function show_ajax(string $id)
    {
        $position = Position::find($id);
        
        // Load relasi employees jika ditemukan
        if ($position) {
            $position->load('employees');
        }
        
        return view('position.show_ajax', ['position' => $position]);
    }

    public function edit(string $id)
    {
        $position = Position::findOrFail($id);

        $breadcrumb = (object)[
            'title' => 'Edit Jabatan',
            'list' => ['Home', 'Position', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Jabatan'
        ];

        $activeMenu = 'position';

        return view('position.edit', compact('breadcrumb', 'page', 'position', 'activeMenu'));
    }

    public function update(Request $request, string $id)
    {
        $position = Position::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string'
        ]);

        $position->name = $request->name;
        $position->description = $request->description;
        $position->save();

        return redirect('/position')->with('success', 'Jabatan berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $position = Position::find($id);

        if (!$position) {
            return redirect('/position')->with('error', 'Jabatan tidak ditemukan');
        }

        try {
            $position->delete();
            return redirect('/position')->with('success', 'Jabatan berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/position')->with('error', 'Jabatan gagal dihapus karena masih terhubung dengan data lain');
        }
    }

    public function create_ajax()
    {
        return view('position.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'name'        => 'required|string|max:100',
                'description' => 'nullable|string'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            try {
                Position::create([
                    'name'        => $request->name,
                    'description' => $request->description
                ]);

                return response()->json([
                    'status'  => true,
                    'message' => 'Data posisi berhasil disimpan'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Terjadi kesalahan saat menyimpan data'
                ]);
            }
        }

        return redirect('/position');
    }

    public function edit_ajax(string $id)
    {
        $position = Position::find($id);
        return view('position.edit_ajax', ['position' => $position]);
    }

    public function update_ajax(Request $request, $id)
    {
        // Cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            
            // Aturan validasi
            $rules = [
                'name'        => 'required|string|max:100',
                'description' => 'nullable|string'
            ];

            // Validasi request
            $validator = Validator::make($request->all(), $rules);

            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors() // Menunjukkan field mana yang error
                ]);
            }

            // Mencari data position berdasarkan ID
            $position = Position::find($id);
            
            // Jika position ditemukan
            if ($position) {
                // Update data position dengan data yang valid
                $position->update([
                    'name'        => $request->name,
                    'description' => $request->description
                ]);
                
                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data posisi tidak ditemukan'
                ]);
            }
        }
        // Jika bukan ajax, redirect ke halaman utama
        return redirect('/position');
    }

    public function confirm_ajax(string $id)
    {
        $position = Position::find($id);
        
        // Load relasi employees jika ditemukan
        if ($position) {
            $position->load('employees');
        }
        
        return view('position.delete_ajax', ['position' => $position]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $position = Position::find($id);
            if ($position) {
                // Cek apakah posisi memiliki karyawan terkait
                if ($position->employees && $position->employees->count() > 0) {
                    return response()->json([
                        'status'  => false,
                        'message' => 'Posisi ini memiliki karyawan terkait. Hapus karyawan terlebih dahulu.'
                    ]);
                }
                
                $position->delete();
                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/position');
    }
}