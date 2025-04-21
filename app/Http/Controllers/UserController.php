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
                // $btn = '<a href="' . url('/user/' . $user->id) . '" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="' . url('/user/' . $user->id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/user/' . $user->id) . '">' .
                //     csrf_field() . method_field('DELETE') .
                //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin hapus user ini?\')">Hapus</button></form>';
                $btn = '<button onclick="modalAction(\''.url('/user/' . $user->id .'/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';

                $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->id .'/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';

                $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->id .'/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
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
            'branch_id' => 'required|integer|exists:m_branches,id'
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

        public function create_ajax()
    {
        $branches = Branch::select('id', 'name')->get();
        return view('user.create_ajax')->with('branches', $branches);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'name'      => 'required|string|max:100',
                'email'     => 'required|email|min:3|unique:m_user,email',
                'password'  => 'required|min:5',
                'role'      => 'required|string',
                'branch_id' => 'required|integer|exists:m_branches,id'
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
                User::create([
                    'name'      => $request->name,
                    'email'     => $request->email,
                    'password'  => Hash::make($request->password),
                    'role'      => $request->role,
                    'branch_id' => $request->branch_id,
                ]);

                return response()->json([
                    'status'  => true,
                    'message' => 'Data user berhasil disimpan'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Terjadi kesalahan saat menyimpan data'
                ]);
            }
        }

        return redirect('/');
    }

    public function edit_ajax(string $id){
        $user = User::findOrFail($id);
        $branches = Branch::all();

        return view('user.edit_ajax', ['user'=>$user, 'branches'=>$branches]);
    }

    public function update_ajax(Request $request, $id)
    {
        // Cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            
            // Aturan validasi
            $rules = [
                'name' => 'required|min:3|max:100',             // Sesuai dengan validasi di JS
                'email' => 'required|email',                     // Sesuai dengan validasi di JS
                'password' => 'nullable|min:6|max:20',           // Password bersifat opsional (jika kosong, tidak perlu divalidasi)
                'role' => 'required',                             // Role harus diisi
                'branch_id' => 'required'                        // Cabang harus diisi
            ];

            // Validasi request
            $validator = Validator::make($request->all(), $rules);

            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,  // respon json, true jika berhasil, false jika gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // Menunjukkan field mana yang error
                ]);
            }

            // Mencari data user berdasarkan ID
            $user = User::find($id);
            
            // Jika user ditemukan
            if ($user) {
                // Jika password kosong, hapus field password dari request
                if (!$request->filled('password')) {
                    $request->request->remove('password');
                }
                
                // Update data user dengan data yang valid
                $user->update($request->all());
                
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data user tidak ditemukan'
                ]);
            }
        }
        // Jika bukan ajax, redirect ke halaman utama
        return redirect('/');
    }

    public function confirm_ajax (string $id){
        $user = User::find($id);
        $branches = Branch::all();

        return view('user.confirm_ajax',['user' => $user, 'branches'=>$branches]);
    }

    public function delete_ajax (Request $request, $id){
        
        if ($request->ajax() || $request->wantsJson()) {
            $user=User::find($id);
            if ($user) {
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/user');
    }
    public function show_ajax($id)
    {
        $user = User::find($id);
        
        if ($user) {
            $user->load('branch');
        }
        $data = [
            'user' => $user
        ];
        return view('user.show_ajax', $data);
    }
}