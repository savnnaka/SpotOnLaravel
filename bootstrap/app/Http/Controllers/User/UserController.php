<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Auth;
use App\Models\VerifyUser;
use Carbon\Carbon;
use App\Models\Event;

class UserController extends Controller
{

    public function create(Request $request){
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:15',
            'cpassword' => 'required|same:password',
        ], [
            'cpassword.required' => 'The confirm field is required.',
            'cpassword.same' => 'Confirm password and password must match.'
        ]);

        // call user model and safe
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $data = $user->save();

        $last_id = $user->id;
        $token = $last_id.hash('sha256', \Str::random(120));
        $verifyURL = route('user.verify', ['token'=>$token, 'service'=>'Email_verification']);

        VerifyUser::create([
            'user_id' => $last_id,
            'token' => $token,
        ]);

        $message = 'Dear <b>'.$request->name.',</b><br>';
        $message.= 'Thanks for signing up, we just need you to verify your email address to ';
        $message.= 'complete setting up your account';
        
        $mail_data = [
            'recipient'=>$request->email,
            'fromEmail'=>'spoton@register.com',
            'fromName'=>'Spoton Register',
            'subject'=>'Email Verification',
            'body'=>$message,
            'actionLink'=>$verifyURL,
        ];

        \Mail::send('user.email-template', $mail_data, function($message) use ($mail_data){
            $message->to($mail_data['recipient'])
                    ->from($mail_data['fromEmail'], $mail_data['fromName'])
                    ->subject($mail_data['subject']);
        });

        if($data){
            return redirect()->back()->with('success', 'You need to verify your account. We have sent you an activation link.');
        }else{
            return redirect()->back()->with('error', 'Registration failed.');
        }

    }

    public function dologin(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|max:25',
        ]);

        $check = $request->only('email', 'password');

        if(Auth::guard('web')->attempt($check)){
            return redirect()->route('user.home')->with('success', 'Welcome to dashboard');
        }else {
            return redirect()->back()->with('error', 'Login Failed.');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }


    /**
     * verify a user's email
     */
    public function verify(Request $request)
    {
        $token = $request->token;
        $verifiedUser = VerifyUser::where('token', $token)->first();
        $verifiedUser;
        if(!is_null($verifiedUser)){
            $user = $verifiedUser->user;

            if(!$user->email_verified){ //if column is 0
                $verifiedUser->user->email_verified = 1;
                $verifiedUser->user->save();

                return redirect()->route('user.login')->with('success', 'Your email has been verified successfully.
                You can now login.')->with('verifiedEmail', $user->email);
            }
            else {
                return redirect()->route('user.login')->with('success', 'Your email is already verified. 
                You can login.')->with('verifiedEmail', $user->email);
            }
        }
    }


    /// RESET PASSWORD METHODS ///

    public function showForgotForm(){
        return view("user.forgot-password");
    }


    public function sendResetLink(Request $request){
        //validate email
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        //create token 
        $token = \Str::random(64);
        //store in password_resets table alongside email
        \DB::table('password_resets')->insert([
            'email'=>$request->email,
            'token'=>$token,
            'created_at'=>Carbon::now(),
        ]);

        $actionLink = route('user.reset.password.form', ['token'=>$token, 'email'=>$request->email]);
        $body = "We have received a request to reset the password for your Spoton account associated with "
        .$request->email.". You can reset your password by clicking the link below";

        \Mail::send('email.forgot-password', ['actionLink'=>$actionLink, 'body'=>$body], function($message) use($request){
            $message->from('noreply@spoton.com', 'Spoton 2');
            $message->to($request->email, 'Your name')
                    ->subject('Reset Password');
        });

        return back()->with('success', 'We have e-mailed your password reset link!');

    }

    public function showResetForm(Request $request, $token = null){
        return view('user.reset')->with(['token'=>$token, 'email'=>$request->email]);
    }

    public function resetPassword(Request $request)
    {               
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'min:6', 'max:25'],
            'password_confirmation' => ['required', 'same:password'],
        ]);


        //check if token of user was valid --> if yes, DB entry is retrieved, else NULL
        $check_token = \DB::table('password_resets')->where([
            'email'=>$request->email,
            'token'=>$request->token,
        ])->first();


        if(! $check_token){
            return back()->withInput()->with('error', 'Invalid token');
        }else {
            //update password
            User::where('email', $request->email)->update([
                'password' => \Hash::make($request->password),
            ]);
            //invalidate token
            \DB::table('password_resets')->where('email', $request->email,)->delete();
        }

        return redirect()->route('user.login')->with('success', 'Your password has been changed successfully!');
    }


    /// HOME METHODS /// 

    /**
     * shows all events the user is following
     */
    public function index()
    {
        $followed_profiles = auth()->user()->following()->pluck('organizer_profiles.organizer_id');
        $events = Event::whereIn('organizer_id', $followed_profiles)->with('organizer')->latest()->paginate(5);
        return view('user.home', compact('events'));

    }

 
}
