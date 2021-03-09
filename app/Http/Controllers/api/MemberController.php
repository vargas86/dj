<?php

namespace App\Http\Controllers\api;

use DB;
use Validator;
use App\Models\User;
use App\Models\Member;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Rules\MatchOldPassword;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Exception;

// Models
use Illuminate\Support\Facades\Hash;

// Mails
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\Member\ConfirmPasswordReset;
use App\Mail\Member\RequestPasswordReset;

// Rules
use App\Mail\Member\ConfirmPasswordChange;
use App\Mail\Member\ConfirmEmailValidation;

class MemberController extends Controller
{
    //
    public function __construct()
    {
        //$this->middleware('jwt', ['except' => ['login', 'register', 'sendresetpassword', 'resetpassword']]);
    }

    /**
     * Register
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|between:2,100',
            'lastname' => 'required|between:2,100',
            'phone' => 'required|between:8,20',
            'email' => 'required|email|unique:users|max:50',
            'password' => 'required|confirmed|string|min:6|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        ($user = User::create([
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]))->sendEmailVerificationNotification();
        $user->refresh();
        return response()->json(['user' => $user], 200);
    }

    /**
     * Update
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|between:2,100',
            'lastname' => 'required|between:2,100',
            'phone' => 'required|between:8,20',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Save User
        $user_id = auth('api')->user()->id;
        $user = Member::find($user_id);

        if ($user) {

            $user->firstname = $request->get('firstname');
            $user->lastname = $request->get('lastname');
            $user->phone = $request->get('phone');
            $user->save();

            unset($user['id']);
            unset($user['name']);
            unset($user['created_at']);
            unset($user['updated_at']);
            unset($user['email_verified_at']);
            unset($user['settings']);
            unset($user['role_id']);

            return response()->json(['user' => $user], 200);
        } else {
            return response()->json(['error' => 'User not found'], 401);
        }
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth('api')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // User
        $user = auth('api')->user();


        // Token
        $token = $this->createNewToken($token);

        return \array_merge($token->original, ['user' => $user]);
    }

    /**
     * Profile
     */
    public function profile()
    {
        // User
        $user = auth('api')->user();
        unset($user['id']);
        unset($user['name']);
        unset($user['created_at']);
        unset($user['updated_at']);
        unset($user['email_verified_at']);
        unset($user['settings']);
        unset($user['role_id']);

        return response()->json($user);
    }

    /**
     * Send Reset Password Request
     */
    public function sendresetpassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $email = $request->get('email');
        $user = Member::where('email', $email)->first();

        if ($user) {

            // Delete user's tokens
            DB::table('password_resets')->where('email', '=', $email)->delete();

            // Token
            $token = Str::random(60);
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);

            Mail::to($user->email)->send(new RequestPasswordReset($user, $token));

            return response()->json([], 200);
        } else {
            return response()->json([], 304);
        }
    }

    /**
     * Reset Password
     */
    public function resetpassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:50',
            'token' => 'required|min:60|max:60',
            'password' => 'required|confirmed|string|min:6|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $email = $request->get('email');
        $token = $request->get('token');
        $timeout = (setting('site.token_reset_password_timeout')) ? setting('site.token_reset_password_timeout') : 60;

        $expiration_date = (new \DateTime())->modify('-' . $timeout . ' minutes')->format('Y-m-d H:i:s');

        // Check token validity
        $user = DB::table('password_resets')
            ->where('email', '=', $email)
            ->where('token', '=', $token)
            ->where('created_at', '>', $expiration_date)
            ->first();

        if ($user) {

            // Delete user's tokens
            DB::table('password_resets')->where('email', '=', $email)->delete();

            // Reste password
            $user = Member::where('email', $user->email)->first();
            $user->password = bcrypt($request->password);
            $user->save();

            // Send Reset password confirmation
            Mail::to($user->email)->send(new ConfirmPasswordReset($user));

            return response()->json([], 200);
        } else {
            return response()->json([], 304);
        }
    }

    /**
     * Verify email
     */
    public function verifyemail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:50',
            'token' => 'required|min:60|max:60',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $email = $request->get('email');
        $token = $request->get('token');
        $timeout = (setting('site.token_validation_email_timeout')) ? setting('site.token_reset_password_timeout') : 60;

        $expiration_date = (new \DateTime())->modify('-' . $timeout . ' minutes')->format('Y-m-d H:i:s');

        // Check token validity
        $user = DB::table('email_validations')
            ->where('email', '=', $email)
            ->where('token', '=', $token)
            ->where('created_at', '>', $expiration_date)
            ->first();

        if ($user) {

            // Delete user's tokens
            DB::table('email_validations')->where('email', '=', $email)->delete();

            // Validate Account
            $user = Member::where('email', $user->email)->first();
            $user->email_verified_at = Carbon::now();
            $user->save();

            // Send email validation confirmation
            Mail::to($user->email)->send(new ConfirmEmailValidation($user));

            return response()->json([], 200);
        } else {
            return response()->json([], 304);
        }
    }

    /**
     * Change password
     */
    public function changepassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => ['required', new MatchOldPassword],
            'password' => 'required|confirmed|string|min:6|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // get user
        try {
            $user = Member::find(auth('api')->user()->id);
        } catch (Exception $e) {
            return response()->json([$e->getMessage()], 200);
        }

        if ($user) {
            // Update Password
            $password = Hash::make($request->get('password'));
            $user->password = $password;
            $user->save();

            // Send Reset password confirmation
            Mail::to($user->email)->send(new ConfirmPasswordChange($user));

            return response()->json([], 200);
        } else {
            return response()->json([], 304);
        }
    }

    /**
     * Change email
     */
    public function changeemail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'max:50', 'unique:users,email,' . auth('api')->user()->id]
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $email = $request->get('email');

        // get user
        $user = Member::find(auth('api')->user()->id);

        if ($user) {

            // Check if the new email is same as the old email
            if ($user->email == $email) {
                return response()->json([], 304);
            }

            // Update Email
            $user->email = $email;
            $user->email_verified_at = null;
            $user->save();

            // Send Reset password confirmation
            $user->sendEmailVerificationNotification();

            return response()->json([], 200);
        } else {
            return response()->json([], 304);
        }
    }

    /**
     * Change avatar
     */
    public function changeavatar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => ['required', 'mimes:png,jpg,jpeg', 'max:2048']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $mimeType = $request->file('avatar')->getMimeType();
        list($type, $ext) = explode('/', $mimeType);

        $file_name = Str::random(16) . '.' . $ext;
        $path = $request->file('avatar')->storeAs('users', time() . $file_name, 'public');

        // get user
        $user = Member::find(auth('api')->user()->id);

        if ($user) {

            // Delete old avatar
            Storage::delete('public/' . auth('api')->user()->avatar);

            // Store new avatar path
            $user->avatar = $path;
            $user->save();

            return response()->json(['avatar' => $path], 200);
        } else {
            return response()->json([], 304);
        }
    }

    /**
     * Change language
     */
    public function changelanguage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language' => ['required', 'min:2', 'max:2', 'in:fr,en']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $language = $request->get('language');

        // get user
        $user = Member::find(auth('api')->user()->id);

        if ($user) {

            $settings = $user->settings;
            $settings['locale'] = $language;

            // Update languages
            $user->settings = $settings;
            $user->save();

            return response()->json([$language], 200);
        } else {
            return response()->json([], 304);
        }
    }

    /**
     * Refresh a token.
     */
    public function refresh()
    {
        return $this->createNewToken(auth('api')->refresh());
    }

    /**
     * Logout
     */
    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the token array structure.
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ]);
    }
}
