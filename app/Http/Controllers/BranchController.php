<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BranchController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Cabang',
            'list' => ['Home', 'Cabang']
        ];

        $page = (object)[
            'title' => 'Daftar cabang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'branch';

        // Ambil daftar kota unik untuk filter
        $cities = Branch::select('city')->distinct()->pluck('city');

        return view('branch.index', compact('breadcrumb', 'page', 'activeMenu', 'cities'));
    }

    public function list(Request $request)
    {
        $branches = Branch::query();

        if ($request->city) {
            $branches->where('city', $request->city);
        }

        return DataTables::of($branches)
            ->addIndexColumn()
            ->addColumn('aksi', function ($branch) {
                $btn = '<a href="' . url('/branch/' . $branch->id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/branch/' . $branch->id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/branch/' . $branch->id) . '">' .
                    csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin hapus cabang ini?\')">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Cabang',
            'list' => ['Home', 'Cabang', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Cabang Baru'
        ];

        $activeMenu = 'branch';

        return view('branch.create', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'city'    => 'required|string|max:100',
            'phone'   => 'required|string|max:20'
        ]);

        Branch::create($request->all());

        return redirect('/branch')->with('success', 'Cabang berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $branch = Branch::findOrFail($id);

        $breadcrumb = (object)[
            'title' => 'Detail Cabang',
            'list' => ['Home', 'Cabang', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Cabang'
        ];

        $activeMenu = 'branch';

        return view('branch.show', compact('breadcrumb', 'page', 'branch', 'activeMenu'));
    }

    public function edit(string $id)
    {
        $branch = Branch::findOrFail($id);

        $breadcrumb = (object)[
            'title' => 'Edit Cabang',
            'list' => ['Home', 'Cabang', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Cabang'
        ];

        $activeMenu = 'branch';

        return view('branch.edit', compact('breadcrumb', 'page', 'branch', 'activeMenu'));
    }

    public function update(Request $request, string $id)
    {
        $branch = Branch::findOrFail($id);

        $request->validate([
            'name'    => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'city'    => 'required|string|max:100',
            'phone'   => 'required|string|max:20'
        ]);

        $branch->update($request->all());

        return redirect('/branch')->with('success', 'Cabang berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $branch = Branch::find($id);

        if (!$branch) {
            return redirect('/branch')->with('error', 'Cabang tidak ditemukan');
        }

        try {
            $branch->delete();
            return redirect('/branch')->with('success', 'Cabang berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/branch')->with('error', 'Cabang gagal dihapus karena masih terhubung dengan data lain');
        }
    }
}