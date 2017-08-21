<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class ChangePasswordController extends Controller
{
    protected $redirectTo = '/';

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()) {
            return view("userprofile/changepass");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'current_password'=>'required|max:255',
            'new_password'=>'required|max:255',
            'confirm_password' => 'required|max:255',
        ]);
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $up=User::findOrFail(Auth::id());
        $current_password = ($request->input('current_password'));
        $new_password = ($request->input('new_password'));
        $confirm_password = ($request->input('confirm_password'));
        $email=$up->email;

        if (Auth::attempt(array('email' => $email, 'password' => $current_password))) {
            if ($new_password == $confirm_password){
                $up->password = bcrypt($new_password);
                $up->save();
                return view('userprofile/changepass')->with('msg','success');
            }
             else return view('userprofile/changepass')
            ->with('wrongnew','wrong new password');

        }
        else
             return view('userprofile/changepass')
            ->with('wrongcurrent','wrong current password');


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
