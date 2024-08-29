<?php

namespace App\Http\Controllers;

use App\Models\ContactList;
use App\Models\State;
use App\Models\City;
use App\Models\SubFolder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use App\Exports\ContactListsExport;
use App\Imports\ContactListsImport;
use Maatwebsite\Excel\Facades\Excel;

class ContactListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $stateId = $request->input('state_id');
        $cityId = $request->input('city_id');
        $search = $request->input('search');
        $industry = $request->input('industry');
        // Prepare the query for ContactList for the logged-in user
        $query = ContactList::with('city', 'state', 'user', 'subFolder')
                            ->where('user_id', auth()->id());

        // Apply filters
        if ($stateId) {
            $query->where('state_id', $stateId);
        }

        if ($cityId) {
            $query->where('city_id', $cityId);
        }

        if ($industry) {
            $query->where('industry', 'like', '%' . $industry . '%');
        }

        // Search functionality
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('company', 'like', '%' . $search . '%')
                    ->orWhere('pic', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('contact1', 'like', '%' . $search . '%')
                    ->orWhere('contact2', 'like', '%' . $search . '%')
                    ->orWhere('industry', 'like', '%' . $search . '%')
                    ->orWhereHas('subFolder', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            });
        }


        $subFolderId = $request->query('subFolder'); // Get the subFolder ID from the request


        // Apply the subFolder filter if provided
        if ($subFolderId) {
            $query->where('sub_folder_id', $subFolderId);
        }

        // Fetch subfolders for the logged-in user
        $subFolders = SubFolder::where('user_id', auth()->id())->latest()->get();

        // Get paginated contact lists
        $contactLists = $query->latest()->paginate(10);



        // Get states and cities
        $states = State::all();
        $cities = $stateId ? City::where('state_id', $stateId)->get() : collect();

        return view('contactList.index', array_merge(
            compact('contactLists', 'subFolders'),
            [
                'states' => $states,
                'cities' => $cities,
                'subfolders' => $subFolders,
            ]
        ));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(SubFolder $subFolder)
    {
        $states = State::all();
        $cities = City::all();

        return view('contactList.create', [
            'states' => $states,
            'cities' => $cities,
            'subFolder' => $subFolder,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request):RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sub_folder_id' => 'required|integer|exists:sub_folders,id',
            'status' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'pic' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'contact1' => 'required|string|max:20',
            'contact2' => 'required|string|max:20',
            'industry' => 'required|string|max:255',
            'city_id' => 'required|integer|exists:cities,id',
            'state_id' => 'required|integer|exists:states,id',
        ]);

        $contactList = new ContactList();
        $contactList->fill($validated);
        $contactList->sub_folder_id = $validated['sub_folder_id'];
        $contactList->user_id = $request->user()->id;
        $contactList->save();

        return redirect(route('contactList.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactList $contactList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactList $contactList): View
    {
        $states = State::all();
        $cities = City::all();

        Gate::authorize('update', $contactList);

        return view('contactList.edit', [
            'states' => $states,
            'cities' => $cities,
            'contactList' => $contactList,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactList $contactList):RedirectResponse
    {
        Gate::authorize('update', $contactList);

        $contactList->update($request->all());

        return redirect()->route('contactList.index')->with('success', 'Contact List updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactList $contactList):RedirectResponse
    {
        Gate::authorize('delete', $contactList);
        $contactList->delete();
        return redirect(route('contactList.index'));
    }

    public function export(Request $request)
    {
        // Get date range from request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Validate the dates
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Pass the date range to the export class
        return Excel::download(new ContactListsExport($startDate, $endDate), 'contact_lists.xlsx');
    }

    public function import(Request $request)
    {
        // Validate the uploaded file and subfolder ID
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
            'sub_folder_id' => 'sometimes|exists:sub_folders,id',
        ]);

        // Retrieve the subfolder ID from the request
        $subFolderId = $request->input('sub_folder_id', 1);

        // Perform the import
        Excel::import(new ContactListsImport(auth()->id(), $subFolderId), $request->file('file'));

        // Redirect or return a response as needed
        return redirect()->back()->with('success', 'Contacts imported successfully!');
    }
}


