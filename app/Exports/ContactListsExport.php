<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\ContactList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ContactListsExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;
    protected $subFolderId;

    public function __construct($startDate, $endDate, $subFolderId)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->subFolderId = $subFolderId;

        // Log the subFolderId to ensure it's passed correctly
        Log::info('ContactListsExport initialized with subFolderId: ' . $subFolderId);
    }

    public function collection()
    {
        // Get the ID of the currently authenticated user
        $userId = Auth::id();

        // Log the subFolderId in the collection method as well
        Log::info('Export collection called with subFolderId: ' . $this->subFolderId);

        // Filter the contact lists based on date range and user ID
        $contactListsQuery = ContactList::with('city', 'state')
            ->where('user_id', $userId); // Add filter for user ID

        if ($this->subFolderId) {
            $contactListsQuery->where('sub_folder_id', $this->subFolderId); // Filter by subFolderId
        }

        if ($this->startDate && $this->endDate) {
            $contactListsQuery->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        return $contactListsQuery->get()->map(function ($contactList) {
            return [
                'name'          => $contactList->name,
                'status'        => $contactList->status ? $contactList->status->name : '-',
                'type'          => $contactList->type ? $contactList->type->name : '-',
                'industry'      => $contactList->industry,
                'company'       => $contactList->company,
                'product'       => $contactList->product,
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
            'Status',
            'Type',
            'Industry',
            'Company',
            'Product',
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

