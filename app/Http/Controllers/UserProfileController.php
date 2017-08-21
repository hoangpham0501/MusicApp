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

class UserProfileController extends Controller
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
       //     $users;
           $user = User::all();
           $id=Auth::id();
           foreach ($user as $users) {
               if ($users->id==$id){
                    $first_name=$users->first_name;
                    $last_name=$users->last_name;
                    $email=$users->email;
                    $address=$users->address;
                    break;
               }
           }

           return view("userprofile/userprofile")->with([
                      'first_name' => $first_name,
                      'last_name' => $last_name,
                      'address'=>$address ]);
      } else return view('userprofile/userprofile');
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'address' => 'required|max:255',
            'confirmpass' => 'required|max:255',
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

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

        $password = ($request->input('confirmpass'));
        $email=$up->email;
         if (Auth::attempt(array('email' => $email, 'password' => $password)))
         {
            $up->first_name = $request->input('firstname');
            $up->last_name = $request->input('lastname');
            $up->address = $request->input('address');
                $up->save();
               // return redirect('songs');
                return view("userprofile/userprofile")->with([
                'first_name' => $up->first_name,
                'last_name' => $up->last_name,
                'address'=>$up->address,
              ]);
        }
        else {
                return view("userprofile/userprofile")->with([
                'first_name' => $up->first_name,
                'last_name' => $up->last_name,
                'address'=>$up->address,
                'msg'=>'wrong current password'
    ]);
        }
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
    // public function UserProfile(){

    //     return view('userprofile/userprofile');
    // }

}
