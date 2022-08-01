<?php

use Illuminate\Database\Seeder;

use App\Exam_Board;

class ExamBoardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $board = new Exam_Board;
        $board->name = 'Zimsec';
        $board->description = 'Zimbabwean exam board';
        $board->save();

        $board = new Exam_Board;
        $board->name = 'Cambridge';
        $board->description = 'UK exam board';
        $board->save();
    }
}
