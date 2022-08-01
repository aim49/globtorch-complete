<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Subject;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers=User::where('user_type','teacher')->get();
        return view('teacher.index',compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teacher.create');
    }

    /*
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'surname'=>'required',
            'gender'=>'required',
            'address'=>'required',
            'dob'=>'required',
            'city'=>'required',
            'country'=>'required',
            'phone'=>'required',
            'email'=>'required',
            'password'=>'required'
        ]);
        
        //  getting the last user added into the system
        $last_user = User::where('user_type', 'teacher')
            ->orderBy('created_at', 'desc')
            ->first();

        if ($last_user == null)
        {
            //he is the first user
            $user_id = 'GT0001';
        }
        else
        {
            $user_id = 'GT';
            $numbers = (int)substr($last_user->school_id, 2);
            $numbers++;

            $leading_zeros = 0;
            if ($numbers < 10)
            {
                $leading_zeros = 3;
            }
            else if ($numbers < 100)
            {
                $leading_zeros = 2;
            }
            else if ($numbers < 1000)
            {
                $leading_zeros = 1;
            }
            for ($x = 0; $x < $leading_zeros; $x++)
            {
                $user_id = $user_id . '0';
            }
            $user_id = $user_id . $numbers;
        }

        $user = new User();
        $user->name = request('name');
        $user->surname = request('surname');
        $user->dob = request('dob');
        $user->address = request('address');
        $user->city = request('city');
        $user->country = request('country');
        $user->phone = request('phone');
        $user->email = request('email');
        $user->gender = request('gender');
        $user->user_type = 'teacher';
        $user->school_id = $user_id;
        $user->password = bcrypt(request('password'));
        $user->save();

        //sending a message
        $username = 'Globtorch';
        $token = '4253fdb80ea9500748b0852389feb134';
        $bulksms_ws = 'http://portal.bulksmsweb.com/index.php?app=ws';
        $destinations =request('phone');
        $message = "Your school id is ".$user->school_id.', use it to login, Thank you! Regards GlobTorch';
        $ws_str = $bulksms_ws . '&u=' . $username . '&h=' . $token . '&op=pv';
        $ws_str .= '&to=' . urlencode($destinations) . '&msg='.urlencode($message);
        $ws_response = @file_get_contents($ws_str);

        return redirect('/teacher')->with('message','Teacher successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $teacher = User::where([
            ['id', $id],
            ['user_type', 'teacher']
            ])->get()->first();

        if ($teacher == null)
        {
            return back()->withErrors('Teacher does not exist, contact admin team');
        }
        
        return view('teacher.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teacher=User::find($id);
        return view('teacher.edit', compact('teacher'));
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
        $user=User::find($id);
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->dob = $request->input('dob');
        $user->address = $request->input('address');
        $user->city = $request->input('city');
        $user->phone = $request->input('phonenumber');
        $user->email = $request->input('email');
        $user->gender = $request->input('gender');
        $user->description = $request->input('description');
        $user->save();
        return redirect('/teacher')->with('message','Teacher successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //deleting a teacher
    public function destroy($id)
    {
        $teacher=User::find($id);
        foreach($teacher->teacher_activities as $activity)
        {
            $activity->delete();
        }
        foreach($teacher->teacher_subjects as $subject)
        {
            $subject->delete();
        }
        $teacher->delete();
        return redirect('/teacher')->with('message','Teacher successfully deleted');
    }
}
