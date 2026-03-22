<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        
        $users = User::query();

        if ($status && in_array($status, ['Active', 'Inactive'])) {
            $users->where('status', $status);
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
            'name' => 'required|string|max:255', 
            'email' => 'required|email|unique:users,email', 
            'password' => 'required|string|min:8|confirmed', 
            'role' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
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
            'name'       => 'required|string|max:255',
            'contact_no' =>'nullable|string|max:20',
            'address'    => 'nullable|string|max:255',
            'role'       => 'required|string',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'contact_no', 'address']);

        // Handle photo upload
        if ($request->hasFile('photo')) {

            // Deleting old photo if exists
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            // Save new photo
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        // Update user record
        $user->update($data);

        // Update basic info
        //$user->update($request->only('name', 'email'));

        // Update role
        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }

    // Updating Status
    public function toggleStatus(User $user)
    {
        $user->status = $user->status === 'Active' ? 'Inactive' : 'Active';
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User status updated successfully!');
    }

    // Optional: keep role update separate if you want quick dropdown changes
    public function updateRole(Request $request, User $user)
    {
        $user->syncRoles([$request->role]);
        return redirect()->back()->with('success', 'Role updated successfully!');
    }

    public function getData()
    {
        $users = User::with('roles')->select('users.*');

        return DataTables::of($users)
        ->addColumn('photo', function ($user) {
            if ($user->photo) {
                return '<img src="'.asset('storage/'.$user->photo).'" width="50" class="rounded">';
            }
            return '<span class="text-muted">No photo</span>';
        })
        ->addColumn('role', function ($user) {
            return $user->roles->pluck('name')->implode(', ') ?: 'None';
        })
        ->addColumn('status', function ($user) {
            return $user->status === 'Active'
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-danger">Inactive</span>';
        })
        ->addColumn('actions', function ($user) {
            return view('admin.users.partials.actions', compact('user'))->render();
        })
        ->rawColumns(['photo','status','actions'])
        ->make(true);
    }
}
