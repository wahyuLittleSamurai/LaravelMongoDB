<?php

namespace App\Http\Controllers;

use App\Recruitment;
use Validator;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class RecruitmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Recruitment::all();
        return view('index',compact('users'));
    }
    public function dataUser()
    {
        $users = Recruitment::all();
        return Datatables::of($users)
               ->addColumn('action', function($user){
                   return '<a href="#" class="btn btn-xs btn-primary edit" id="'.$user->id.'"><i class="glyphicon glyphicon-edit"></i> Edit</a> <a href="#" class="btn btn-xs btn-danger delete" id="'.$user->id.'"> <i class="glyphicon glyphicon-trash"></i> Delete</a>';
               })
               ->make(true);
    }

    function fetchdata(Request $request)
    {
        $id = $request->input('id');
        $user = Recruitment::find($id);
        $output = array(
            'id'            => $id,
            'firstName'     =>  $user->firstName,
            'lastName'      =>  $user->lastName,
            'email'         =>  $user->email,
            'address'       =>  $user->address,
            'contact'       =>  $user->contact
        );
        echo json_encode($output);
    }
    function postdata(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'firstName'     => 'required',
            'lastName'      => 'required',
            'email'         => 'required',
            'address'       => 'required',
            'contact'       => 'required'

        ]);
        $error_array = array();
        $success_output = '';
        if ($validation->fails())
        {
            foreach ($validation->messages()->getMessages() as $field_name => $messages)
            {
                $error_array[] = $messages; 
            }
        }
        else
        {
            if($request->get('button_action') == 'update')
            {
                $user = Recruitment::find($request->get('id'));
                $user->firstName = $request->get('firstName');
                $user->lastName = $request->get('lastName');
                $user->email = $request->get('email');
                $user->address = $request->get('address');
                $user->contact = $request->get('contact');
                $user->save();
                $success_output = '<div class="alert alert-success">Data Updated</div>';
            }
            if($request->get('button_action') == "insert")
            {
                $user = new Recruitment([
                    'firstName'     =>  $request->get('firstName'),
                    'lastName'      =>  $request->get('lastName'),
                    'email'         =>  $request->get('email'),
                    'address'       =>  $request->get('address'),
                    'contact'       =>  $request->get('contact')
                ]);
                $user->save();
                $success_output = '<div class="alert alert-success">Data Inserted</div>';
            }
            
        }
        
        $output = array(
            'error'     =>  $error_array,
            'success'   =>  $success_output
        );
        echo json_encode($output);
    }
    function removedata(Request $request)
    {
        $student = Recruitment::find($request->input('id'));
        if($student->delete())
        {
            echo 'Data Deleted';
        }
    }

}
