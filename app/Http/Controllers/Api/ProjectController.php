<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\Proejct;
class ProjectController extends Controller
{
    //CREATE PROJECT API    
    public function createProject(Request $request)
    {
        //validation 
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'duration' => 'required'
        ]);

        //student id
        $student_id = auth()->user()->id;

        //create data
        $project = new Proejct();
        $project->student_id = $student_id;
        $project->name = $request->name;
        $project->description = $request->description;
        $project->duration = $request->duration;
        $project->save();

        //send response
        return response()->json([
            'status' => 1,
            'message' => 'Project has been created'
        ],200);


        
    }

    //LIST PROJECT API
    public function listProject()
    {
        $student_id = auth()->user()->id;

        $project = Proejct::where('student_id', $student_id)->get();
        return response()->json([
            'status' => 1,
             'message' => 'Student Projects',
             'data' => $project
        ], 200);
        
    }

    //SINGLE PROJECT API
    public function singleProject($id)
    {
        $student_id = auth()->user()->id;
        if(Proejct::where(['id' => $id, 'student_id' =>   $student_id])->exists())
        {
            $details = Proejct::where(['id' => $id, 'student_id' =>   $student_id])->get();
            return response()->json([
                'status' => 1,
                'message' => 'Project Details',
                'data' => $details
            ],201);

        }else{
            return response()->json([
                'status' => 0,
                'message' => 'Project Not Found'
            ],404);
        }
    }

    //DELETE PROJECT API
    public function deleteProject($id)
    {
        $student_id = auth()->user()->id;
        if(Proejct::where(['id' => $id, 'student_id' =>   $student_id])->exists())
        {
            $project = Proejct::where(['id' => $id, 'student_id' =>   $student_id])->first();
            $project->delete();
            return response()->json([
                'status' => 1,
                'message' => 'Project Deleted Successfully',
            ],201);

        }else{
            return response()->json([
                'status' => 0,
                'message' => 'Project Not Found'
            ],404);
        } 
    }
}
