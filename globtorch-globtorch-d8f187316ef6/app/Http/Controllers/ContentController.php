<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Content;
use App\Topic;
use App\TeacherActivity;

class ContentController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $topic = Topic::find($id);
        return view('content.create', compact('topic'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validation that the request contains what we need
        $this->validate($request, 
            [
                'topic_id' => 'required',
                'type' => 'required',
                'order' => 'required'
            ]);
        
        $type = $request->input('type');
        $topic_id = $request->input('topic_id');

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

        return redirect('/subject/'.$content->topic->chapter->subject->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $content = Content::find($id);

        // if the content type is pdf, push it to the browser to download
        if ($content->type == 'pdf')
        {
            return response()->file('storage/content/' . $content->path);
            //return Storage::download('/public/content/'.$content->path);
        }
        return view('content.show')->with('content', $content);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $content = Content::find($id);
        if ($content->type == 'text')
        {
            $text = Storage::get('/public/content/'.$content->path);
            return view('content.edit')->with(array('content'=>$content, 'text'=>$text));
        }
        else
        {
            return view('content.edit')->with('content', $content);
        }
    }

    /**
     * Update the specified resource in storage.
     * Not allowing topic_id to be changed
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $replace_file = 0;

        // validation that the request contains what we need
        $this->validate($request, 
            [
                'type' => 'required',
                'order' => 'required'
            ]);
        
        $type = $request->input('type');
        $topic_id = $request->input('topic_id');

        if ($type == 'text')
        {
            $this->validate($request, [
                'name' => 'required',
                'text' => 'required',
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
            $replace_file = 1;
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
                $replace_file = 1;
            }
            else
            {
                $name = $request->input('name');
            }
        }

        $this->ft_check_order($id, $request->input('order'));

        $content = Content::find($id);

        if ($replace_file == 1)
        {
            //cleaning up the previous contents
            Storage::delete('public/content/'.$content->path);
        }
        //updating the record
        $content->name = $name;
        $content->type = $type;
        if ($replace_file == 1)
        {
            $content->path = $file_name_to_store;
        }
        $content->order = $request->input('order');
        $content->save();

        //logging the teacher activity
        $activity = new TeacherActivity;
        $activity->log = 'updated content';
        $activity->url = '/subject/'.$content->topic->chapter->subject->id;
        $activity->user_id = Auth::id();
        $activity->save();

        return redirect('/subject/'.$content->topic->chapter->subject->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $content = Content::find($id);
        Storage::delete('public/content/'.$content->path);
        $content->delete();
        
        return redirect('/topic/'.$content->topic_id)->with('message', 'Successfully deleted content');
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
