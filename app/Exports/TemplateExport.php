<?php

namespace App\Exports;

use App\Models\ContactList;

use Maatwebsite\Excel\Concerns\FromCollection;

class TemplateExport implements FromCollection
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }
}
