<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\SchoolMajor;
use Illuminate\Http\Request;

class SchoolDataController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | JURUSAN
    |--------------------------------------------------------------------------
    */

    public function majorsIndex(Request $request)
    {
        $query = SchoolMajor::withCount('classes');
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }
        $majors = $query->orderBy('name')->paginate(20)->withQueryString();
        $totalMajors = SchoolMajor::count();
        $totalClasses = SchoolClass::count();
        return view('admin-sekolah.school-data.majors.index', compact('majors', 'totalMajors', 'totalClasses'));
    }

    public function majorsCreate()
    {
        return view('admin-sekolah.school-data.majors.create');
    }

    public function majorsStore(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'code'        => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string', 'max:500'],
            'is_active'   => ['nullable', 'boolean'],
        ], [
            'name.required' => 'Nama jurusan wajib diisi.',
            'name.max'      => 'Nama jurusan maksimal 255 karakter.',
            'code.max'      => 'Kode jurusan maksimal 20 karakter.',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        SchoolMajor::create($validated);

        return redirect()
            ->route('admin-sekolah.school-data.majors.index')
            ->with('success', "Jurusan \"{$validated['name']}\" berhasil ditambahkan.");
    }

    public function majorsEdit(SchoolMajor $major)
    {
        return view('admin-sekolah.school-data.majors.edit', compact('major'));
    }

    public function majorsUpdate(Request $request, SchoolMajor $major)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'code'        => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string', 'max:500'],
            'is_active'   => ['nullable', 'boolean'],
        ], [
            'name.required' => 'Nama jurusan wajib diisi.',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $major->update($validated);

        return redirect()
            ->route('admin-sekolah.school-data.majors.index')
            ->with('success', "Jurusan \"{$major->name}\" berhasil diperbarui.");
    }

    public function majorsDestroy(SchoolMajor $major)
    {
        $name = $major->name;
        $major->delete();

        return redirect()
            ->route('admin-sekolah.school-data.majors.index')
            ->with('success', "Jurusan \"{$name}\" berhasil dihapus.");
    }


    /*
    |--------------------------------------------------------------------------
    | KELAS
    |--------------------------------------------------------------------------
    */

    public function classesIndex(Request $request)
    {
        $query = SchoolClass::with('major')->pkl();

        if ($request->filled('major_id')) {
            $query->where('school_major_id', $request->major_id);
        }

        if ($request->filled('grade')) {
            $query->where('grade', $request->grade);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $classes = $query->orderBy('grade')->orderBy('name')->paginate(20)->withQueryString();
        $majors  = SchoolMajor::active()->orderBy('name')->get();
        $totalMajors = SchoolMajor::count();
        $totalClasses = SchoolClass::pkl()->count();

        return view('admin-sekolah.school-data.classes.index', compact('classes', 'majors', 'totalMajors', 'totalClasses'));
    }

    public function classesCreate()
    {
        $majors = SchoolMajor::active()->orderBy('name')->get();
        return view('admin-sekolah.school-data.classes.create', compact('majors'));
    }

    public function classesStore(Request $request)
    {
        $validated = $request->validate([
            'name'             => ['required', 'string', 'max:100'],
            'grade'            => ['nullable', 'string', 'max:10'],
            'school_major_id'  => ['nullable', 'exists:school_majors,id'],
            'is_active'        => ['nullable', 'boolean'],
        ], [
            'name.required'            => 'Nama kelas wajib diisi.',
            'school_major_id.exists'   => 'Jurusan yang dipilih tidak valid.',
        ]);

        $validated['grade']     = $validated['grade'] ?: 'XII';
        $validated['is_active'] = $request->boolean('is_active', true);

        SchoolClass::create($validated);

        return redirect()
            ->route('admin-sekolah.school-data.classes.index')
            ->with('success', "Kelas \"{$validated['name']}\" berhasil ditambahkan.");
    }

    public function classesEdit(SchoolClass $class)
    {
        $majors = SchoolMajor::active()->orderBy('name')->get();
        return view('admin-sekolah.school-data.classes.edit', compact('class', 'majors'));
    }

    public function classesUpdate(Request $request, SchoolClass $class)
    {
        $validated = $request->validate([
            'name'            => ['required', 'string', 'max:100'],
            'grade'           => ['nullable', 'string', 'max:10'],
            'school_major_id' => ['nullable', 'exists:school_majors,id'],
            'is_active'       => ['nullable', 'boolean'],
        ], [
            'name.required' => 'Nama kelas wajib diisi.',
        ]);

        $validated['grade']     = $validated['grade'] ?: 'XII';
        $validated['is_active'] = $request->boolean('is_active', true);

        $class->update($validated);

        return redirect()
            ->route('admin-sekolah.school-data.classes.index')
            ->with('success', "Kelas \"{$class->name}\" berhasil diperbarui.");
    }

    public function classesDestroy(SchoolClass $class)
    {
        $name = $class->name;
        $class->delete();

        return redirect()
            ->route('admin-sekolah.school-data.classes.index')
            ->with('success', "Kelas \"{$name}\" berhasil dihapus.");
    }


    /*
    |--------------------------------------------------------------------------
    | API — untuk dropdown dinamis di form registrasi
    |--------------------------------------------------------------------------
    */

    /**
     * Kembalikan kelas berdasarkan jurusan (untuk dropdown Ajax).
     */
    public function classesByMajor(SchoolMajor $major)
    {
        $classes = $major->classes()->active()->orderBy('name')->get(['id', 'name', 'grade']);
        return response()->json($classes);
    }
}
