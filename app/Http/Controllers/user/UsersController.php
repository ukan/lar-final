<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function reset_password() {
        return view('users.reset_password');
    }

    public function process_reset_password(Request $request) {
        $valid = array(
          'email' => 'required|email'
        );
        $data = $request->all();
        $validate = Validator::make($data, $valid);
        $find_data = User::where('email', $request->email)->first();
        if($validate->fails()) {
          return Redirect::to('reset-password')
          ->withErrors($validate)
          ->withInput();
        } elseif(empty($find_data)) {
          Session::flash('error', 'Email not found' . $request->email);
          return Redirect::to('reset-password')
          ->withErrors($validate)
          ->withInput();
        } else {
          $find_data->forgot_token = str_random(60);
          $find_data->save();
            Mail::send('emails.instructionresetpassword', $find_data->toArray(), function($message) use($find_data) {
            $message->from("devellar97@gmail.com", "Forgot password");
            $message->to($find_data->email, $find_data->username)->subject('Reset Password Instruction to devellar');
            $message->subject();
          });
            Session::flash('notice', 'Check your email, the reset password instruction has sent to '.$find_data->email);
            return Redirect::to('/');
        }
      }

      public function change_password($forgot_token) {
        $find_user = User::where('forgot_token', $forgot_token)->first();
        if(empty($find_user)) {
            Session::flash('error', 'Token not valid, :)');
            return Redirect::to('/');
        } else {
            return view('users.change_password')
            ->with( 'forgot_token', $find_user->forgot_token);
        }
      }

      public function process_change_password(Request $request, $forgot_token) {
        $valid = array('password' => ('required'));
        $data = $request->all();
        $find_data = User::where('forgot_token', $forgot_token)->first();
        $validate = Validator::make($data, $valid);
        if($validate->fails()) {
            return Redirect::to('change-password/'.$find_data->forgot_token)
            ->withErrors($validate);
        } else {
            $find_data->password = Hash::make($request->password);
            $find_data->forgot_token = null;
            $find_data->save();
            Session::flash('notice ', 'Hai ' . $find_data->username . ' Password has change lets login');
            return Redirect::to('login');
        }
      }
}
