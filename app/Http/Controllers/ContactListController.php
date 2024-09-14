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

    // Get the subFolder ID from the request query parameters
    $subFolderId = $request->query('subFolder');

    // Prepare the query for ContactList for the logged-in user
    $query = ContactList::with('city', 'state', 'user', 'subFolder')
                        ->where('user_id', auth()->id());

    // Apply filters based on the input
    if ($stateId) {
        $query->where('state_id', $stateId);
    }

    if ($cityId) {
        $query->where('city_id', $cityId);
    }

    if ($industry) {
        $query->where('industry', 'like', '%' . $industry . '%');
    }

    // Apply search functionality
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

    // Apply subFolder filter if provided
    if ($subFolderId) {
        $query->where('sub_folder_id', $subFolderId);
    }

    // Fetch subfolders for the logged-in user
    $subFolders = SubFolder::where('user_id', auth()->id())->latest()->get();

    // Get paginated contact lists
    $contactLists = $query->latest()->paginate(10);

    // Get states and cities for the dropdowns
    $statuses = Status::all();
    $types = Type::all();
    $states = State::all();
    $cities = $stateId ? City::where('state_id', $stateId)->get() : collect();

    // Return the view with the required data
    return view('contactList.index', compact('contactLists', 'subFolders', 'statuses', 'types', 'states', 'cities', 'subFolderId'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create(SubFolder $subFolder)
    {
        $statuses = Status::all();
        $types = Type::all();
        $states = State::all();
        $cities = City::all();

        return view('contactList.create', [
            'statuses' => $statuses,
            'types' => $types,
            'states' => $states,
            'cities' => $cities,
            'subFolder' => $subFolder,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
{
    $validated = $request->validate([
        'name' => 'nullable|string|max:255',
        'sub_folder_id' => 'nullable|integer|exists:sub_folders,id',
        'status_id' => 'nullable|integer|exists:statuses,id',
        'type_id' => 'nullable|integer|exists:types,id',
        'industry' => 'nullable|string|max:255',
        'company' => 'nullable|string|max:255',
        'product' => 'nullable|string|max:255',
        'pic' => 'nullable|string|max:255',
        'email' => 'nullable|string|email|max:255',
        'contact1' => 'nullable|string|max:20',
        'contact2' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'city_id' => 'nullable|integer|exists:cities,id',
        'state_id' => 'nullable|integer|exists:states,id',
        'remarks' => 'nullable|string|max:1000',
    ]);

    $contactList = new ContactList();
    $contactList->fill($validated);
    $contactList->user_id = $request->user()->id;

    // Set default values for required fields if they are not provided
    $contactList->sub_folder_id = $validated['sub_folder_id'] ?? null;
    $contactList->status_id = $validated['status_id'] ?? null;
    $contactList->type_id = $validated['type_id'] ?? null;
    $contactList->industry = $validated['industry'] ?? null;
    $contactList->company = $validated['company'] ?? null;
    $contactList->product = $validated['product'] ?? null;
    $contactList->pic = $validated['pic'] ?? null;
    $contactList->email = $validated['email'] ?? null;
    $contactList->contact1 = $validated['contact1'] ?? null;
    $contactList->contact2 = $validated['contact2'] ?? null;
    $contactList->address = $validated['address'] ?? null;
    $contactList->city_id = $validated['city_id'] ?? 999;
    $contactList->state_id = $validated['state_id'] ?? 999;
    $contactList->remarks = $validated['remarks'] ?? null;

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
        $statuses = Status::all();
        $types = Type::all();
        $states = State::all();
        $cities = City::all();

        Gate::authorize('update', $contactList);

        return view('contactList.edit', [
            'statuses' => $statuses,
            'types' => $types,
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
        // Get filters from request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $subFolderId = $request->input('subFolder'); // Add this to get the subFolderId from the request


        // Validate the date range
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Pass all filters to the export class
        return Excel::download(new ContactListsExport($startDate, $endDate, $subFolderId), 'contact_lists.xlsx');
    }



     public function import(Request $request)
    {
        // Validate the request to ensure the subFolder ID is present and valid
        $request->validate([
            'subFolder' => 'required|exists:sub_folders,id', // Ensure subFolder exists
            'file' => 'required|file|mimes:xlsx,csv', // Validate file input
        ]);

        $subFolderId = $request->input('subFolder'); // Get subFolder ID from request

        // Pass the subFolder ID to the import class
        Excel::import(new ContactListsImport($subFolderId), $request->file('file'));

        return redirect()->back()->with('success', 'Contacts imported successfully.');
    }

    public function massEdit(Request $request)
    {
        // Extract selected contact IDs
        $contactIds = explode(',', $request->input('contact_ids'));

        // Prepare data for update
        $data = $request->only(['status', 'company', 'industry', 'city_id', 'state_id']);

        // Filter out any null or empty fields
        $filteredData = array_filter($data, function($value) {
            return !is_null($value) && $value !== '';
        });

        // Update the selected contacts
        ContactList::whereIn('id', $contactIds)->update($filteredData);

        return redirect()->back()->with('success', 'Contacts updated successfully!');
    }


}


