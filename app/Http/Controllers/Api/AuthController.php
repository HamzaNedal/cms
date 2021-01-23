<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthLoginRequest;
use App\Http\Requests\Api\AuthRegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function login(AuthLoginRequest $authLoginRequest)
    {

        if (Auth::attempt(['email' => $authLoginRequest->email, 'password' => $authLoginRequest->password])) {
            return $this->getRefreshedToken($authLoginRequest->email, $authLoginRequest->password);
            // return $this->token(auth()->user());
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized'
            ]);
        }
    }

    public function register(AuthRegisterRequest $authRegisterRequest)
    {
        $user = User::create($authRegisterRequest->only(['name', 'username', 'email', 'mobile', 'password', 'status']));
        $user->attachRole(Role::whereName('user')->first()->id);
        return $this->getRefreshedToken($authRegisterRequest->email, $authRegisterRequest->password);
        // return $this->token($user);
    }


    public function getRefreshedToken($email, $password)
    {

        $response = Http::asForm()->post('http://localhost:8001/oauth/token', [
            'grant_type' => 'password',
            'client_id' => config('passport.personal_access_client.id'),
            'client_secret' => config('passport.personal_access_client.secret'),
            'username' => $email,
            'password' => $password,
            'scope' => '*',
        ]);

        return $response->json();
    }

    public function token($user)
    {
        return response()->json([
            'error' => true,
            'token' => $user->createToken('access_token')->accessToken,
        ]);
    }

    public function refersh_token(Request $request)
    {
        try {
            $refresh_token = $request->header('refresh_token_code');

            $response = Http::asForm()->post('http://localhost:8001/oauth/token', [
                'grant_type' => 'refresh_token',
                'refresh_token' => $refresh_token,
                'client_id' => config('passport.personal_access_client.id'),
                'client_secret' => config('passport.personal_access_client.secret'),
                'scope' => '*',
            ]);

            return $response->json();
        } catch (\Throwable $th) {
            return response()->json('Unauthorized', 200);
        }
    }
}
