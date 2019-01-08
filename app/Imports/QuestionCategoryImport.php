<?php

namespace App\Imports;

use App\Models\QuestionCategoryModel;
use Maatwebsite\Excel\Concerns\ToModel;

class QuestionCategoryImport implements ToModel
{
    public function model(array $row)
    {
        return new QuestionCategoryModel([
            'category_name' => $row[0],
        ]);
    }

}
