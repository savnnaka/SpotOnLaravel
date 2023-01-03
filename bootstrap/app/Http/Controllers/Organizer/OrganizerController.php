<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Organizer;
use Hash;
use App\Models\VerifyOrganizer;
use Carbon\Carbon;
use App\Models\Event;

class OrganizerController extends Controller
{
    public function create(Request $request){
        
        $request->validate([
            'name' => 'required',
            'fullname' => 'required',
            'email' => 'required|email|unique:organizers',
            'phone' => 'required',
            'city' => 'required',
            'password' => 'required|min:6|max:15',
            'cpassword' => 'required|same:password',
        ], [
            'cpassword.required' => 'The confirm field is required.',
            'cpassword.same' => 'Confirm password and password must match.'
        ]);

        // call Organizer model
        $organizer = new Organizer();
        $organizer->name = $request->name;
        $organizer->fullname = $request->fullname;
        $organizer->email = $request->email;
        $organizer->phone = $request->phone;
        $organizer->city = $request->city;
        $organizer->password = Hash::make($request->password);
        // Safe Organizer Model
        $dataSaved = $organizer->save();
        
        // create token (out of id) and verifyURL
        $last_id = $organizer->id;
        $token = $last_id.hash('sha256', \Str::random(120));
        $verifyURL = route('organizer.verify', ['token'=>$token, 'service'=>'Email Verification']);

        VerifyOrganizer::create([
            'organizer_id' => $last_id,
            'token' => $token,
        ]);

        // create message
        $message = 'Dear <b>'.$request->name.',</b><br>';
        $message.= 'Thanks for signing up, we just need you to verify your email city to ';
        $message.= 'complete setting up your account';
        
        $mail_data = [
            'recipient'=>$request->email,
            'fromEmail'=>'spoton@register.com',
            'fromName'=>'Spoton Register',
            'subject'=>'Email Verification',
            'body'=>$message,
            'actionLink'=>$verifyURL,
        ];

        try { 
            // Try to send email
            \Mail::send('organizer.email-template', $mail_data, function($message) use ($mail_data){
                $message->to($mail_data['recipient'])
                        ->from($mail_data['fromEmail'], $mail_data['fromName'])
                        ->subject($mail_data['subject']);
            });

        } catch (Exception $e){
            // Registration failed, delete database record
            Organizer::where('id', $last_id)->delete();
            return redirect()->back()->with('error', $e);
        }



        if($dataSaved){
            return redirect()->back()->with('success', 'You need to confirm your email.');
        }else{
            // Registration failed, delete database record
            Organizer::where('id', $last_id)->delete();
            return redirect()->back()->with('error', 'Registration failed.');
        }


    }

    public function dologin(Request $request){

        $request->validate([
            'email' => 'required|email|exists:organizers,email',
            'password' => 'required|min:6|max:15',
        ]);

        

        $check = $request->only('email', 'password');

        if(Auth::guard('organizer')->attempt($check)){
            return redirect()->route('organizer.home')->with('success', 'Welcome to dashboard');
        }else {
            return redirect()->back()->with('error', 'Login Failed.');
        }
    }

    public function logout(Request $request){
        
        Auth::guard('organizer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function verify(Request $request)
    {
        $token = $request->token;
        $verifyOrganizer = VerifyOrganizer::where('token', $token)->first();
        $verifyOrganizer;

        if(!is_null($verifyOrganizer)){
            $organizer = $verifyOrganizer->organizer;

            if(!$organizer->email_verified){ //if email_verified is set to 0
                $verifyOrganizer->organizer->email_verified = 1;
                $verifyOrganizer->organizer->save();

                return redirect()->route('organizer.login')->with('success', 'Your email has been
                verified. You can now login')->with('verifiedEmail', $organizer->email);
            }else {
                return redirect()->route('organizer.login')->with('success', 'Your email has already been
                verified. You can login')->with('verifiedEmail', $organizer->email);
            }
        }
    }


    /**
     * PASSWORD RESET
     */

    public function showForgotForm(){
        return view("organizer.forgot-password");
    }


    public function sendResetLink(Request $request){
        //validate email
        $request->validate([
            'email' => ['required', 'email', 'exists:organizers,email'],
        ]);

        //create token 
        $token = \Str::random(64);
        //store in password_resets table alongside email
        \DB::table('password_resets')->insert([
            'email'=>$request->email,
            'token'=>$token,
            'created_at'=>Carbon::now(),
        ]);

        $actionLink = route('organizer.reset.password.form', ['token'=>$token, 'email'=>$request->email]);
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
        return view('organizer.reset')->with(['token'=>$token, 'email'=>$request->email]);
    }

    public function resetPassword(Request $request)
    {               
        $request->validate([
            'email' => ['required', 'email', 'exists:organizers,email'],
            'password' => ['required', 'min:6', 'max:25'],
            'password_confirmation' => ['required', 'same:password'],
        ]);


        //check if token of organizer was valid --> if yes, DB entry is retrieved, else NULL
        $check_token = \DB::table('password_resets')->where([
            'email'=>$request->email,
            'token'=>$request->token,
        ])->first();


        if(! $check_token){
            return back()->withInput()->with('error', 'Invalid token');
        }else {
            //update password
            organizer::where('email', $request->email)->update([
                'password' => \Hash::make($request->password),
            ]);
            //invalidate token
            \DB::table('password_resets')->where('email', $request->email,)->delete();
        }

        return redirect()->route('organizer.login')->with('success', 'Your password has been changed successfully!');
    }


    /// HOME METHODS /// 

    /**
     * shows all events the user is following
     */
    public function index()
    {
        $events = Event::where('city', 'Tübingen')->latest()->paginate(5);
        return view('home', compact('events'));
    }
}
