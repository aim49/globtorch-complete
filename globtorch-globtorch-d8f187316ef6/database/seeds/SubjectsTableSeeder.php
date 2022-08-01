<?php

use Illuminate\Database\Seeder;

use App\Course;
use App\Subject;
use App\User;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teacher = User::where('school_id', 'GT0001')->get()->first();
        $grade1_zimsec = Course::find(1);
        $grade2_zimsec = Course::find(2);
        $grade1_cambridge = Course::find(3);
        $grade2_cambridge = Course::find(4);

        $subject = new Subject;
        $subject->name = 'Maths';
        $subject->order = 1;
        $subject->course_id = $grade1_zimsec->id;
        $subject->save();
        $subject->users()->attach($teacher);

        $subject = new Subject;
        $subject->name = 'Maths';
        $subject->order = 1;
        $subject->course_id = $grade2_zimsec->id;
        $subject->save();
        $subject->users()->attach($teacher);

        $subject = new Subject;
        $subject->name = 'Maths';
        $subject->order = 1;
        $subject->course_id = $grade1_cambridge->id;
        $subject->save();
        $subject->users()->attach($teacher);

        $subject = new Subject;
        $subject->name = 'Maths';
        $subject->order = 1;
        $subject->course_id = $grade2_cambridge->id;
        $subject->save();
        $subject->users()->attach($teacher);

        $subject = new Subject;
        $subject->name = 'English';
        $subject->order = 2;
        $subject->course_id = $grade1_zimsec->id;
        $subject->save();
    }
}
