<?php

use Illuminate\Database\Seeder;

use App\Course;
use App\Exam_Board;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $zimsec = Exam_Board::where('name', 'Zimsec')->get()->first();
        $cambridge = Exam_Board::where('name', 'Cambridge')->get()->first();

        $course = new Course;
        $course->name = 'Grade 1';
        $course->description = 'The basic level of primary education';
        $course->level = 'Primary';
        $course->price = 10.00;
        $course->save();
        $course->exam_boards()->attach($zimsec, [
            'exam_months' => 'May, November',
            'exam_price' => 100.00 
            ]);

        $course = new Course;
        $course->name = 'Grade 2';
        $course->description = 'The basic level of primary education. Next level after Grade 1';
        $course->level = 'Primary';
        $course->price = 10.00;
        $course->save();
        $course->exam_boards()->attach($zimsec, [
            'exam_months' => 'May, November',
            'exam_price' => 100.00 
            ]);

        $course = new Course;
        $course->name = 'Grade 1';
        $course->description = 'The basic level of primary education';
        $course->level = 'Primary';
        $course->price = 20.00;
        $course->save();
        $course->exam_boards()->attach($cambridge, [
            'exam_months' => 'June, November',
            'exam_price' => 200.00 
            ]);

        $course = new Course;
        $course->name = 'Grade 2';
        $course->description = 'The basic level of primary education. Next level after Grade 1';
        $course->level = 'Primary';
        $course->price = 20.00;
        $course->save();
        $course->exam_boards()->attach($cambridge, [
            'exam_months' => 'June, November',
            'exam_price' => 200.00 
            ]);
    }
}
