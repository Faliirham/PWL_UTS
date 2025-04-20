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

        return view('positions.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $positions = Position::query();

        return DataTables::of($positions)
            ->addIndexColumn()
            ->addColumn('aksi', function ($position) {
                $btn = '<a href="' . url('/position/' . $position->id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/position/' . $position->id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/position/' . $position->id) . '">' .
                    csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin hapus jabatan ini?\')">Hapus</button></form>';
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

        return view('positions.create', compact('breadcrumb', 'page', 'activeMenu'));
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

        return view('positions.show', compact('breadcrumb', 'page', 'position', 'activeMenu'));
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

        return view('positions.edit', compact('breadcrumb', 'page', 'position', 'activeMenu'));
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
}