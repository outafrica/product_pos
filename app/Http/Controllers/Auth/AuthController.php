<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    
    /**
     * Authenticate user login details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validate($request, [

            'email' => 'required|email',
            'password' => 'required',

        ]);
        
        $email = $request->email;
        $password = $request->password;

        if (Auth::attempt(['email' => $email, 'password' => $password])) {

            $user = Auth::user();
            
            if($user->role->name == 'Admin'){

                return response()->json([
                
                    'msg' => 'Admin'
                    
                ]);
    
            }else if($user->role->name == 'Agent'){

                return response()->json([
                
                    'msg' => 'User'
                    
                ]);
    
            }

        }else{

            return response()->json([
                
                'msg'=>'The provided credentials do not match our records.'
            
            ], 401);

        }

    }

    /**
     * user logout
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    
    }

}