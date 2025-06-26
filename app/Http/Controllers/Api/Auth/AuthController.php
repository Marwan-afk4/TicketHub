<?php

namespace App\Http\Controllers\Api\Auth;
use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\Auth\SignupUserRequest;
use App\Models\User;
use App\Models\Nationality;
use App\Models\Wallet;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgetPasswordMail;
use App\Mail\VerificationEmail;

use Google_Client;

class AuthController extends Controller
{
    public function __construct(private Currency $currency, private Wallet $wallet){}

    public function lists(){
        // /api/lists
        $nationality = Nationality::get();
        
        return response()->json([
            'nationality' => $nationality,
        ]);
    }


    public function send_code(Request $request){
        // /api/send_code
        // keys
        // email
        $validation = Validator::make($request->all(),[
            'email' => 'required|email',
        ]);
        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }

        $code = rand(100000, 999999);
        Mail::to($request->email)->send(new VerificationEmail($code));
        
        return response()->json([
            'success'=> $code, 
        ]);
    }

    public function Register(SignupUserRequest $request){
        // /api/register
        // keys
        // password, email, nationality_id, name, phone, gender => [male,female],
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'user';
        $user = User::create($validated);
        $user->modules;
        $token = $user->createToken('auth_token')->plainTextToken;
        $currencies = $this->currency
        ->where('status', 1)
        ->get();
        foreach ($currencies as $item) {
            $this->wallet
            ->create([
                'user_id' => $user->id,
                'currency_id' => $item->id,
                'amount' => 0,
            ]);
        }
        return response()->json([
            'token' => $token,
            'message'=>'user Added Successfully',
            'user' => $user
        ]);
    }

    public function login(Request $request){
        // /api/login
        // keys
        // password,email
        $validation = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required',
        ]);
        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }

        $user=User::where('email', $request->email)
        ->where('role', 'admin')
        ->orWhere('phone', $request->email)
        ->where('role', 'admin')
        ->with('modules', 'position.roles')
        ->first();
        if(!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['errors' => 'The provided credentials are incorrect'], 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message'=>'Login Successfully',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function login_user(Request $request){
        // /api/login_user
        // keys
        // password,email
        $validation = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required',
        ]);
        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }

        $user = User::where('email', $request->email)
        ->where('role', 'user')
        ->whereNotNull('password')
        ->orWhere('phone', $request->email)
        ->where('role', 'user') 
        ->whereNotNull('password')
        ->first();
        if(!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['errors' => 'The provided credentials are incorrect'], 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        $user->token = $token;
        return response()->json([
            'message'=>'Login Successfully',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function login_agent(Request $request){
        // /api/login_agent
        // keys
        // password,email
        $validation = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required',
        ]);
        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }

        $user=User::where('email', $request->email)
        ->where('role', 'agent')
        ->orWhere('phone', $request->email)
        ->where('role', 'agent')
        ->with('modules')
        ->first();
        if(!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['errors' => 'The provided credentials are incorrect'], 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        $user->token = $token;
        return response()->json([
            'message'=>'Login Successfully',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function forget_password(Request $request){
        // /api/forget_password
        // keys
        // email
        $validation = Validator::make($request->all(),[
            'email' => 'required|email',
        ]);
        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }

        $code = rand(100000, 999999);
        Mail::to($request->email)->send(new ForgetPasswordMail($code));
        $user=User::where('email', $request->email)
        ->update([
            'code' => $code
        ]);
        
        return response()->json([
            'success'=>'Code is sent Successfully', 
        ]);
    }

    public function check_code(Request $request){
        // /api/check_code
        // keys
        // email, code
        $validation = Validator::make($request->all(),[
            'email' => 'required|email',
            'code' => 'required',
        ]);
        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }

        $user=User::where('email', $request->email)
        ->where('code', $request->code)
        ->whereNotNull('code')
        ->first();

        if (empty($user)) {
            return response()->json([
                'errors' => 'Code or email is wrong'
            ], 400);
        }

        return response()->json([
            'success' => 'Code is true'
        ]);
    }

    public function change_password(Request $request){
        // /api/change_password
        // keys
        // email, code, new_password
        $validation = Validator::make($request->all(),[
            'email' => 'required|email',
            'code' => 'required',
            'new_password' => 'required|min:7',
        ]);
        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }

        $user=User::where('email', $request->email)
        ->where('code', $request->code)
        ->whereNotNull('code')
        ->first();

        if (empty($user)) {
            return response()->json([
                'errors' => 'Code or email is wrong'
            ], 400);
        }
        $user->update([
            'code' => null,
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json([
            'success' => 'You update data success'
        ]);
    }

    public function logout(Request $request){
        // /api/logout
        $user = $request->user();
        if ($user) {
            $user->tokens()->delete();
            return response()->json([
                'success' => 'You have successfully logged out.'
            ]);
        }
        
        return response()->json([
            'error' => 'Failed to log out.'
        ], 400);
        
    }

    public function delete_account(Request $request){
        // /api/delete_account
        $user = $request->user()->delete(); 
        
        return response()->json([
            'success' => 'You delete data success'
        ]);
    }

    public function sign_up_google(Request $request){
        $validation = Validator::make($request->all(),[
            'id_token' => 'required',
            'client_id' => 'required',
        ]);
        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }
        $client = new Google_Client(['client_id' => $request->client_id]); // ضع Google Client ID الخاص بتطبيقك
        $payload = $client->verifyIdToken($request->id_token);
    
        if (!$payload) {
            return response()->json(['error' => 'Invalid Google token'], 400);
        }

        $user = User::updateOrCreate(
            ['email' => $payload['email']],
            [
                'name' => $payload['name'],
                'google_id' => $payload['sub'], // unique ID from Google
                'image' => $payload['picture'] ?? null,
            ]
        );
 
        $token = $user->createToken('user_google')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function login_google(Request $request){
       $validation = Validator::make($request->all(),[
            'id_token' => 'required',
            'client_id' => 'required',
        ]);
        if($validation->fails()){
            return response()->json(['message'=>$validation->errors()],400);
        }

        $client = new Google_Client(['client_id' => $request->client_id]); // ضع Google Client ID الخاص بتطبيقك
        $payload = $client->verifyIdToken($request->id_token);
    
        if (!$payload) {
            return response()->json(['error' => 'Invalid Google token'], 400);
        }

        $user = User::where('email', $payload['email'])->first();

        if (!$user) {
            return response()->json(['error' => 'User not registered'], 400);
        }

        $token = $user->createToken('user_google')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }
}
