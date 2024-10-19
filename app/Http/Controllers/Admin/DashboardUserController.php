<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Hash;

class DashboardUserController extends Controller
{
    public function index()
    {
        $dashboardUsers = AdminUser::latest()->paginate(10);
        return view('admin.dashboard-users.index', compact('dashboardUsers'));
    }

    public function create()
    {
        return view('admin.dashboard-users.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admin_users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        AdminUser::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return redirect()->route('admin.dashboard-users.index')->with('success', 'New user created successfully');
    }

    public function edit($id)
    {
        $user = AdminUser::findOrFail($id);
        return view('admin.dashboard-users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = AdminUser::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admin_users,email,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        return redirect()->route('admin.dashboard-users.index')->with('success', 'User updated successfully');
    }

    public function destroy(AdminUser $dashboardUser)
    {
        // Prevent deleting the last admin user
        if (AdminUser::count() > 1) {
            $dashboardUser->delete();
            return redirect()->route('admin.dashboard-users.index')->with('success', 'User deleted successfully');
        } else {
            return redirect()->route('admin.dashboard-users.index')->with('error', 'Cannot delete the last admin user');
        }
    }
}
