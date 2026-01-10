<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getDataTable()
    {
        $data = User::latest()->get();
        return \Yajra\DataTables\Facades\DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<div class="btn-group" role="group">';
                $btn .= '<a href="'.route('users.edit', $row->id).'" class="btn btn-sm btn-outline-info" title="Edit"><i class="fa fa-pen"></i></a>';
                $btn .= '<form action="'.route('users.destroy', $row->id).'" method="POST" class="d-inline delete-form">'.csrf_field().method_field('DELETE').'<button type="submit" class="btn btn-sm btn-outline-danger ms-1" onclick="return confirm(\'Are you sure you want to delete this user?\')" title="Delete"><i class="fa fa-trash"></i></button></form>';
                $btn .= '</div>';
                return $btn;
            })
            ->editColumn('created_at', function($row) {
                return $row->created_at->format('M d, Y');
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function getAllUsers()
    {
        return User::all();
    }

    public function createUser(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'] ?? 'admin',
        ]);
    }

    public function updateUser(User $user, array $data)
    {
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'] ?? $user->role,
        ];

        if (!empty($data['password'])) {
            $userData['password'] = Hash::make($data['password']);
        }

        return $user->update($userData);
    }

    public function deleteUser(User $user)
    {
        return $user->delete();
    }
}
