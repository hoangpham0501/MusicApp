<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserListController extends Controller
{
    protected $redirectTo = '/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::paginate(10);
        return view('admin/userlist')->with('user',$user)->with('option','all');
    }

    public function searchUser(){
        $keyword = $_GET['keyword'];
        $user_result = User::where('name','LIKE', '%'.$keyword.'%')->orWhere('email','LIKE','%'.$keyword.'%');


         $user = $user_result->paginate(10);
        if(isset($_GET['page'])){
            return view('admin/userlist')->with('user',$user)
        ->with('message', $user_result->count()." results with keyword: ".$keyword)
        ->with('page', $_GET['page'])->with('option','all');
        }
        return view('admin/userlist')->with('user',$user)->with('option','all')
        ->with('message', $user_result->count()." results with keyword: ".$keyword);
    }
    public function filter(){
        $value = $_GET['filter'];
        if ($value=='all')  {$user = User::paginate(10);
        return view('admin/userlist')->with('user',$user)->with('option',$value);}
        else {
        if (($value=="blocked") or ($value=="unblock")) $user_result = User::where('status','=',$value);
        if (($value=="admin") or($value=="user") ) $user_result = User::where('role','=',$value);
        $user = $user_result->paginate(10);
        return view('admin/userlist')->with('user',$user)
        ->with('message', 'Have '.$user_result->count().' '.$value)->with('option',$value);
    }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function changeStatus(){
        $id = $_POST['id'];
        $user = User::find($id);
        if($user->status == 'unblock'){
            $user->status = 'blocked';
        }else{
            $user->status = 'unblock';
        }
        $user->save();
        return json_encode('success');
    }
    public function changeRole(){
        $id = $_POST['id'];
        $user = User::find($id);
        if($user->role == 'admin'){
            $user->role = 'user';
        }else{
            $user->role = 'admin';
        }
        $user->save();
        return json_encode('success');
    }
    public function deleteUser(){
        $id = $_POST['id'];
        $user = User::find($id);
        $user->delete();
        return json_encode('success');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $up=User::findOrFail($request->id);
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
}
