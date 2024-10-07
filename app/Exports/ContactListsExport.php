<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\ContactList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ContactListsExport implements FromCollection, WithHeadings
{
    protected $startDate, $endDate, $subFolderId, $stateId, $cityId, $industry, $resources, $statusId,
    $typeId, $company, $product, $bgoc_product, $contact1, $contact2, $pic, $email, $address;

    public function __construct(
        $startDate, $endDate, $subFolderId, $stateId, $cityId, $industry, $resources, $statusId,
        $typeId, $company, $product, $bgoc_product, $contact1, $contact2, $pic, $email, $address
    ) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->subFolderId = $subFolderId;
        $this->stateId = $stateId;
        $this->cityId = $cityId;
        $this->industry = $industry;
        $this->resources = $resources;
        $this->statusId = $statusId;
        $this->typeId = $typeId;
        $this->company = $company;
        $this->product = $product;
        $this->bgoc_product = $bgoc_product;
        $this->contact1 = $contact1;
        $this->contact2 = $contact2;
        $this->pic = $pic;
        $this->email = $email;
        $this->address = $address;

        Log::info('Export class initialized with parameters:', [
            'subFolder' => $this->subFolderId,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'state_id' => $this->stateId,
            'city_id' => $this->cityId,
            'industry' => $this->industry,
            'resources' => $this->resources,
            'status_id' => $this->statusId,
            'type_id' => $this->typeId,
            'company' => $this->company,
            'product' => $this->product,
            'bgoc_product' => $this->bgoc_product,
            'contact1' => $this->contact1,
            'contact2' => $this->contact2,
            'pic' => $this->pic,
            'email' => $this->email,
            'address' => $this->address,
        ]);
    }

    public function collection()
{
    // Get the ID of the currently authenticated user
    $userId = Auth::id();

    // Log the subFolderId in the collection method as well
    Log::info('Export collection called with subFolderId: ' . $this->subFolderId);

    // Filter the contact lists based on user ID
    $contactListsQuery = ContactList::with('city', 'state')
        ->where('user_id', $userId); // Add filter for user ID

    // Filter by subFolderId if provided
    if ($this->subFolderId) {
        $contactListsQuery->where('sub_folder_id', $this->subFolderId);
    }

    // Filter by date range if provided
    if ($this->startDate && $this->endDate) {
        $contactListsQuery->whereBetween('created_at', [$this->startDate, $this->endDate]);
    }

    // Add filters based on the other fields
    if ($this->stateId) {
        $contactListsQuery->where('stateId', $this->stateId);
    }

    if ($this->cityId) {
        $contactListsQuery->where('cityId', $this->cityId);
    }

    if ($this->industry) {
        $contactListsQuery->where('industry', 'like', '%' . $this->industry . '%');
    }

    if ($this->resources) {
        $contactListsQuery->where('resources', 'like', '%' . $this->resources . '%');
    }

    if ($this->statusId) {
        $contactListsQuery->where('status_id', $this->statusId);
    }

    if ($this->typeId) {
        $contactListsQuery->where('type_id', $this->typeId);
    }

    if ($this->company) {
        $contactListsQuery->where('company', 'like', '%' . $this->company . '%');
    }

    if ($this->product) {
        $contactListsQuery->where('product', 'like', '%' . $this->product . '%');
    }

    if ($this->bgoc_product) {
        $contactListsQuery->where('bgoc_product', 'like', '%' . $this->bgoc_product . '%');
    }

    if ($this->contact1) {
        $contactListsQuery->where('contact1', 'like', '%' . $this->contact1 . '%');
    }

    if ($this->contact2) {
        $contactListsQuery->where('contact2', 'like', '%' . $this->contact2 . '%');
    }

    if ($this->pic) {
        $contactListsQuery->where('pic', 'like', '%' . $this->pic . '%');
    }

    if ($this->email) {
        $contactListsQuery->where('email', 'like', '%' . $this->email . '%');
    }

    if ($this->address) {
        $contactListsQuery->where('address', 'like', '%' . $this->address . '%');
    }

     // Log the generated query for debugging
     Log::info('Generated query: ' . $contactListsQuery->toSql());

    // Execute the query and map the results
    return $contactListsQuery->get()->map(function ($contactList) {
        return [
            'name'          => $contactList->name,
            'resources'     => $contactList->resources ? $contactList->resources : '-',  // Add null check
            'status'        => $contactList->status ? $contactList->status->name : '-',
            'type'          => $contactList->type ? $contactList->type->name : '-',
            'industry'      => $contactList->industry,
            'company'       => $contactList->company,
            'product'       => $contactList->product,
            'bgoc_product'  => $contactList->bgoc_product ? $contactList->bgoc_product : '-',  // Add null check
            'pic'           => $contactList->pic,
            'email'         => $contactList->email,
            'contact1'      => $contactList->contact1,
            'contact2'      => $contactList->contact2,
            'address'       => $contactList->address,
            'city'          => $contactList->city ? $contactList->city->name : '-',
            'state'         => $contactList->state ? $contactList->state->name : '-',
            'remarks'       => $contactList->remarks,
        ];
    });
}


    public function headings(): array
    {
        return [
            'Name',
            'Resources',
            'Status',
            'Type',
            'Industry',
            'Company',
            'Product',
            'BGOC_Product',
            'PIC',
            'Email',
            'Contact1',
            'Contact2',
            'Address',
            'City',
            'State',
            'Remarks'
        ];
    }
}

