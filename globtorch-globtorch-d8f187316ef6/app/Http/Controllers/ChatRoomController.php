<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\ChatRoom;
use App\Message;
use App\User;
use App\MessageLog;

use App\Traits\NotificationTrait;
use App\Traits\MessageTrait;

class ChatRoomController extends Controller
{
    use NotificationTrait;
    use MessageTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chatRooms = ChatRoom::select('chat_rooms.*')
                ->join('messages', 'chat_rooms.id', 'messages.chat_room_id')
                ->whereRaw('FIND_IN_SET(?,participants)', Auth::id())
                ->distinct()
                ->get();
        $participant_ids = $this->getChatRoomParticipantIds($chatRooms);
        if (Auth::user()->user_type == 'student')
        {
            $users = $this->getStudentContacts($participant_ids);
        }
        else if (Auth::user()->user_type == 'teacher')
        {
            $users = $this->getTeacherContacts($participant_ids);
        }
        else
        {
            return back()->withErrors('No contacts defined for you!');
        }
        return view('chat_room.index', compact('chatRooms', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $chatRooms = ChatRoom::select('chat_rooms.*')
                ->join('messages', 'chat_rooms.id', 'messages.chat_room_id')
                ->whereRaw('FIND_IN_SET(?,participants)', Auth::id())
                ->distinct()
                ->get();
        $participant_ids = $this->getChatRoomParticipantIds($chatRooms);
        if (Auth::id() > $id)
        {
            $chatRoomName = $id . '_' . Auth::id();
        }
        else
        {
            $chatRoomName = Auth::id() . '_' . $id; 
        }
        if (Auth::user()->user_type == 'student')
        {
            $users = $this->getStudentContacts($participant_ids);
        }
        else if (Auth::user()->user_type == 'teacher')
        {
            $users = $this->getTeacherContacts($participant_ids);
        }
        else
        {
            return back()->withErrors('No contacts defined for you!');
        }
        $chatRoom = ChatRoom::with('messages')->where('name', $chatRoomName)->get()->first();
        if ($chatRoom == null)
        {
            $chatRoom = new ChatRoom;
            $chatRoom->user_id = Auth::id();
            $chatRoom->name = $chatRoomName;
            $chatRoom->participants = Auth::id() . ',' . $id; 
            $chatRoom->type = 'single';
            $chatRoom->save();
        }
        $currentUser = \App\User::find($id);

        return view('chat_room.show', compact('users', 'currentUser', 'chatRoom', 'chatRooms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'chat_room_id' => 'required|integer',
            'message' => 'required|string|max:255',
            'current_user_id' => 'required|integer'
        ]);

        $current_user_id = $request->input('current_user_id');
        $chat_room_id = $request->input('chat_room_id');
        $text = $request->input('message');
        $message = new Message;
        $message->message = $text;
        $message->user_id = Auth::id();
        $message->chat_room_id = $chat_room_id;
        $message->save();

        $user = Auth::user();
        $recepient = User::where('id', $current_user_id)->get();
        $title = 'New message from ' . $user->name . ' ' . $user->surname;
        $body = "Click to view:";
        $link =  route('chat_room.show', $chat_room_id);
        $message = $title . ' - ' . $body . ' ' . $link;
        $this->send_message($recepient->first()->phone, $message);
        $messageLog = new MessageLog;
        $messageLog->purpose = 'chat message';
        $messageLog->number = 1;
        $messageLog->save();
        $this->create_notification($title, $body, $link, $recepient, 0);

        return redirect()->route('chat_room.show', $chat_room_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chatRooms = ChatRoom::select('chat_rooms.*')
                ->join('messages', 'chat_rooms.id', 'messages.chat_room_id')
                ->whereRaw('FIND_IN_SET(?,participants)', Auth::id())
                ->distinct()
                ->get();
        $participant_ids = $this->getChatRoomParticipantIds($chatRooms);
        $chatRoom = ChatRoom::with('messages')->find($id);
        Message::where([
                ['chat_room_id', $id],
                ['user_id', '<>',  Auth::id()]
            ])
            ->update(['is_read' => 1]);
        if (Auth::user()->user_type == 'student')
        {
            $users = $this->getStudentContacts($participant_ids);
        }
        else if (Auth::user()->user_type == 'teacher')
        {
            $users = $this->getTeacherContacts($participant_ids);
        }
        else
        {
            return back()->withErrors('No contacts defined for you!');
        }
        if ($chatRoom == null)
        {
            return back()->withErrors('No Chat Room Found!');
        }
        $user_ids = explode(',', $chatRoom->participants);
        foreach($user_ids as $user_id)
        {
            if ($user_id != Auth::id())
            {
                $currentUser = \App\User::find($user_id);
            }
        }

        return view('chat_room.show', compact('users', 'currentUser', 'chatRoom', 'chatRooms'));
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

    public function getChatRoomParticipantIds($chatRooms)
    {
        $current_user_id = Auth::id();
        $participant_ids = array();
        foreach($chatRooms as $chatRoom)
        {
            $ids = explode(',', $chatRoom->participants);
            foreach($ids as $id)
            {
                if ($id != $current_user_id)
                {
                    array_push($participant_ids, $id);

                    if ($chatRoom->type == 'single')
                    {
                        $user = User::find($id);
                        $chatRoom->name = substr($user->name, 0, 1) . '. ' . $user->surname;
                    }
                }
            }
        }

        return $participant_ids;
    }

    /**
     * If the user is a student get his/her contacts who are teachers
     */
    public function getStudentContacts($participant_ids)
    {
        $users = User::join('teacher_subjects', 'users.id', 'teacher_subjects.user_id')
            ->join('subjects', 'subjects.id', 'teacher_subjects.subject_id')
            ->join('courses', 'courses.id', 'subjects.course_id')
            ->join('enrollments', 'enrollments.course_id', 'courses.id')
            ->select('users.id', 'users.name', 'users.surname', 'subjects.name as subject', 'courses.name as course')
            ->where('enrollments.user_id', Auth::id())
            ->whereNotIn('users.id', $participant_ids)
            ->orderBy('users.surname')
            ->orderBy('users.name')
            ->get();

        return $users;
    }

    public function getTeacherContacts($participant_ids)
    {
        $users = User::join('enrollments', 'users.id', 'enrollments.user_id')
            ->join('courses', 'courses.id', 'enrollments.course_id')
            ->join('subjects', 'courses.id', 'subjects.course_id')
            ->join('teacher_subjects', 'subjects.id', 'teacher_subjects.subject_id')
            ->select('users.id', 'users.name', 'users.surname', 'subjects.name as subject', 'courses.name as course')
            ->where('teacher_subjects.user_id', Auth::id())
            ->whereNotIn('users.id', $participant_ids)
            ->orderBy('users.surname')
            ->orderBy('users.name')
            ->get();
        return $users;
    }
}
