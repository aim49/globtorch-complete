<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Chapter;
use App\Subject;
use App\User;

use App\Traits\NotificationTrait;

class ChapterController extends Controller
{
    use NotificationTrait;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $subject = Subject::find($id);
        return view('chapter.create', compact('subject'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'order' => 'required',
            'subject_id' => 'required'
            ]);

        $subject = Subject::find($request->input('subject_id'));
        $order = $request->input('order');

        if (count($subject->chapters) > 0)
        {
            $chapters = $subject->chapters->sortBy('order');

            if ($order < 1 || $order > ($chapters->last()->order + 1))
            {
                $order = $chapters->last()->order + 1;
            }

            if ($chapters->last()->order + 1 != $order)
            {
                foreach($chapters as $chapter)
                {
                    if ($chapter->order >= $order)
                    {
                        $chapter->order++;
                        $chapter->save();
                    }
                }
            }
        }

        $chapter = new Chapter;
        $chapter->name = $request->input('name');
        $chapter->order = $order;
        $chapter->subject_id = $request->input('subject_id');
        $chapter->save();

        //generate a notification for all the users on this course
        $title = $chapter->subject->name;
        $body = "Chapter Added- " . $chapter->name;
        $link = "/subject/" . $chapter->subject->id;
        $users = $chapter->subject->course->users;
        $this->create_notification($title, $body, $link, $users, 0);
        
        return redirect('/subject/' . $chapter->subject->id)->with('message','Chapter Successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chapter = Chapter::find($id);

        if ($chapter->order > 1)
        {
            $results = DB::table('chapters')
            ->join('chapter_results', 'chapters.id', '=' , 'chapter_results.chapter_id')
            ->select('chapter_results.*')->where('order', '=', $chapter->order - 1)
            ->get()->first();

            $previous_chapter = Chapter::where('order', '=', $chapter->order - 1)->get()->first();

            // if the user is a student and there is a test
            if (Auth::user()->user_type == 'student' && count($previous_chapter->questions) > 0)
            {
                if ($results == null || $results->percentage < 50)
                {
                    return ("You did not pass the previous test. Please <a href='/chapter_answer/create/".$previous_chapter->id."'>click here</a> to attempt the test.");
                }
            }
        }
        return view('chapter.show')->with('chapter', $chapter);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $chapter = Chapter::find($id);

        return view('chapter.edit')->with('chapter', $chapter);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name'=>'required',
            'order' => 'required'
            ]);

        $chapter_update = Chapter::find($id);

        //getting the subject that the chapter should belong to
        $subject = Subject::find($chapter_update->subject_id);
        $order = $request->input('order');
        $chapters = $subject->chapters->sortBy('order');

        //checking if the order is within acceptable boundaries
        if ($order < 1)
        {
            $order = 1;
        }
        else if($order > $chapters->last()->order)
        {
            $order = $chapters->last()->order;
        }

        if (count($subject->chapters) > 0)
        {
            foreach($chapters as $chapter)
            {
                if ($order > $chapter_update->order)
                {
                    if ($chapter->order >= $chapter_update->order && $chapter->order <= $order)
                    {
                        $chapter->order--;
                    }
                }
                else if ($order < $chapter_update->order)
                {
                    if ($chapter->order >= $order && $chapter->order <= $chapter_update->order)
                    { 
                        $chapter->order++;
                    }
                }
                else
                {
                    break;
                }
                $chapter->save();
            }
        }

        $chapter_update->name = $request->input('name');
        $chapter_update->order = $request->input('order');
        $chapter_update->save();

        return redirect('/subject/' . $chapter_update->subject->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $chapter = Chapter::with('topics')->find($id);
        if (count($chapter->topics) == 0)
        {
            $chapter->delete();
        }
        else
        {
            return back()->withErrors("Delete all topics of this chapter before deleting the chapter");
        }

        return back()->with('message', 'Successfully deleted chapter');
    }
}
