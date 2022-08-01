<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Course;
use App\Subject;
use App\Chapter;
use App\Topic;
use App\User;

class CourseSubjectChapterTopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($course_id, $subject_id, $chapter_id)
    {
        $course = Course::findOrFail($course_id);
        $subject = Subject::findOrFail($subject_id);
        $chapter = Chapter::with('topics.contents')->findOrFail($chapter_id);

        return view('course.subject.chapter.topic.index', compact('course', 'subject', 'chapter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($course_id, $subject_id, $chapter_id)
    {
        $chapter = Chapter::findOrFail($chapter_id);
        return view('course.subject.chapter.topic.create', compact('course_id', 'subject_id', 'chapter'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $course_id, $subject_id, $chapter_id)
    {
        $this->validate($request, 
            [
                'name' => 'required',
                'order' => 'required'
            ]);
        $chapter = Chapter::find($chapter_id);
        $order = $request->input('order');
        if (count($chapter->topics) > 0)
        {
            $topics = $chapter->topics->sortBy('order');
            if ($order < 1 || $order > ($topics->last()->order + 1))
            {
                $order = $topics->last()->order + 1;
            }
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
        $topic->chapter_id = $chapter_id;
        $topic->save();

        return redirect()->route('course.subject.chapter.index', [$course_id, $subject_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($course_id, $subject_id, $chapter_id, $id)
    {
        if ($this->hasActiveSubscription($id) == 0)
        {
            return back()->withErrors('You do not have an active subscription!');
        }
        $course = Course::findOrFail($course_id);
        $subject = Subject::findOrFail($subject_id);
        $chapter = Chapter::findOrFail($chapter_id);
        if ($this->hasDoneTest($chapter) == 0)
        {
            return back()->withErrors("You cannot move on to the next chapter without completing the previous chapter test.");
        }
        $topic = Topic::with('contents')->findOrFail($id);
        $texts = $this->getTextContent($topic->contents);

        return view('course.subject.chapter.topic.show', compact('course', 'subject', 'chapter', 'topic', 'texts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($course_id, $subject_id, $chapter_id, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $course_id, $subject_id, $chapter_id, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($course_id, $subject_id, $chapter_id, $id)
    {
        //
    }

    public function hasActiveSubscription($topic_id)
    {
        if (Auth::user()->user_type == "student")
        {
            $today = date('Y-m-d');
            $subscriptions = User::join('enrollments', 'users.id', '=' , 'enrollments.user_id')
                ->join('payments', 'enrollments.id', '=', 'payments.enrollment_id')
                ->join('courses', 'courses.id', '=', 'enrollments.course_id')
                ->join('course_subject', 'course_subject.course_id', 'courses.id')
                ->join('subjects', 'course_subject.subject_id', '=', 'subjects.id')
                ->join('chapters', 'subjects.id', '=', 'chapters.subject_id')
                ->join('topics', 'chapters.id', '=', 'topics.chapter_id')
                ->select('payments.*')
                ->where('start_date', '<=', $today)
                ->where('end_date', '>=', $today)
                ->where('topics.id', '=', $topic_id)
                ->where('users.id', '=', Auth::user()->id)
                ->orderBy('end_date')->get();

            if (count($subscriptions) == 0)
            {
                return 0;
            }
        }
        return 1;
    }

    public function hasDoneTest($chapter)
    {
        if ($chapter->order > 1)
        {
            $results = Chapter::join('chapter_results', 'chapters.id', '=' , 'chapter_results.chapter_id')
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

            if (Auth::user()->user_type == 'student' && count($previous_chapter->questions) > 0)
            {
                if ($results == null || $results->percentage < 50)
                {
                    return 0;
                }
            }
        }
        return 1;
    }

    public function getTextContent($contents)
    {
        $texts = array();
        if (count($contents) > 0)
        {
            $contents = $contents->sortby('order')->values()->all();
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
        return $texts;
    }
}
