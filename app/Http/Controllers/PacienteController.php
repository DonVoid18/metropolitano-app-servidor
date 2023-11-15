<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PacienteController extends Controller
{


    public function listarPacientes()
    {
        $pacientes = Paciente::all();
        return response()->json($pacientes);
    }


    public function agregarpaciente(Request $request)
    {
        try {

            DB::beginTransaction();

            $pacientes = new Paciente();
            $pacientes->numero_documento= $request->dni;
            $pacientes->nombres = $request->name;
            $pacientes->apellidos = $request->lastname;
            $pacientes->telefono = $request->phone;
            $pacientes->sexo = $request->sex;
            $pacientes->password = $request->password;
            $pacientes->estado_civil = $request->civil_status;
            $pacientes->direccion= $request->address;
            $pacientes->fecha_nacimiento= $request->birthdate;
            $pacientes->grupo_sangre= $request->blood_group;
            $pacientes->email = $request->email;

            if ($request->has('image')) {
                // Obtener la cadena base64 de la imagen
                $imagenBase64 = $request->input('image');
    
                // Decodificar la cadena base64 a datos binarios
                $imagenBinaria = base64_decode(explode(',', $imagenBase64)[1]);
    
                // Generar un nombre único para el archivo
                $nombreArchivo = 'imagen_' . uniqid() . '.png';
    
                // Guardar la imagen en storage/app/patient
                Storage::disk('public')->put($nombreArchivo, $imagenBinaria);
    
                // Actualizar el modelo con la ruta del archivo guardado
                $pacientes->imagen =  $nombreArchivo;
            }

            $pacientes->save();


            DB::commit();

            return [
                'action' => 'success',
                'title' => 'Bien!!',
                'message' => 'Los enlaces se crearon con éxito.'
            ];


        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'action' => 'error',
                'title' => 'Incorrecto!!',
                'message' => 'Ocurrio un error al crear los Enlaces, intente nuevamente o contacte al Administrador del Sistema. Código de error: ' . $e->getMessage(),
                'error' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    public function eliminarpaciente($id)
    {
        $paciente = Paciente::find($id);

        if (!$paciente) {
            return response()->json(['message' => 'Paciente no encontrado'], 404);
        }

        $paciente->delete();


        DB::commit();

        return [
            'action' => 'success',
            'title' => 'Bien!!',
            'message' => 'Los enlaces se crearon con éxito.'
        ];

    }

    public function actualizarpaciente(Request $request, $id)
    {
        // Valida los datos del formulario

        DB::beginTransaction();
        // Recupera el paciente que deseas editar desde la base de datos
        $pacientes = Paciente::find($id);

        // Verifica si se encontró un paciente
        if ($pacientes) {
            // Actualiza los datos del paciente
            $pacientes->numero_documento= $request->dni;
            $pacientes->nombres = $request->name;
            $pacientes->apellidos = $request->lastname;
            $pacientes->telefono = $request->phone;
            $pacientes->sexo = $request->sex;
            $pacientes->password = $request->password;
            $pacientes->estado_civil = $request->civil_status;
            $pacientes->grupo_sangre = $request->blood_group;
            $pacientes->direccion= $request->address;
            $pacientes->fecha_nacimiento= $request->birthdate;
            $pacientes->grupo_sangre= $request->blood_group;
            $pacientes->email = $request->email;

            // $pacientes->imagen =$request->image;
            $nombreArchivo = $request->image;
            $image = Paciente::where('imagen', $nombreArchivo)->first();

            if ($image) {

                $pacientes->imagen =$request->image;
            
            } 
            else 
            {
                $imagenBase64 = $request->input('image');
    
                // Decodificar la cadena base64 a datos binarios
                $imagenBinaria = base64_decode(explode(',', $imagenBase64)[1]);
    
                // Generar un nombre único para el archivo
                $nombreArchivo = 'imagen_' . uniqid() . '.png';
    
                // Guardar la imagen en storage/app/patient
                Storage::disk('public')->put($nombreArchivo, $imagenBinaria);
    
                // Actualizar el modelo con la ruta del archivo guardado
                $pacientes->imagen =  $nombreArchivo;

            }
  
            

            $pacientes->save();

            DB::commit();

            return [
                'action' => 'success',
                'title' => 'Bien!!',
                'message' => 'Los enlaces se crearon con éxito.'
            ];

        }

    }


    public function getCsrfToken()
    {
        $csrfToken = csrf_token();

        return response($csrfToken);

    }
}
