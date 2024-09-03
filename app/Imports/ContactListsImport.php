<?php

namespace App\Imports;

use App\Models\City;
use App\Models\State;
use App\Models\ContactList;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContactListsImport implements ToModel, WithHeadingRow
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
        // Use column headers from the file
        $contact1 = isset($row['contact1']) ? (string) $row['contact1'] : '';
        $contact2 = isset($row['contact2']) ? (string) $row['contact2'] : '';
        $name = isset($row['name']) ? (string) $row['name'] : '';
        $status = isset($row['status']) ? (string) $row['status'] : '';
        $company = isset($row['company']) ? (string) $row['company'] : '';
        $pic = isset($row['pic']) ? (string) $row['pic'] : '';
        $email = isset($row['email']) ? (string) $row['email'] : '';
        $industry = isset($row['industry']) ? (string) $row['industry'] : '';

        // Look up city and state by name
        $city = isset($row['city']) ? City::where('name', $row['city'])->first() : null;
        $state = isset($row['state']) ? State::where('name', $row['state'])->first() : null;

        return new ContactList([
            'user_id'      => auth()->id(),
            'sub_folder_id' => $this->subFolderId, // Use the passed subfolder ID
            'name'         => $name,
            'status'       => $status,
            'company'      => $company,
            'pic'          => $pic,
            'email'        => $email,
            'contact1'     => $contact1,
            'contact2'     => $contact2,
            'industry'     => $industry,
            'city_id'      => $city ? $city->id : 999,
            'state_id'     => $state ? $state->id : 999,
        ]);
    }
}
