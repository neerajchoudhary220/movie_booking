<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreManagerRequest;
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
        return view('pages.users.create');
    }

    /**
     * Store a newly created resource in storage.
        
     */
    public function store(StoreManagerRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($request->password);
        $manager = User::create($data);
        $manager->assignRole('Manager');
        return redirect()->route('admin.users.index')->with('success', 'Manager added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
