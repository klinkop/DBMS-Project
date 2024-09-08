<?php

namespace App\Imports;

use App\Models\ContactList;
use App\Models\State;
use App\Models\City;
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

        // Get state ID based on state name or column index
        $stateId = $this->getStateId($row['state'] ?? $row[9]); // Assuming state name is in column 9 if header is not available

        // Get city ID based on city name or column index
        $cityId = $this->getCityId($row['city'] ?? $row[8]); // Assuming city name is in column 8 if header is not available

        return new ContactList([
            'user_id'         => $this->userId,
            'sub_folder_id'   => $this->subFolderId,
            'name'            => $row['name'] ?? $row[0] ?? 'unknown',
            'status'          => $row['status'] ?? $row[1] ?? 'unknown',
            'company'         => $row['company'] ?? $row[2] ?? 'unknown',
            'pic'             => $row['pic'] ?? $row[3] ?? 'unknown',
            'email'           => $row['email'] ?? $row[4] ?? 'unknown',
            'contact1'        => (string) ($row['contact1'] ?? $row[5] ?? 'unknown'),
            'contact2'        => (string) ($row['contact2'] ?? $row[6] ?? 'unknown'),
            'industry'        => $row['industry'] ?? $row[7] ?? 'unknown',
            'city_id'         => $cityId,
            'state_id'        => $stateId,
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
        $expectedHeaders = ['name', 'status', 'company', 'pic', 'email', 'contact1', 'contact2', 'industry', 'city', 'state'];

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
}
