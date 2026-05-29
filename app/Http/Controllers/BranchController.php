<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::where('business_id', auth()->user()->business_id)
            ->latest()
            ->paginate(10);

        return Inertia::render('Branches/Index', [
            'branches' => $branches
        ]);
    }

    public function create()
    {
        return Inertia::render('Branches/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'city' => 'nullable|string',
            'country' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        Branch::create([
            'business_id' => auth()->user()->business_id,
            'name' => $request->name,
            'code' => $request->code,
            'city' => $request->city,
            'country' => $request->country,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return redirect()->route('branches.index')
            ->with('success', 'Branch created successfully');
    }

    public function edit(Branch $branch)
    {
        $this->authorizeBranch($branch);

        return Inertia::render('Branches/Edit', [
            'branch' => $branch
        ]);
    }

    public function update(Request $request, Branch $branch)
    {
        $this->authorizeBranch($branch);

        $branch->update($request->all());

        return redirect()->route('branches.index')
            ->with('success', 'Branch updated successfully');
    }

    public function destroy(Branch $branch)
    {
        $this->authorizeBranch($branch);

        $branch->delete();

        return redirect()->back()
            ->with('success', 'Branch deleted successfully');
    }

    private function authorizeBranch($branch)
    {
        if ($branch->business_id !== auth()->user()->business_id) {
            abort(403, 'Unauthorized');
        }
    }
}