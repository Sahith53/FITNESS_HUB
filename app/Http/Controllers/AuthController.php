<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TrainerDetail;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * User Login Page
     * @return view
     */
    public function login()
    {
        if (auth()->user()) {
            return redirect()->route('home');
        }
        return view('Auth.login');
    }

    /**
     * Member Signup Page
     * @return view
     */
    public function signup()
    {
        if (auth()->user()) {
            return redirect()->route('home');
        }
        return view('Auth.signup');
    }

    /**
     * Trainer Registration Page
     * @return view
     */
    public function register()
    {
        if (auth()->user()) {
            return redirect()->route('home');
        }
        return view('Auth.register');
    }

    /**
     * User Authentication
     * @param Request
     * @return JsonResponse
     */
    public function authenticate(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "email" => "required|email|min:5|max:100",
                "password" => "required|min:8",
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $credentials = $request->only('email', 'password');

            if (auth()->attempt($credentials)) {
                $user = auth()->user();

                if ($user->role === "pending") {
                    auth()->logout();
                    request()->session()->invalidate();
                    request()->session()->regenerateToken();
                    return response()->json(['error' => 'Account is pending approval'], 403);
                }

                request()->session()->regenerate();

                return response()->json(['message' => 'Account created successfully'], 200);
            } else {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
        } catch (Exception) {
            return response()->json(['error' => 'Server Error'], 500);
        }
    }

    /**
     * Member Signup
     * @param Request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required|min:2|max:100",
                "email" => "required|email|min:5|max:100|unique:users,email",
                "phone" => "required|numeric|digits:10",
                "gender" => "required|in:M,F,O",
                "date_of_birth" => [
                    "required",
                    "date",
                    "before:" . Date::now()->subYears(15)->format('Y-m-d'),
                ],
                "password" => "required|min:8|max:16",
                "confirm_password" => "required|min:8|max:16|same:password"
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            User::create([
                "name" => $request->name,
                "email" => $request->email,
                "phone" => $request->phone,
                "gender" => $request->gender,
                "dob" => $request->date_of_birth,
                "password" => $request->password
            ]);

            return response()->json(['message' => 'Account created successfully'], 200);
        } catch (Exception) {
            return response()->json(['error' => 'Server Error'], 500);
        }
    }

    /**
     * Trainer Registration
     * @param Request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required|min:2|max:100",
                "email" => "required|email|min:5|max:100|unique:users,email",
                "date_of_birth" => [
                    "required",
                    "date",
                    "before:" . Date::now()->subYears(18)->format('Y-m-d'),
                ],
                "phone" => "required|numeric|digits:10",
                "gender" => "required|in:M,F,O",
                "occupation" => "required|min:2|max:100",
                "certificate_id" => "required|min:5|max:20",
                "issue_date" => "required|date",
                "expiry_date" => "nullable|date|after:issue_date",
                "issued_authority" => "required|min:2|max:100",
                "password" => "required|min:8|max:16",
                "confirm_password" => "required|min:8|max:16|same:password"
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "gender" => $request->gender,
                "dob" => $request->date_of_birth,
                "phone" => $request->phone,
                "password" => $request->password,
                "role" => "pending",
                "rating" => 0
            ]);

            TrainerDetail::create([
                "user_id" => $user->id,
                "occupation" => $request->occupation,
                "certificate_id" => $request->certificate_id,
                "issue_date" => $request->issue_date,
                "expiry_date" => $request->expiry_date,
                "issued_authority" => $request->issued_authority
            ]);

            return response()->json(['message' => 'Account created successfully'], 200);
        } catch (Exception) {
            return response()->json(['error' => 'Server Error'], 500);
        }
    }

    /**
     * User Logout
     * @return Redirect
     */
    public function logout()
    {
        auth()->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('home')->with('alert', 'Logged out Successfully!');
    }
}
