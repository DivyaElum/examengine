<?php

namespace App\Exports;

use App\Models\QuestionsModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QuestionExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return collect([
            [
                'category_id'         => 'povilas',
                'question_text'       => 'povilas',
                'question_type'       => 'povilas',
                'option_type'         => 'povilas',
                'option1'             => 'povilas',
                'option2'             => 'povilas',
                'option3'             => 'povilas',
                'option4'             => 'povilas',
                'option5'             => 'povilas',
                'option6'             => 'povilas',
                'option7'             => 'povilas',
                'option8'             => 'povilas',
                'option9'             => 'povilas',
                'option10'            => 'povilas',
                'option11'            => 'povilas',
                'option12'            => 'povilas',
                'option13'            => 'povilas',
                'option14'            => 'povilas',
                'option15'            => 'povilas',
                'option16'            => 'povilas',
                'correct_answer'      => 'povilas',
                'right_marks'         => 'povilas',
                'chk_negative_mark'   => 'povilas',
                'negative_mark'       => 'povilas'
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'category id',
            'question text',
            'question type',
            'option type',
            'option1',
            'option2',
            'option3',
            'option4',
            'option5',
            'option6',
            'option7',
            'option8',
            'option9',
            'option10',
            'option11',
            'option12',
            'option13',
            'option14',
            'option15',
            'option16',
            'correct answer',
            'right marks',
            'chechbox negative mark',
            'negative marks'
        ];
    }
}
