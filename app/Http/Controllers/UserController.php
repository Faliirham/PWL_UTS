<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];

        $page = (object)[
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user';
        $branches = Branch::all(); // Kalau mau filter per cabang

        return view('user.index', compact('breadcrumb', 'page', 'activeMenu', 'branches'));
    }

    public function list(Request $request)
    {
        $users = User::with('branch');

        if ($request->branch_id) {
            $users->where('branch_id', $request->branch_id);
        }

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('branch', function ($user) {
                return $user->branch->name ?? '-';
            })
            ->addColumn('aksi', function ($user) {
                $btn = '<a href="' . url('/user/' . $user->id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/user/' . $user->id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/user/' . $user->id) . '">' .
                    csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin hapus user ini?\')">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah User Baru'
        ];

        $branches = Branch::all();
        $activeMenu = 'user';

        return view('user.create', compact('breadcrumb', 'page', 'branches', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|min:3|unique:m_user,email',
            'password'  => 'required|min:5',
            'role'      => 'required|string',
            'branch_id' => 'required|integer|exists:m_branch,id'
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'branch_id' => $request->branch_id
        ]);

        return redirect('/user')->with('success', 'User berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $user = User::with('branch')->findOrFail($id);

        $breadcrumb = (object)[
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail User'
        ];

        $activeMenu = 'user';

        return view('user.show', compact('breadcrumb', 'page', 'user', 'activeMenu'));
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $branches = Branch::all();

        $breadcrumb = (object)[
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit User'
        ];

        $activeMenu = 'user';

        return view('user.edit', compact('breadcrumb', 'page', 'user', 'branches', 'activeMenu'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|min:3|unique:m_user,email,' . $id . ',id',
            'password'  => 'nullable|min:5',
            'role'      => 'required|string',
            'branch_id' => 'required|integer|exists:m_branches,id'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->branch_id = $request->branch_id;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect('/user')->with('success', 'User berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect('/user')->with('error', 'User tidak ditemukan');
        }

        try {
            $user->delete();
            return redirect('/user')->with('success', 'User berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/user')->with('error', 'User gagal dihapus karena masih terhubung dengan data lain');
        }
    }
}