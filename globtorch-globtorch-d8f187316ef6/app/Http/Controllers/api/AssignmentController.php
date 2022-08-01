<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

use App\Subject;
use App\Assignment;
use App\AssignmentAnswer;

class AssignmentController extends Controller
{
    public function index($subject_id)
    {
        $subject = Subject::with('assignments')->findOrFail($subject_id);
        return response()->json($subject, 200);
    }

    public function show($id)
    {
        $assignment = Assignment::leftJoin('assignment_answers', 'assignments.id', '=', 'assignment_answers.assignment_id')
                        ->select('assignments.*', 
                                'assignment_answers.id as answer_id', 'mark', 'assignment_answers.file_path as answer',
                                'assignment_answers.marked_answer')
                        ->where('assignment_answers.user_id', '=', Auth::id())
                        ->where('assignments.id', $id)
                        ->get();
        if ($assignment->count() > 0)
        {
            $assignment = $assignment->first();
        }
        else
        {
            $assignment = Assignment::findOrFail($id);
        }
        return response()->json($assignment, 200);
    }

    public function download($id)
    {
        $assignment = Assignment::findOrFail($id);
        return response()->file('storage/files/assignments/' . $assignment->file_path);
    }

    public function storeAnswer(Request $request, $id)
    {
        $request->validate([
            'file_upload' => 'file|required'
        ]);
        $assignmentAnswer = AssignmentAnswer::where([
            ['assignment_id', $id],
            ['user_id', Auth::id()]
            ])->get()->first();
        if ($assignmentAnswer == null)
        {
            $assignmentAnswer = new AssignmentAnswer;
            $assignmentAnswer->assignment_id = $id;
            $assignmentAnswer->user_id = Auth::id();
        }

        $extension = Input::file('file_upload')->getClientOriginalExtension();
        $filename = $id . '.' .time().  '.' . $extension;
        $path = $request->file('file_upload')->storeAs('/public/files/assignments/', $filename);

        $assignmentAnswer->file_path = $filename;
        $assignmentAnswer->save();

        return response()->json('Submited Assignment', 200);
    }
}
