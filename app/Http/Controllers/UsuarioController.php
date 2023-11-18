<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Usuario;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
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
    public function agregarusuario(Request $request)
    {
        try {

            DB::beginTransaction( );
            $usuario = new Usuario();
            $usuario->numero_documento =$request->numero_documento;
            $usuario->nombre=$request->nombres;
            $usuario->telefono=$request->telefono;
            $usuario->correo=$request->correo;
            $usuario->password =$request->password;
            $usuario->tipo =$request->tipo;
            $usuario->created_at = now();
            $usuario->save();


            DB::commit();

            return response()->json(['id' => $usuario], 201); 

        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'action'    =>  'error',
                'title'     =>  'Incorrecto!!',
                'message'   =>  'Ocurrio un error al crear los Enlaces, intente nuevamente o contacte al Administrador del Sistema. Código de error: '.$e->getMessage(),
                'error'     =>  'Error: '.$e->getMessage()
            ];
        }
         
    }


    public function validarusuario(Request $request)
    {
        $request->validate([
            'numero_documento' => 'required',
            'password' => 'required',
        ]);

        try {

            $usuario = Usuario::where('numero_documento', $request->numero_documento)
            ->where('password', $request->password)
            ->first();
      
            if ($usuario) {
                // La autenticación ha sido exitosa
                return response()->json(['message' => 'Inicio de sesión exitoso'], 200);
            } else {
                // La autenticación ha fallado
                return response()->json(['message' => 'Credenciales no válidas'], 401);
            }


            
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'action'    =>  'error',
                'title'     =>  'Incorrecto!!',
                'message'   =>  'Ocurrio un error al crear los Enlaces, intente nuevamente o contacte al Administrador del Sistema. Código de error: '.$e->getMessage(),
                'error'     =>  'Error: '.$e->getMessage()
            ];
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
