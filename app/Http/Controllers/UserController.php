<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreManagerRequest;
use App\Http\Requests\UpdateManagerRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $activeTab = $request->get('tab', 'customers');
        $customers = User::role('Customer')
            ->when($request->filled('q'), function ($q) use ($request) {
                $search = $request->get('q');
                $q->where('name', 'like', "%{$search}%");
            })
            ->latest()->paginate(10);
        $managers = User::role('Manager')
            ->when($request->filled('q'), function ($q) use ($request) {
                $search = $request->get('q');
                $q->where('name', 'like', "%{$search}%");
            })
            ->latest()->paginate(10);

        return view('pages.users.index', compact('activeTab', 'customers', 'managers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = new User();
        return view('pages.users.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
        
     */
    public function store(StoreManagerRequest $request)
    {
        $data = $request->only('name', 'email');
        $data['password'] = Hash::make($request->password);
        $manager = User::create($data);
        $manager->assignRole('Manager');
        return redirect()->route('admin.users.index')->with('success', 'Manager added successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('pages.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateManagerRequest $request, User $user)
    {
        $data = $request->only('name', 'email');
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', 'Manager updated successfully.');
    }
}
