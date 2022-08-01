<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Topic;
use App\Chapter;

class TopicController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $chapter = Chapter::find($id);
        return view('topic.create', compact('chapter'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, 
            [
                'name' => 'required',
                'order' => 'required',
                'chapter_id' => 'required'
            ]);

        //getting the chapter that the topic should belong to
        $chapter = Chapter::find($request->input('chapter_id'));
        $order = $request->input('order');

        if (count($chapter->topics) > 0)
        {
            $topics = $chapter->topics->sortBy('order');

            // if user id trying to put the order outside the limit, reset to max
            if ($order < 1 || $order > ($topics->last()->order + 1))
            {
                $order = $topics->last()->order + 1;
            }

            // the order is supposed to replace an existing one, shift records up
            if (($topics->last()->order + 1) != $order)
            {
                foreach($topics as $topic)
                {
                    if ($topic->order >= $order)
                    {
                        $topic->order++;
                        $topic->save();
                    }
                }
            }
        }

        $topic = new Topic;
        $topic->name = $request->input("name");
        $topic->order = $request->input("order");
        $topic->chapter_id = $request->input('chapter_id');
        $topic->save();

        return redirect('/subject/' . $topic->chapter->subject->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $topic = Topic::find($id);

        //checking if the student has an active subscription
        if (Auth::user()->user_type == "student")
        {
            $today = date('Y-m-d');
            $subscriptions = DB::table('users')
                ->join('enrollments', 'users.id', '=' , 'enrollments.user_id')
                ->join('payments', 'enrollments.id', '=', 'payments.enrollment_id')
                ->join('courses', 'courses.id', '=', 'enrollments.course_id')
                ->join('subjects', 'courses.id', '=', 'subjects.course_id')
                ->join('chapters', 'subjects.id', '=', 'chapters.subject_id')
                ->join('topics', 'chapters.id', '=', 'topics.chapter_id')
                ->select('payments.*')
                ->where('start_date', '<=', $today)
                ->where('end_date', '>=', $today)
                ->where('topics.id', '=', $id)
                ->where('users.id', '=', Auth::user()->id)
                ->orderBy('end_date')->get();

            if (count($subscriptions) == 0)
            {
                return back()->withErrors('You do not have an active subscription!');
            }
        }

        //checking if the test on the previous chapter was done
        $chapter = $topic->chapter;
        if ($chapter->order > 1)
        {
            $results = DB::table('chapters')
            ->join('chapter_results', 'chapters.id', '=' , 'chapter_results.chapter_id')
            ->select('chapter_results.*')
            ->where([
                ['order', '=', $chapter->order - 1],
                ['subject_id', '=', $chapter->subject_id]
                ])
            ->get()->first();

            $previous_chapter = Chapter::where([
                ['order', '=', $chapter->order - 1],
                ['subject_id', '=', $chapter->subject_id]
                ])->get()->first();

            // if the user is a student and there is a test
            if (Auth::user()->user_type == 'student' && count($previous_chapter->questions) > 0)
            {
                if ($results == null || $results->percentage < 50)
                {
                    return redirect('/subject/' . $chapter->subject_id)->withErrors("You cannot move on to the next chapter without completing the previous chapter test.");
                }
            }
        }

        $texts = array();
        if (count($topic->contents) > 0)
        {
            $contents = $topic->contents->sortby('order')->values()->all();
            foreach($contents as $content)
            {
                if ($content->type == 'text')
                {
                    $path = 'public/content/'.$content->path;
                    $text_from_file = Storage::get($path);
                    array_push($texts, array($content->id, $text_from_file));
                }
            }
        } 
        
        return view('topic.show')->with(array('topic'=>$topic, 'texts'=>$texts));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $topic = Topic::find($id);
        
        return view('topic.edit')->with('topic', $topic);
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
        $this->validate($request, 
            [
                'name' => 'required',
                'order' => 'required'
            ]);

        $topic_update = Topic::find($id);

        //getting the chapter that the topic should belong to
        $chapter = Chapter::find($topic_update->chapter_id);
        $order = $request->input('order');
        $topics = $chapter->topics->sortBy('order');

        //checking if the order is within acceptable boundaries
        if ($order < 1)
        {
                $order = 1;
        }
        else if($order > $topics->last()->order)
        {
                $order = $topics->last()->order;
        }

        if (count($chapter->topics) > 0)
        {
                foreach($topics as $topic)
                {
                    if ($order > $topic_update->order)
                    {
                        if ($topic->order >= $topic_update->order && $topic->order <= $order)
                        {
                            $topic->order--;
                        }
                    }
                    else if ($order < $topic_update->order)
                    {
                        if ($topic->order >= $order && $topic->order <= $topic_update->order)
                        { 
                            $topic->order++;
                        }
                    }
                    else
                    {
                        break;
                    }
                    $topic->save();
                }
        }

        $topic_update->name = $request->name;
        $topic_update->order = $order;
        $topic_update->save();

        return redirect('/chapter/' . $topic->chapter_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $topic = Topic::with(['chapter', 'contents'])->find($id);
        if (count($topic->contents) == 0)
        {
            $topic->delete();
        }
        else
        {
            return back()->withErrors("Delete contents first before the topic!");
        }
        
        return redirect('/subject/' . $topic->chapter->subject_id)->with('message', 'Successfully deleted topic');
    }
}
