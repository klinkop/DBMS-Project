<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\ShouldQueue;
use App\Models\ContactList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ShouldQueueWithoutChain;
use Throwable;

class ContactListsExport implements FromQuery, WithHeadings, WithMapping, WithChunkReading, ShouldQueueWithoutChain
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

        Log::info('ContactListsExport initialized with parameters:', [
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'subFolderId' => $this->subFolderId,
            'stateId' => $this->stateId,
            'cityId' => $this->cityId,
            'industry' => $this->industry,
            'resources' => $this->resources,
            'statusId' => $this->statusId,
            'typeId' => $this->typeId,
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

    public function query()
    {
        $userId = Auth::id();

        Log::info('Generating query for export with subFolderId: ' . $this->subFolderId);

        try {
            $contactListsQuery = ContactList::with('city', 'state')
                ->where('user_id', $userId);

            if ($this->subFolderId) {
                $contactListsQuery->where('sub_folder_id', $this->subFolderId);
            }

            if ($this->startDate && $this->endDate) {
                $contactListsQuery->whereBetween('created_at', [$this->startDate, $this->endDate]);
            }

            if ($this->stateId) {
                $contactListsQuery->where('state_id', $this->stateId);
            }

            if ($this->cityId) {
                $contactListsQuery->where('city_id', $this->cityId);
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

            Log::info('Generated query: ' . $contactListsQuery->toSql());

            return $contactListsQuery;
        } catch (Throwable $e) {
            Log::error('Error generating query: ' . $e->getMessage());
            throw $e;
        }
    }

    public function headings(): array
    {
        Log::info('Generating export headings.');
        return [
            'Resources', 'Status', 'Type', 'Industry', 'Company', 'Product', 'BGOC_Product',
            'PIC', 'Email', 'Contact1', 'Contact2', 'Address', 'City', 'State', 'Remarks'
        ];
    }

    public function map($contactList): array
    {
        try {
            Log::info('Mapping contactList ID: ' . $contactList->id);
            return [
                $contactList->resources ? $contactList->resources : '-',
                $contactList->status ? $contactList->status->name : '-',
                $contactList->type ? $contactList->type->name : '-',
                $contactList->industry,
                $contactList->company,
                $contactList->product,
                $contactList->bgoc_product ? $contactList->bgoc_product : '-',
                $contactList->pic,
                $contactList->email,
                $contactList->contact1,
                $contactList->contact2,
                $contactList->address,
                $contactList->city ? $contactList->city->name : '-',
                $contactList->state ? $contactList->state->name : '-',
                $contactList->remarks,
            ];
        } catch (Throwable $e) {
            Log::error('Error mapping contactList ID: ' . $contactList->id . ' - ' . $e->getMessage());
            throw $e;
        }
    }

    public function chunkSize(): int
    {
        Log::info('Exporting in chunks of 1000 rows.');
        return 1000;
    }
}
