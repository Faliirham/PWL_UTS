<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use App\Models\Branch;
use App\Models\Position;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Karyawan',
            'list' => ['Home', 'Karyawan']
        ];

        $page = (object)[
            'title' => 'Daftar karyawan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'employee';
        $branches = Branch::all();

        return view('employee.index', compact('breadcrumb', 'page', 'activeMenu', 'branches'));
    }

    public function list(Request $request)
    {
        $employees = Employees::with(['branch', 'position']);

        if ($request->branch_id) {
            $employees->where('branch_id', $request->branch_id);
        }

        return DataTables::of($employees)
            ->addIndexColumn()
            ->addColumn('branch', function ($employee) {
                return $employee->branch->name ?? '-';
            })
            ->addColumn('position', function ($employee) {
                return $employee->position->name ?? '-';
            })
            ->addColumn('aksi', function ($employee) {
                $btn = '<a href="' . url('/employee/' . $employee->id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/employee/' . $employee->id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/employee/' . $employee->id) . '">' .
                    csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin hapus karyawan ini?\')">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Karyawan',
            'list' => ['Home', 'Karyawan', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Karyawan Baru'
        ];

        $branches = Branch::all();
        $positions = Position::all();
        $activeMenu = 'employee';

        return view('employee.create', compact('breadcrumb', 'page', 'branches', 'positions', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'email'       => 'required|email|unique:m_employees,email',
            'phone'       => 'required|string|max:15',
            'branch_id'   => 'required|exists:m_branches,id',
            'position_id' => 'required|exists:m_positions,id',
            'hire_date'   => 'required|date',
           'status'      => 'required|in:active,resign'
        ]);

        Employees::create($request->all());

        return redirect('/employee')->with('success', 'Karyawan berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $employee = Employees::with(['branch', 'position'])->findOrFail($id);

        $breadcrumb = (object)[
            'title' => 'Detail Karyawan',
            'list' => ['Home', 'Karyawan', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Karyawan'
        ];

        $activeMenu = 'employee';

        return view('employee.show', compact('breadcrumb', 'page', 'employee', 'activeMenu'));
    }

    public function edit(string $id)
    {
        $employee = Employees::findOrFail($id);
        $branches = Branch::all();
        $positions = Position::all();

        $breadcrumb = (object)[
            'title' => 'Edit Karyawan',
            'list' => ['Home', 'Karyawan', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Data Karyawan'
        ];

        $activeMenu = 'employee';

        return view('employee.edit', compact('breadcrumb', 'page', 'employee', 'branches', 'positions', 'activeMenu'));
    }

    public function update(Request $request, string $id)
    {
        $employee = Employees::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:100',
            'email'       => 'required|email|unique:m_employees,email,' . $id,
            'phone'       => 'required|string|max:15',
            'branch_id'   => 'required|exists:m_branches,id',
            'position_id' => 'required|exists:m_positions,id',
            'hire_date'   => 'required|date',
            'status'      => 'required|in:active,resigned'
        ]);        

        $employee->update($request->all());

        return redirect('/employee')->with('success', 'Data karyawan berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $employee = Employees::find($id);

        if (!$employee) {
            return redirect('/employee')->with('error', 'Karyawan tidak ditemukan');
        }

        try {
            $employee->delete();
            return redirect('/employee')->with('success', 'Karyawan berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/employee')->with('error', 'Karyawan gagal dihapus karena masih terhubung dengan data lain');
        }
    }
}