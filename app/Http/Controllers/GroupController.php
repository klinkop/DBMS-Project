<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupContact;
use App\Models\ContactList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = $request->input('squery');

        if ($query) {
            $groups = Group::with('user')
                ->where('name', 'LIKE', "%{$query}%")
                ->latest()
                ->get();
        } else {
            $groups = Group::with('user')
                ->latest()
                ->get();
        }

        return view('groups.index', [
            'groups' => $groups,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $request->user()->groups()->create($validated);

        return redirect(route('groups.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group): View
    {
        Gate::authorize('update',  $group);

        // fetch the contact list
        $contactLists = ContactList::all();

        $groupContacts = GroupContact::where('group_id', $group->id)->get();

        return view('groups.edit', [
            'group' => $group,
            'contactLists' => $contactLists,
            'groupContacts' => $groupContacts,
        ]);
    }

    /**
     * Add new GroupContact method
     */
    public function addGroupContact(Request $request, Group $group): RedirectResponse
    {
        $validated = $request->validate([
            'contact_list_id' => 'required|integer|exists:contact_list, id',
        ]);

        $groupContacts = new GroupContact();
        $groupContacts->group_id = $group->id;
        $groupContacts->contact_list_id = $validated['contact_list_id'];
        $groupContacts->save();

        return redirect()->back()->with()('success', 'Contact added succesfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group): RedirectResponse
    {
        Gate::authorize('update', $group);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $group->update($validated);

        return redirect(route('groups.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group): RedirectResponse
    {
        Gate::authorize('delete', $group);

        $group->delete();

        return redirect(route('groups.index'));
    }
}
