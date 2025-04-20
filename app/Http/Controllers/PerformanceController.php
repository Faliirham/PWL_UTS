<?php

namespace App\Http\Controllers;

use App\Models\Performance;
use App\Models\Employees;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PerformanceController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Penilaian Kinerja',
            'list' => ['Home', 'Performance']
        ];
    
        $page = (object)[
            'title' => 'Daftar Penilaian Kinerja'
        ];
    
        $activeMenu = 'performance';
    
        // Ambil data karyawan untuk filter
        $employees = Employees::all(); // Sesuaikan dengan model karyawan yang ada di aplikasi kamu
    
        return view('performance.index', compact('breadcrumb', 'page', 'activeMenu', 'employees'));
    }    

    public function list(Request $request)
    {
        $performances = Performance::with(['employee', 'evaluator'])->get();

        return DataTables::of($performances)
            ->addIndexColumn()
            ->addColumn('aksi', function ($performance) {
                $btn = '<a href="' . url('/performance/' . $performance->id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/performance/' . $performance->id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/performance/' . $performance->id) . '">' . 
                    csrf_field() . method_field('DELETE') . 
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin hapus penilaian ini?\')">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Penilaian Kinerja',
            'list' => ['Home', 'Performance', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Penilaian Kinerja Baru'
        ];

        $activeMenu = 'performance';

        // Ambil daftar karyawan dan evaluator
        $employees = Employees::all();
        $evaluators = User::where('role', 'admin')->get();

        return view('performance.create', compact('breadcrumb', 'page', 'activeMenu', 'employees', 'evaluators'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id'   => 'required|exists:m_employees,id',
            'evaluator_id'  => 'required|exists:m_user,id',
            'score'         => 'required|numeric',
            'notes'         => 'nullable|string',
            'evaluation_date'=> 'required|date'
        ]);

        Performance::create([
            'employee_id'   => $request->employee_id,
            'evaluator_id'  => $request->evaluator_id,
            'score'         => $request->score,
            'notes'         => $request->notes,
            'evaluation_date'=> $request->evaluation_date
        ]);

        return redirect('/performance')->with('success', 'Penilaian kinerja berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $performance = Performance::with(['employee', 'evaluator'])->findOrFail($id);

        $breadcrumb = (object)[
            'title' => 'Detail Penilaian Kinerja',
            'list' => ['Home', 'Performance', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Penilaian Kinerja'
        ];

        $activeMenu = 'performance';

        return view('performance.show', compact('breadcrumb', 'page', 'performance', 'activeMenu'));
    }

    public function edit(string $id)
    {
        $performance = Performance::with(['employee', 'evaluator'])->findOrFail($id);

        $breadcrumb = (object)[
            'title' => 'Edit Penilaian Kinerja',
            'list' => ['Home', 'Performance', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Penilaian Kinerja'
        ];

        $activeMenu = 'performance';

        // Ambil daftar karyawan dan evaluator
        $employees = Employees::all();
        $evaluators = User::where('role', 'admin')->get();

        return view('performance.edit', compact('breadcrumb', 'page', 'performance', 'activeMenu', 'employees', 'evaluators'));
    }

    public function update(Request $request, string $id)
    {
        $performance = Performance::findOrFail($id);

        $request->validate([
            'employee_id'   => 'required|exists:m_employees,id',
            'evaluator_id'  => 'required|exists:m_user,id',
            'score'         => 'required|numeric',
            'notes'         => 'nullable|string',
            'evaluation_date'=> 'required|date'
        ]);

        $performance->employee_id = $request->employee_id;
        $performance->evaluator_id = $request->evaluator_id;
        $performance->score = $request->score;
        $performance->notes = $request->notes;
        $performance->evaluation_date = $request->evaluation_date;
        $performance->save();

        return redirect('/performance')->with('success', 'Penilaian kinerja berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $performance = Performance::find($id);

        if (!$performance) {
            return redirect('/performance')->with('error', 'Penilaian kinerja tidak ditemukan');
        }

        try {
            $performance->delete();
            return redirect('/performance')->with('success', 'Penilaian kinerja berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/performance')->with('error', 'Penilaian kinerja gagal dihapus karena masih terhubung dengan data lain');
        }
    }
}