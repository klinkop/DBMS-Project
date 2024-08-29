<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\ContactList;
use Illuminate\Support\Facades\Auth;

class ContactListsExport implements FromCollection
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        // Get the ID of the currently authenticated user
        $userId = Auth::id();

        // Filter the contact lists based on date range and user ID
        $contactListsQuery = ContactList::with('city', 'state')
            ->where('user_id', $userId); // Add filter for user ID

        if ($this->startDate && $this->endDate) {
            $contactListsQuery->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        return $contactListsQuery->get()->map(function ($contactList) {
            return [
                'name'          => $contactList->name,
                'status'        => $contactList->status,
                'company'       => $contactList->company,
                'pic'           => $contactList->pic,
                'email'         => $contactList->email,
                'contact1'      => $contactList->contact1,
                'contact2'      => $contactList->contact2,
                'industry'      => $contactList->industry,
                'city'          => $contactList->city->name,
                'state'         => $contactList->state->name,
            ];
        });
    }
}
