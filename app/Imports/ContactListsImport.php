<?php

namespace App\Imports;

use App\Models\ContactList;
use App\Models\State;
use App\Models\City;
use App\Models\Status;
use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContactListsImport implements ToModel, WithHeadingRow
{
    protected $subFolderId;
    protected $userId;

    public function __construct($subFolderId)
    {
        $this->subFolderId = $subFolderId;
        $this->userId = Auth::id(); // Get the authenticated user's ID
    }

    public function model(array $row)
    {
        // Skip processing if row is empty
        if (empty(array_filter($row))) {
            return null;
        }

        // Normalize headers to ensure correct detection
        if ($this->isHeaderRow($row)) {
            return null; // Ignore header row
        }

        // Get status ID based on state name or column index
        $statusId = $this->getStatusId($row['status'] ?? $row[1]);

        // Get type ID based on state name or column index
        $typeId = $this->getTypeId($row['type'] ?? $row[2]);

        // Get state ID based on state name or column index
        $stateId = $this->getStateId($row['state'] ?? $row[11]);

        // Get city ID based on city name or column index
        $cityId = $this->getCityId($row['city'] ?? $row[12]);

        return new ContactList([
            'user_id'         => $this->userId,
            'sub_folder_id'   => $this->subFolderId,
            'name'            => $row['name'] ?? $row[0] ?? '-',
            'status_id'       => $statusId,
            'type_id'         => $typeId,
            'industry'        => $row['industry'] ?? $row[3] ?? '-',
            'company'         => $row['company'] ?? $row[4] ?? '-',
            'product'         => $row['product'] ?? $row[5] ?? '-',
            'pic'             => $row['pic'] ?? $row[6] ?? '-',
            'email'           => $row['email'] ?? $row[7] ?? '-',
            'contact1'        => isset($row['contact1']) ? (is_string($row['contact1']) ? $row['contact1'] : (string) $row['contact1']) : '-',
            'contact2'        => isset($row['contact2']) ? (is_string($row['contact2']) ? $row['contact2'] : (string) $row['contact2']) : '-',
            'address'         => $row['address'] ?? $row[10] ?? '-',
            'city_id'         => $cityId,
            'state_id'        => $stateId,
            'remarks'         => $row['remarks'] ?? $row[13] ?? '-',
        ]);
    }

    /**
     * Determine if the row contains headers based on the column names.
     *
     * @param array $row
     * @return bool
     */
    protected function isHeaderRow(array $row): bool
    {
        // Define expected header names in lowercase
        $expectedHeaders = ['Name', 'Status', 'Type', 'Industry', 'Company', 'Product', 'PIC', 'Email', 'Contact 1', 'Contact 2', 'Address', 'Industry', 'City', 'State', 'Remarks'];

        // Normalize and convert row keys to lowercase
        $rowKeys = array_map(function ($key) {
            return strtolower(trim($key));
        }, array_keys($row));

        // Check if any of the normalized keys match the expected headers
        return !empty(array_intersect($expectedHeaders, $rowKeys));
    }

    /**
     * Get the ID of the state based on its name or return 999 if not found.
     *
     * @param string $stateName
     * @return int
     */
    protected function getStateId($stateName)
    {
        $stateId = State::where('name', $stateName)->pluck('id')->first();
        return $stateId ? $stateId : 999;
    }

    /**
     * Get the ID of the city based on its name or return 999 if not found.
     *
     * @param string $cityName
     * @return int
     */
    protected function getCityId($cityName)
    {
        $cityId = City::where('name', $cityName)->pluck('id')->first();
        return $cityId ? $cityId : 999;
    }

    protected function getStatusId($statusName)
    {
        $statusId = Status::where('name', $statusName)->pluck('id')->first();
        return $statusId ? $statusId :  1;
    }

    protected function getTypeId($typeName)
    {
        $typeId = Type::where('name', $typeName)->pluck('id')->first();
        return $typeId ? $typeId : 1;
    }
}

