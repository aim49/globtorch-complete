<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\TeacherActivity;
use App\Course;
use App\Subject;
use App\Chapter;
use App\Topic;
use App\Content;

class CourseSubjectChapterTopicContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($course_id, $subject_id, $chapter_id, $topic_id)
    {
        $topic = Topic::findOrFail($topic_id);
        return view('course.subject.chapter.topic.content.create', compact('course_id', 'subject_id', 'chapter_id', 'topic'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $course_id, $subject_id, $chapter_id, $topic_id)
    {
        // validation that the request contains what we need
        $this->validate($request, 
            [
                'type' => 'required',
                'order' => 'required'
            ]);
        
        $type = $request->input('type');

        if ($type == 'text')
        {
            $this->validate($request, [
                'name' => 'required',
                'text' => 'required',
            ]);
        }
        else
        {
            $this->validate($request, [
                'file_uploaded' => 'required'
            ]);
        }

        // if it's text we want to store it in a text file, if it's any other format we just save the file
        if ($type == 'text')
        {
            $name = $request->input('name');
            $text = $request->input('text');
            $file_name_to_store = $name.'_'.time().'.txt';
            Storage::put($file_name_to_store, $text);
            Storage::move($file_name_to_store, 'public/content/'.$file_name_to_store);
        }
        else
        {
            if ($request->hasFile('file_uploaded'))
            {
                $full_file_name = $request->file('file_uploaded')->getClientOriginalName();
                $name = pathinfo($full_file_name, PATHINFO_FILENAME);
                $extension = $request->file('file_uploaded')->getClientOriginalExtension();
                
                if ($type == 'video')
                {
                    if (!($extension == 'mp4' || $extension == 'ogg'))
                    {
                        return ('Error uploading content. Video format is mp4 and ogg only.');
                    }
                }
                else if ($type == 'pdf')
                {
                    if ($extension != 'pdf')
                    {
                        return ('Error uploading content. PDF format should be pdf only');
                    }
                }
                else if ($type == 'audio')
                {
                    if (!($extension == 'mp3' || $extension == 'ogg'))
                    {
                        return ('Error uploading content. Video format is mp3 and ogg only.');
                    }
                }
                $file_name_to_store = $name.'_'.time().'.'.$extension;
                $path = $request->file('file_uploaded')->storeAs('public/content', $file_name_to_store);
            }
            else
            {
                return ('Error: contact administrators');
            }
        }
        
        //aranging the order
        //getting the chapter that the topic should belong to
        $topic = Topic::find($topic_id);
        $order = $request->input('order');

        if (count($topic->contents) > 0)
        {
            $contents = $topic->contents->sortBy('order');

            // if user id trying to put the order outside the limit, reset to max
            if ($order < 1 || $order > ($contents->last()->order + 1))
            {
                $order = $contents->last()->order + 1;
            }

            // the order is supposed to replace an existing one, shift records up
            if (($contents->last()->order + 1) != $order)
            {
                foreach($contents as $content)
                {
                    if ($content->order >= $order)
                    {
                        $content->order++;
                        $content->save();
                    }
                }
            }
        }
        
        //saving the content in the database
        $content = new Content;
        $content->name = $name;
        $content->type = $type;
        $content->path = $file_name_to_store;
        $content->order = $request->input('order');
        $content->topic_id = $topic_id;
        $content->save();

        //logging the teacher activity
        $activity = new TeacherActivity;
        $activity->log = 'Created new content';
        $activity->url = '/subject/'.$content->topic->chapter->subject->id;
        $activity->user_id = Auth::id();
        $activity->save();

        return redirect()->route('course.subject.chapter.index', [$course_id, $subject_id])->with('message', 'Successfully added content');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /*
    *   function to check and shift the order of the contents in a topic
    *   @param int $id (the content id), $order
    */
    private function ft_check_order($id, $order)
    {
        $content_update = Content::find($id);

       //getting the topic that the content should belong to
       $topic = Topic::find($content_update->topic_id);
       $contents = $topic->contents->sortBy('order');

       //checking if the order is within acceptable boundaries
       if ($order < 1)
       {
            $order = 1;
       }
       else if($order > $contents->last()->order)
       {
            $order = $contents->last()->order;
       }

       if (count($topic->contents) > 0)
       {
            foreach($contents as $content)
            {
                if ($order > $content_update->order)
                {
                    if ($content->order >= $content_update->order && $content->order <= $order)
                    {
                        $content->order--;
                    }
                }
                else if ($order < $content_update->order)
                {
                    if ($content->order >= $order && $content->order <= $content_update->order)
                    { 
                        $content->order++;
                    }
                }
                else
                {
                    break;
                }
                $content->save();
            }
       }
    }
}
