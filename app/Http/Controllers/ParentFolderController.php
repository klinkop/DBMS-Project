<?php

namespace App\Http\Controllers;

use App\Models\ParentFolder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ParentFolderController extends Controller
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
            // Search for parent folders by name, include the user relationship, and filter by the authenticated user's ID
            $parentFolders = ParentFolder::with('user')
                ->where('user_id', $userId)
                ->where('name', 'LIKE', "%{$query}%")
                ->latest()
                ->paginate(6); // Paginate results, 5 folders per page
        } else {
            // Otherwise, get all parent folders for the authenticated user and include the user relationship
            $parentFolders = ParentFolder::with('user')
                ->where('user_id', $userId)
                ->latest()
                ->paginate(6); // Paginate results, 5 folders per page
        }

        // Return the view with the parent folders (either filtered or all)
        return view('parentFolder.index', [
            'parentFolders' => $parentFolders,
            'activePage' => 'parentFolder',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('parentFolder.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request):RedirectResponse
    {
        // To save the the inputs from users
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $request->user()->parentFolder()->create($validated);

        return redirect(route('parentFolder.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(ParentFolder $parentFolder):View
    {
        return view('parentFolder.show', [
            'parentFolder' => $parentFolder,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ParentFolder $parentFolder):View
    {
        // Enable users to edit content
        Gate::authorize('update', $parentFolder);
        return view('parentFolder.edit', [
            'parentFolder' => $parentFolder,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ParentFolder $parentFolder): RedirectResponse
    {
        //Enable users to pass on the updated content to an existed instance
        Gate::authorize('update', $parentFolder);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $parentFolder->update($validated);

        return redirect(route('parentFolder.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParentFolder $parentFolder): RedirectResponse
    {
        // Enable system to delete parent folder
        Gate::authorize('delete', $parentFolder);

        $parentFolder->delete();

        return redirect(route('parentFolder.index'));
    }

}
