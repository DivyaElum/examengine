<?php

namespace App\Exports;

use App\Models\QuestionCategoryModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QuestionCategoryExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return collect([
            [
                'category_name' => 'povilas'
            ],
            [
                'category_name' => 'taylor'
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'category name'
        ];
    }
}
