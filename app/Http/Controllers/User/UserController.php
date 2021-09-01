<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Document;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index()
    {
        return view('user.home');
    }

    public function profile()
    {
        $id = Auth()->user()->id;
        $courses = Course::whereHas('users', function ($query) use ($id) {
            $query->where('user_id', $id);
        })->get();

        return view('user.profile', compact('courses'));
    }

    public function update(Request $request)
    {
        $id = Auth()->user()->id;
        $user = User::find($id);
        if ($request['username'] != null || $request['email'] != null
            || $request['phone'] != null || $request['address'] != null
            || $request['birthday'] != null || $request['desc'] != null) {
            if ($request['username'] != null) {
                $user->name = $request['username'];
            }
    
            if ($request['email'] != null) {
                $user->email = $request['email'];
            }
    
            if ($request['phone'] != null) {
                $user->phone = $request['phone'];
            }
    
            if ($request['address'] != null) {
                $user->address = $request['address'];
            }
    
            if ($request['birthday'] != null) {
                $user->birthday = $request['birthday'];
            }
    
            if ($request['desc'] != null) {
                $user->desc = $request['desc'];
            }
            $user->save();
            Alert::success('Success', 'Update Success');
        }
        return redirect()->back();
    }

    public function updateImg(Request $request)
    {
        $file = $request->file('file');
        $type = $file->getClientOriginalExtension();
        $name = time() . '.' .$type;
        $file->move('images/', $name);
        // Storage::putFileAs("public/images/", $file, $name);
        $id = Auth()->user()->id;
        $user = User::find($id);
        $user->avatar = $name;
        $user->save();
        return response()->json(1);
    }

    public function storeDocument(Request $request)
    {
        $userID = Auth()->user()->id;
        $documentID = $request->id;
        $user = User::find($userID);
        $checkexits = User::withCount(['documents as row' => function ($query) use ($documentID) {
            $query->where('document_id', $documentID);
        }])->find($userID);
        if ($checkexits->row == 0) {
            $document = Document::find($request->id);
            $user->documents()->attach($document);
            return response()->json(1);
        }
        return response()->json(0);
    }

    public function statusDocument(Request $request)
    {
        $userID = Auth()->user()->id;
        $lessonID = $request->lessonID;
        $status = User::with(['documents' => function ($query) use ($lessonID) {
            $query->with('lessons')->where('lesson_id', $lessonID);
        }])->find($userID);

        return response()->json($status);
    }
}
