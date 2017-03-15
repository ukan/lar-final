<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Sentinel;
use App\Models\User;
use Session;

class LoginsController extends Controller
{
    /*public function __construct() {
      $this->middleware('admin', ['except' => 'index']);
    }*/
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request){
        $creds = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        if ($user = Sentinel::authenticate($creds)){
            //dd($user);
            Session::flash('notice','You have been logged in!');
            return redirect('/');  
        }
        else {
            return redirect('login')->with("error","Username or Password incorrect.")->withInput($request->except('password'));
        }
    }

    public function logout() {
      Sentinel::logout(); // logout user
      Session::flash('notice','You  have been logged out');
      return redirect()->to('login'); //redirect back to login
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
}
