<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Trainer;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * แสดงรายการผู้ใช้ทั้งหมด
     */
    public function index(Request $request)
    {
        $search = $request->search;

        // Users
        $users = User::when($search, function($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        })->paginate(10);

        // Trainers
        $trainers = Trainer::when($search, function($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        })->paginate(10);

        return view('admin.users.index', compact('users', 'trainers'));
    }

    /**
     * แสดงฟอร์มสร้างผู้ใช้ใหม่
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * บันทึกผู้ใช้ใหม่ลงฐานข้อมูล
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'สร้างผู้ใช้ใหม่เรียบร้อยแล้ว');
    }

    /**
     * แสดงรายละเอียดผู้ใช้
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * แสดงฟอร์มแก้ไขผู้ใช้
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * อัปเดตข้อมูลผู้ใช้
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $data = $request->only(['name', 'email']);
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'อัปเดตข้อมูลผู้ใช้เรียบร้อยแล้ว');
    }

    /**
     * ลบผู้ใช้
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'ลบผู้ใช้เรียบร้อยแล้ว');
    }
}
