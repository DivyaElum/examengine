<?php

namespace App\Imports;

use Illuminate\Validation\Rule;
use App\Models\QuestionsModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class QuestionImport implements ToModel
{
    use Importable;

    public function model(array $row)
    {
        return new QuestionsModel([
            'question_text' => $row['0'],
        ]);
    }
}
