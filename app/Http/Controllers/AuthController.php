<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     * Non devo verificare se c'è un token o no quando facciamo login ma anche quando facciamo singup 
     * perchè non ho il token visto che mi sto registrando. Escludo singup dalla protezione 
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'singup']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Wrong usename or password'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the registration user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function singup(Request $request)
    {
        $name = $request::input('name');
        $email = $request::input('email');
        $password = $request::input('password');

        //verifico se email esiste, con laravel eloquent, cosa fa eloquent?
        //eloquent vede che c'è un where e vede se c'è un altro pezzo dopo (Email), lo mette in lowerCase e andrà a confrontare
        //la colonna email con il valore che sto passando
        $userExist = User::whereEmail($email)->exists();
        //se utente esiste lancio un errore
        if ($userExist) {
            return response()->json(['error' => 'Email ' . $email . ' already exists'], 401);
        }
        //se utente non esiste
        //1° modo
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        // per 2° modo $passcrypted = Hash::make($password);

        //non registro password in chiaro, devo creare la Hash della password. Uso la facades/Hash di laravel
        $user->password = Hash::make($password);
        $user->save();
        //2° modo
        //$user = User::create(compact('name', 'email', 'passcrypted'));

        if (!$token = auth()->login($user)) {
            return response()->json(['error' => 'Error creating user'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
