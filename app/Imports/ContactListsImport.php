<?php

namespace App\Imports;

use App\Models\City;
use App\Models\State;
use App\Models\ContactList;
use Maatwebsite\Excel\Concerns\ToModel;

class ContactListsImport implements ToModel
{
    protected $subFolderId;

    // Constructor to accept the subFolder ID
    public function __construct($subFolderId)
    {
        $this->subFolderId = $subFolderId;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Assuming 'contact1' and 'contact2' are in columns 7 and 8 respectively
        $contact1 = isset($row[5]) ? (string) $row[5] : null;
        $contact2 = isset($row[6]) ? (string) $row[6] : null;

        // Look up city and state by name
        $city = isset($row[8]) ? City::where('name', $row[8])->first() : null;
        $state = isset($row[9]) ? State::where('name', $row[9])->first() : null;

        return new ContactList([
            'user_id'      => auth()->id(),
            'sub_folder_id' => $this->subFolderId, // Use the passed subfolder ID
            'name'         => $row[0] ?? null,
            'status'       => $row[1] ?? null,
            'company'      => $row[2] ?? null,
            'pic'          => $row[3] ?? null,
            'email'        => $row[4] ?? null,
            'contact1'     => $contact1,
            'contact2'     => $contact2,
            'industry'     => $row[7] ?? null,
            'city_id'      => $city ? $city->id : null,
            'state_id'     => $state ? $state->id : null,
        ]);
    }

}

