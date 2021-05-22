<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use SebastianBergmann\Environment\Console;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(){
        return view('register');
    }
    public function Store_register(Request $request){
        
        $input = ($request->inputValues);// convert JSON to Object;
        /* $data = json_encode($request->inputValues);//convert object to JSON */
        $user = new User();
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = password_hash($input['password'],PASSWORD_BCRYPT);//ma hoa password;
        $user->save();
        return 'Đăng kí thành công';
    }
    public function login(){
        return view('login');
    }
    public function check_login(Request $request){
        $input = ($request->inputValues);
        $email = $input['email'];
        $password = $input['password'];
        $profile = User::select('name','email')->where('email',$email)->first();
       if(Auth::attempt(['email' => $email, 'password' => $password])){
            $request->session()->put('user', $profile);
             return "Login thanh cong";
        }else{
            return "LoginFail";
        }
    }
}