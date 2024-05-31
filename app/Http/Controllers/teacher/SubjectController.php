<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


use function PHPUnit\Framework\isNull;

class SubjectController extends Controller
{
    //
    public function index()
    {  
        $user = Auth::user(); // Get the authenticated user

        if($user->utype == "teacher"){

           // return response()->json(["message" => "reached"], 200);

            $subjects= Subject::where('teacher_id', $user->id)->get();

            if(count($subjects) != 0){
                return response()->json(["success" => true, "subject" => $subjects], 200);

            }
            else{
                return response()->json(["success" => true, "subject" => null], 200);

            }


        }
    }

    /**
     * Store a newly created subject in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user

        $id = $user->id;

        $request->merge(['teacher_id' => $id]);
        $request->merge(['uuid' => Str::uuid()]);



        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'teacher_id' => 'required|integer|exists:users,id',
        ]);

        // return $request;

        if ($validator->fails()) {
            $errors = implode(', ', $validator->errors()->all());
            return response()->json(["success" => false, 'response' => $errors], 422);
        }

        $subject = Subject::create($request->all());

        return response()->json(["success" => true ,'subject' => $subject, "response" => "Subject Created"], 201);
    }

    /**
     * Display the specified subject.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */


    public function show($id)
    {
        $subject = Subject::where('teacher_id', $id)->firstOrFail();

        if(!isNull($subject) && count($subject)){
            return response()->json(["success" => true ,'subject' => $subject, "response" => "Subject Found"], 200);
        }
        else{
            return response()->json(["success" => true ,'subject' => $subject, "response" => "Subject not Found"], 404);

        }
    }

    /**
     * Update the specified subject in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user
        $tid = $user->id;

        $id = $request->id;

        $subject = Subject::where('id', $id)->firstOrFail();
       

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'id' => 'sometimes|required|integer|exists:subjects,id',
        ]);

        if ($validator->fails()) {
            $errors = implode(', ', $validator->errors()->all());
            return response()->json(["success" => false, 'response' => $errors], 422);
           }

        $subject->update($request->all());
        return response()->json(["success" => true ,'subject' => $subject, "response" => "Subject Updated"], 200);
    }

    /**
     * Remove the specified subject from storage.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = Subject::where('id', $id)->firstOrFail();
        $result = $subject->delete();

        if($result == true){
            return response()->json(["success" => true ,'subject' => $subject, "response" => "Subject Delete"], 200);

        }
        else{
            return response()->json(["success" => true ,"reponse" => "Subject not found, can't delete non existent subject"], 404);

        }
    }
}
