<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
     /**
     * Display the paginated parent folders.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Paginate parent folders
        $parentFolders = Contact::whereNull('parent_id')->paginate(20);

        return view('contact.index', [
            'parentFolders' => $parentFolders
        ]);

    }

    /**
     * Display the paginated child folders.
     *
     * @return \Illuminate\View\View
     */
    public function subindex()
    {
        //Paginate child folders
        $childFolders = Contact::paginate(20);

        return view('contact.sub-index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contact.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'string|max:255',
            'SC' => 'string|max:255',
            'status' => 'string|max:255',
            'company' => 'string|max:255',
            'pic' => 'string|max:255',
            'email' => 'string|max:255',
            'contact1' => 'string|max:255',
            'contact2' => 'string|max:255',
            'industry' => 'string|max:255',
            'city' => 'string|max:255',
            'state' => 'string|max:255',
        ]);

        Contact::create([
            'name' => $request->name,
            'SC' => $request->SC,
            'status' => $request->status,
            'company' => $request->company,
            'pic' => $request->pic,
            'email' => $request->email,
            'contact1' =>$request->contact1,
            'contact2' => $request->contact2,
            'industry' => $request->industry,
            'city' => $request->city,
            'state' => $request->state,
        ]);

        return redirect('/contact')->with('status','Contact Created Succesfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        return view('contact.show',compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        return view('contact.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'name' => 'string|max:255',
            'SC' => 'string|max:255',
            'status' => 'string|max:255',
            'company' => 'string|max:255',
            'pic' => 'string|max:255',
            'email' => 'string|max:255',
            'contact1' => 'string|max:255',
            'contact2' => 'string|max:255',
            'industry' => 'string|max:255',
            'city' => 'string|max:255',
            'state' => 'string|max:255',
        ]);

        $contact->update([
           'name' => $request->name,
            'SC' => $request->SC,
            'status' => $request->status,
            'company' => $request->company,
            'pic' => $request->pic,
            'email' => $request->email,
            'contact1' =>$request->contact1,
            'contact2' => $request->contact2,
            'industry' => $request->industry,
            'city' => $request->city,
            'state' => $request->state,
        ]);

        return redirect('/contact')->with('status','Category Updated Succesfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect('/contact')->with('status','Contact Deleted Successfully');
    }

    /**
     * Fetch child folders for a given parent folder.
     *
     * @param int $parentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChildFolders($parentId)
    {
        $childFolders = Contact::getChildFolders($parentId);
        return response()->json($childFolders);
    }
}
