<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    //Registro/POST
    public function register(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:8|confirmed',
        ]);

        $rolInvitado = Role::where('name', 'invitado')->firstOrFail();

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role_id'  => $rolInvitado->id,
        ]);

        return response()->json([
            'message' => 'Usuario registrado correctamente',
            'user'    => [
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->getRoleName(),
            ],
        ], 201);
    }


    //Inicio Sesion/POST
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Datos incorrectos :c'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'user'         => [
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->getRoleName(),
            ],
        ]);
    }


    //GET/me test
    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'name'  => $user->name,
            'email' => $user->email,
            'role'  => $user->getRoleName(),
            //'message' => 'Soy Batman',
        ]);
    }
}
