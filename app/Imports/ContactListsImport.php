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
use Illuminate\Support\Facades\Log;

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
        // Log the row data for debugging
        Log::info('Importing row: ', $row);  // This will log the entire row data

        // Skip processing if row is empty
        /* if (empty(array_filter($row))) {
            Log::info('Skipped header row');
            return null;
        }

        // Normalize headers to ensure correct detection
        if ($this->isHeaderRow($row)) {
            Log::info('Skipped header row');
            return null; // Ignore header row
        } */

        // Get status ID based on status name or fallback to default
        $statusId = $this->getStatusId($row['status'] ?? $row[1] ?? 'Unknown');

        // Get type ID based on type name or fallback to default
        $typeId = $this->getTypeId($row['type'] ?? $row[2] ?? 'General');

        // Get state ID based on state name or fallback to a default ID (999)
        $stateId = $this->getStateId($row['state'] ?? $row[11] ?? 'Unknown');

        // Get city ID based on city name or fallback to a default ID (999)
        $cityId = $this->getCityId($row['city'] ?? $row[12] ?? 'Unknown');

        // Insert a new ContactList record
        return new ContactList([
            'user_id'         => $this->userId,
            'sub_folder_id'   => $this->subFolderId,
            'name'            => $row['name'] ?? $row[0] ?? '-',
            'resources'       => $row['resources'] ?? $row[1] ?? '-',  // Ensure proper mapping for resources
            'status_id'       => $statusId,
            'type_id'         => $typeId,
            'industry'        => $row['industry'] ?? $row[3] ?? '-',
            'company'         => $row['company'] ?? $row[4] ?? '-',
            'product'         => $row['product'] ?? $row[5] ?? '-',
            'bgoc_product'    => $row['bgoc_product'] ?? $row[6] ?? '-',  // Ensure proper mapping for bgoc_product
            'pic'             => $row['pic'] ?? $row[7] ?? '-',
            'email'           => $row['email'] ?? $row[8] ?? '-',
            'contact1'        => $row['contact1'] ?? $row[9] ?? '-',
            'contact2'        => $row['contact2'] ?? $row[10] ?? '-',
            'address'         => $row['address'] ?? $row[11] ?? '-',
            'city_id'         => $cityId,
            'state_id'        => $stateId,
            'remarks'         => $row['remarks'] ?? $row[12] ?? '-',
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
        $expectedHeaders = ['name', 'resources', 'status', 'type', 'industry', 'company', 'product', 'bgoc_product', 'pic', 'email', 'contact1', 'contact2', 'address', 'city', 'state', 'remarks'];

        // Normalize and convert row keys to lowercase
        $rowKeys = array_map(function ($key) {
            return strtolower(trim($key));
        }, array_keys($row));

        // Check if any of the normalized keys match the expected headers
        return !empty(array_intersect($expectedHeaders, $rowKeys));
    }

    /**
     * Get the ID of the state based on its name or return a default ID if not found.
     *
     * @param string $stateName
     * @return int
     */
    protected function getStateId($stateName)
    {
        $stateId = State::where('name', $stateName)->pluck('id')->first();
        return $stateId ?: 999; // Return default if not found
    }

    /**
     * Get the ID of the city based on its name or return a default ID if not found.
     *
     * @param string $cityName
     * @return int
     */
    protected function getCityId($cityName)
    {
        $cityId = City::where('name', $cityName)->pluck('id')->first();
        return $cityId ?: 999; // Return default if not found
    }

    /**
     * Get the ID of the status based on its name or return a default if not found.
     *
     * @param string $statusName
     * @return int
     */
    protected function getStatusId($statusName)
    {
        $statusId = Status::where('name', $statusName)->pluck('id')->first();
        return $statusId ?: 1; // Default to status ID 1 if not found
    }

    /**
     * Get the ID of the type based on its name or return a default if not found.
     *
     * @param string $typeName
     * @return int
     */
    protected function getTypeId($typeName)
    {
        $typeId = Type::where('name', $typeName)->pluck('id')->first();
        return $typeId ?: 1; // Default to type ID 1 if not found
    }
}
