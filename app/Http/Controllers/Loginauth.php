<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class Loginauth extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateuser(Request $request)
    {   $username = $request->input('username');
        $password = $request->input('password');


        if (empty($username) || empty($password)) {
            // Si el nombre de usuario o contraseña están vacíos, retorna un mensaje de error
            return response()->json(['error' => 'Nombre de usuario y contraseña son obligatorios'], 400);
        }
        $user = User::where('name', $username)->first();

        // Intenta autenticar al usuario con los datos proporcionados
        if ($user) {

            if (($password === $user->password )) {
                $token = $user->createToken('MyAppToken')->accessToken;

                return response()->json([
                'user' => $user,
                'access_token' => $token,
            ]);

            } else {
                    // La contraseña es incorrecta, devuelve un mensaje de error
                    return response()->json(['error' => 'Credenciales incorrectas'], 401);
                }
        } else {
            // El usuario no existe, devuelve un mensaje de error
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
    

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
