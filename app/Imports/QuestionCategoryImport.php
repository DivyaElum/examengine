<?php

namespace App\Imports;

use Illuminate\Validation\Rule;
use App\Models\QuestionCategoryModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;

class QuestionCategoryImport implements ToModel , WithValidation
{
    use Importable;

    public function model(array $row)
    {
        return new QuestionCategoryModel([
            'category_name' => $row['0'],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.category_name' => Rule::in(['category_name']),
        ];
    }

}
