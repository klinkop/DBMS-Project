<?php

namespace App\Http\Controllers;

use App\Models\ParentFolder;
use App\Models\SubFolder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class SubFolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // Get the search query from the input
        $query = $request->input('squery');

        // Get the authenticated user's ID
        $userId = auth()->id();

        // Check if a search query is provided
        if ($query) {
            // Search for subfolders by name, include the user relationship, and filter by the authenticated user's ID
            $subFolders = SubFolder::with('user')
                ->where('user_id', $userId) // Filter by user ID
                ->where('name', 'LIKE', "%{$query}%")
                ->latest()
                ->get();
        } else {
            // Otherwise, get all subfolders for the authenticated user and include the user relationship
            $subFolders = SubFolder::with('user')
                ->where('user_id', $userId) // Filter by user ID
                ->latest()
                ->get();
        }

        // Return the view with the subfolders (either filtered or all)
        return view('subFolder.index', [
            'subFolders' => $subFolders,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(ParentFolder $parentFolder)
    {
        return view('subFolder.create', [
            'parentFolder' => $parentFolder,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_folder_id' => 'required|integer|exists:parent_folders,id',
        ]);

        $subFolder = new SubFolder();
        $subFolder->name = $validated['name'];
        $subFolder->parent_folder_id = $validated['parent_folder_id'];
        $subFolder->user_id = $request->user()->id;
        $subFolder->save();

        return redirect(route('subFolder.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(SubFolder $subFolder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubFolder $subFolder):View
    {
        Gate::authorize('update', $subFolder);

        return view('subFolder.edit', [
            'subFolder' => $subFolder,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubFolder $subFolder): RedirectResponse
    {
        Gate::authorize('update', $subFolder);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subFolder->update($validated);

        return redirect(route('subFolder.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubFolder $subFolder):RedirectResponse
    {
        Gate::authorize('delete', $subFolder);

        $subFolder->delete();

        return redirect(route('subFolder.index'));
    }
}
