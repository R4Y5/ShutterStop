<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('is_active');
        
        $users = User::query();

        if ($status && in_array($status, ['Active', 'Inactive'])) {
            $users->where('is_active', $status);
        }

        $users = $users->orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255', 
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email', 
            'password'   => 'required|string|min:8|confirmed', 
            'role'       => 'required|string',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => bcrypt($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,'.$user->id,
            'contact_no' => 'nullable|string|max:20',
            'address'    => 'nullable|string|max:255',
            'role'       => 'required|string',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->only(['first_name','last_name','email','contact_no','address']);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $user->update($data);

        // Update role
        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }

    public function toggleStatus(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();

        return back()->with('success', 'User status updated successfully.');
    }


    public function updateRole(Request $request, User $user)
    {
        $user->syncRoles([$request->role]);
        return redirect()->back()->with('success', 'Role updated successfully!');
    }

    public function getData()
    {
        $users = User::with('roles')->select('users.*');

        return DataTables::of($users)
            ->addColumn('full_name', function ($user) {
                return $user->first_name.' '.$user->last_name;
            })
            ->addColumn('photo', function ($user) {
                if ($user->photo) {
                    return '<img src="'.asset('storage/'.$user->photo).'" width="50" class="rounded">';
                }
                return '<span class="text-muted">No photo</span>';
            })
            ->addColumn('role', function ($user) {
                return $user->roles->pluck('name')->implode(', ') ?: 'None';
            })
            ->addColumn('is_active', function ($user) {
            return $user->is_active
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-danger">Inactive</span>';
})
            ->addColumn('actions', function ($user) {
                return view('admin.users.partials.actions', compact('user'))->render();
            })
            ->rawColumns(['photo','is_active','actions'])
            ->make(true);
    }
}
