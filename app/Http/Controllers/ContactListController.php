<?php

namespace App\Http\Controllers;

use App\Models\ContactList;
use App\Models\State;
use App\Models\City;
use App\Models\SubFolder;
use App\Models\Status;
use App\Models\Type;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use App\Exports\ContactListsExport;
use App\Imports\ContactListsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use App\Exports\TemplateExport;

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
        $resources = $request->input('resources');
        $statusId = $request->input('status_id');
        $typeId = $request->input('type_id');
        $company = $request->input('company');
        $bgoc_product = $request->input('bgoc_product');
        $product = $request->input('product');
        $contact1 = $request->input('contact1');
        $contact2 = $request->input('contact2');
        $pic = $request->input('pic');
        $email = $request->input('email');
        $address = $request->input('address');


        // Get the subFolder ID from the request query parameters
        $subFolderId = $request->query('subFolder');

        Log::info('SubFolder ID part 1:', [$subFolderId]);
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
        if ($resources) {
            $query->where('resources', 'like', '%' . $resources . '%');
        }

        if ($statusId) {
            $query->where('status_id', 'like', '%' . $statusId . '%');
        }

        if ($typeId) {
            $query->where('type_id', 'like', '%' . $typeId . '%');
        }

        if ($company) {
            $query->where('company', 'like', '%' . $company . '%');
        }
        if ($bgoc_product) {
            $query->where('bgoc_product', 'like', '%' . $bgoc_product . '%');
        }

        if ($product) {
            $query->where('product', 'like', '%' . $product . '%');
        }

        if ($contact1) {
            $query->where('contact1', 'like', '%' . $contact1 . '%');
        }

        if ($contact2) {
            $query->where('contact2', 'like', '%' . $contact2 . '%');
        }

        if ($pic) {
            $query->where('pic', 'like', '%' . $pic . '%');
        }

        if ($email) {
            $query->where('email', 'like', '%' . $email . '%');
        }

        if ($address) {
            $query->where('address', 'like', '%' . $address . '%');
        }

        if ($subFolderId) {
            Log::info('Filtering by SubFolder ID:', [$subFolderId]); // Log the subFolderId
            $query->where('sub_folder_id', $subFolderId); // Ensure this matches your DB column name
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
        return view('contactList.index', [
            'contactLists' => $contactLists,
            'subFolders' => $subFolders,
            'statuses' => $statuses,
            'types' => $types,
            'states' => $states,
            'cities' => $cities,
            'subFolderId' => $subFolderId,
            'activePage' => 'contactList' // Manually passing 'activePage'
        ]);
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
            'resources' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'bgoc_company' => 'nullable|string|max:255',
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
        $contactList->resources = $validated['resources'] ?? null;
        $contactList->company = $validated['company'] ?? null;
        $contactList->product = $validated['product'] ?? null;
        $contactList->bgoc_product = $validated['bgoc_product'] ?? null;
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
    public function edit(ContactList $contactList, Request $request): View
{
    $statuses = Status::all();
    $types = Type::all();
    $states = State::all();
    $cities = City::all();

    Gate::authorize('update', $contactList);

    // Get the subFolderId from the request if it exists
    $subFolderId = $request->query('subFolder');

    // Log the values for debugging
    Log::info('Editing contact list', [
        'contactList' => $contactList,
        'subFolder' => $subFolderId,
    ]);

    return view('contactList.edit', [
        'statuses' => $statuses,
        'types' => $types,
        'states' => $states,
        'cities' => $cities,
        'contactList' => $contactList,
        'subFolderId' => $subFolderId, // Pass subFolderId to the view
    ]);
}



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactList $contactList): RedirectResponse
    {
        Gate::authorize('update', $contactList);

        // Log the request data for debugging
        Log::info('Updating contact list', [
            'contactListId' => $contactList->id,
            'requestData' => $request->all(),
        ]);

        // Validate and update the contact list
        $contactList->update($request->except('subFolderId')); // Ensure subFolderId is not updated

        // Retrieve the subFolderId from the request
        $subFolderId = $request->input('subFolderId');

        // Redirect with subFolderId
        return redirect()->route('contactList.index', ['subFolder' => $subFolderId])
                        ->with('success', 'Contact List updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,ContactList $contactList): RedirectResponse
    {
        Gate::authorize('delete', $contactList);
        $subFolderId = $request->input('subFolderId'); // Retrieve subFolderId from the form data
        $contactList->delete();
        return redirect()->route('contactList.index', ['subFolder' => $subFolderId])
                     ->with('success', 'Contact deleted successfully.');
    }

    public function export(Request $request)
    {
        // Log all request parameters
        Log::info('Export Request Parameters:', $request->all());

        // Get filters from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $subFolderId = $request->input('subFolder');
        $stateId = $request->input('state_id');
        $cityId = $request->input('city_id');
        $industry = $request->input('industry');
        $resources = $request->input('resources');
        $statusId = $request->input('status_id');
        $typeId = $request->input('type_id');
        $company = $request->input('company');
        $product = $request->input('product');
        $bgoc_product = $request->input('bgoc_product');
        $contact1 = $request->input('contact1');
        $contact2 = $request->input('contact2');
        $pic = $request->input('pic');
        $email = $request->input('email');
        $address = $request->input('address');

         // Log specific parameters
         Log::info('Start Date:', [$startDate]);
         Log::info('End Date:', [$endDate]);
         Log::info('SubFolder ID:', [$subFolderId]);

        // Validate the date range
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Pass all filters to the export class
        return Excel::download(
            new ContactListsExport(
                $startDate, $endDate, $subFolderId, $stateId, $cityId, $industry,
                $resources, $statusId, $typeId, $company, $product, $bgoc_product,
                $contact1, $contact2, $pic, $email, $address
            ),
            'contact_lists.xlsx'
        );
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
        $data = $request->only(['status_id','resources','product','type_id','bgoc_product','company','pic','industry', 'city_id', 'state_id']);

        // Filter out any null or empty fields
        $filteredData = array_filter($data, function ($value) {
            return !is_null($value) && $value !== '';
        });

        // Update the selected contacts
        ContactList::whereIn('id', $contactIds)->update($filteredData);

        return redirect()->back()->with('success', 'Contacts updated successfully!');
    }

    public function downloadTemplate()
    {
        $headers = [
            'resources', 'status', 'type', 'industry', 'company',
            'product', 'bgoc_product', 'pic', 'email', 'contact1', 'contact2',
            'address', 'city', 'state', 'remarks'
        ];

        $template = collect([$headers]); // Create a collection with the headers as the first row

        // Create and download the Excel file
        return Excel::download(new \App\Exports\TemplateExport($template), 'contact_list_template.xlsx');
    }
}
