<?php

namespace App\Exports\Purchases\RecurringBills\Sheets;

use App\Abstracts\Export;
use App\Models\Document\Document as Model;
use App\Interfaces\Export\WithParentSheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class RecurringBills extends Export implements WithColumnFormatting, WithParentSheet
{
    public function collection()
    {
        return Model::with('category')->billRecurring()->collectForExport($this->ids, ['document_number' => 'desc']);
    }

    public function map($model): array
    {
        $country = null;

        if ($model->contact_country && array_key_exists($model->contact_country, trans('countries'))) {
            $country = trans('countries.' . $model->contact_country);
        }

        $model->category_name = $model->category->name;
        $model->bill_number = $model->document_number;
        $model->billed_at = $model->issued_at;
        $model->contact_country = $country;

        return parent::map($model);
    }

    public function fields(): array
    {
        return [
            'bill_number',
            'order_number',
            'status',
            'billed_at',
            'due_at',
            'amount',
            'discount_type',
            'discount_rate',
            'currency_code',
            'currency_rate',
            'category_name',
            'contact_name',
            'contact_email',
            'contact_tax_number',
            'contact_phone',
            'contact_address',
            'contact_country',
            'contact_state',
            'contact_zip_code',
            'contact_city',
            'title',
            'subheading',
            'notes',
            'template',
            'color',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_DATE_YYYYMMDD,
            'E' => NumberFormat::FORMAT_DATE_YYYYMMDD,
        ];
    }
}
