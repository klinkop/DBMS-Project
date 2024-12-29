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
        // Get the search query and parentFolder ID from the input
        $query = $request->input('squery');
        $parentFolderId = $request->input('parentFolder');

        // Get the authenticated user's ID
        $userId = auth()->id();

        // Initialize the query builder for SubFolder
        $subFolderQuery = SubFolder::with('user')
            ->where('user_id', $userId); // Filter by user ID

        // Check if a parentFolder ID is provided
        if ($parentFolderId) {
            // Filter subfolders by the provided parentFolder ID
            $subFolderQuery->where('parent_folder_id', $parentFolderId);
        }

        // Check if a search query is provided
        if ($query) {
            // Further filter the subfolders by the search query
            $subFolderQuery->where('name', 'LIKE', "%{$query}%");
        }

        // Get the final list of subfolders, ordered by the latest
        $subFolders = $subFolderQuery->latest()->get();

        // Return the view with the subfolders (either filtered or all)
        return view('subFolder.index', [
            'subFolders' => $subFolders,
            'activePage' => 'subFolder',
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
