<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function listardepartamento()
     {
         $departamento = Departamento::all();
         return response()->json($departamento);
     }

    public function agregardepartamento( Request $request)
    {
        try {

            DB::beginTransaction();
            $departamento = new Departamento();
            $departamento->encargado=$request->encargado;
            $departamento->nombre=$request->nombre;
            $departamento->descripcion=$request->descripcion;
            

            if ($request->has('imagen')) {
                // Obtener la cadena base64 de la imagen
                $imagenBase64 = $request->input('imagen');
    
                // Decodificar la cadena base64 a datos binarios
                $imagenBinaria = base64_decode(explode(',', $imagenBase64)[1]);
    
                // Generar un nombre único para el archivo
                $nombreArchivo = 'imagen_' . uniqid() . '.png';
    
                // Guardar la imagen en storage/app/patient
                Storage::disk('public')->put($nombreArchivo, $imagenBinaria);
    
                // Actualizar el modelo con la ruta del archivo guardado
                $departamento->imagen =  $nombreArchivo;
            }
            $departamento ->save();

            DB::commit();

            return [
                'action' => 'success',
                'title' => 'Bien!!',
                'message' => 'Los enlaces se crearon con éxito.'
            ];

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

    public function actualizardepartamento(Request $request, $id)
    {
        DB::beginTransaction();
        // Recupera el paciente que deseas editar desde la base de datos
        $departamento = Departamento::find($id);

        // Verifica si se encontró un paciente
        if ($departamento) {
            // Actualiza los datos del paciente
            $departamento->encargado =$request->encargado;
            $departamento->nombre=$request->nombre;
            $departamento->descripcion=$request->descripcion;

            // $departamento->imagen =$request->image;
            $nombreArchivo = $request->imagen;
            $image = Departamento::where('imagen', $nombreArchivo)->first();

            if ($image) {

                $departamento->imagen =$request->imagen;
            
            } 
            else 
            {
                $imagenBase64 = $request->input('imagen');
    
                // Decodificar la cadena base64 a datos binarios
                $imagenBinaria = base64_decode(explode(',', $imagenBase64)[1]);
    
                // Generar un nombre único para el archivo
                $nombreArchivo = 'imagen_' . uniqid() . '.png';
    
                // Guardar la imagen en storage/app/patient
                Storage::disk('public')->put($nombreArchivo, $imagenBinaria);
    
                // Actualizar el modelo con la ruta del archivo guardado
                $departamento->imagen =  $nombreArchivo;

            }
            $departamento->save();

            DB::commit();

            return [
                'action' => 'success',
                'title' => 'Bien!!',
                'message' => 'Los enlaces se crearon con éxito.'
            ];

    }
 }

    public function eliminardepartamento($id)
    {
        $paciente = Departamento::find($id);

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


}
