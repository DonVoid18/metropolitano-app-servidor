<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Especialidad;
use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{

    public function buscarespecialidad()
    {
   
        $especialidades = Especialidad::all();
        return response()->json($especialidades);
    }

    public function agregardoctor(request $request)
    {
        
        try {

            DB::beginTransaction();
            $doctor = new Doctor();
            $doctor->dni =$request->dni;
            $doctor->nombres=$request->nombres;
            $doctor->apellidos=$request->apellidos;
            $doctor->cod_especialidad=$request->cod_especialidad;
            $doctor->cod_departamento=$request->cod_departamento;
            $doctor->sexo=$request->sexo;
            $doctor->telefono=$request->telefono;
            $doctor->correo=$request->correo;
            $doctor->created_at = now();
            $doctor->save();
            $doctor = $doctor->id;

            DB::commit();

            return response()->json(['action' => 'success', 'id' => $doctor], 201);


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


    public function agregarhorario_doctor(request $request)
    {
        
        try {

            DB::beginTransaction();
                $doctorId = $request->input('doctorId');    
                $horarios = $request->input('horarios');
                foreach ($horarios as $horarioData) {
                    
                    $horario = new Horario();
                    $horario->doctor_id = $doctorId;
                    $horario->inicio = $horarioData['inicio'];
                    $horario->fin = $horarioData['fin'];
                    $horario->dias_semana = $horarioData['dias_semana'];
                    // Agrega otras propiedades según tu modelo Horario
                    $horario->save();
                }

            DB::commit();
           
            return [
                'action'    =>  'success',
                'title'     =>  'Bien!!',
                'message'   =>  ' Se registró con éxito.',
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

    public function listardoctores()
    {
        $doctores = Doctor::with(['horarios','departamento','especialidades'])->get();
            return response()->json($doctores);
    }
    

    


    public function actualizardoctor(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
    
        // Verifica si la condición para establecer 'activo' a 'S' se cumple
        if ($request->has('activo') && $request->input('activo') === 'Activo') {
            $request->merge(['activo' => 'S']);
        }
        $doctor->update($request->all());

        $horariosAnteriores = $request->input('horarioanterior');
        foreach ($horariosAnteriores as $horarioAnterior) {
            // Verificar si el horario no está registrado
            if (!$horarioAnterior['registrado']) {
                // Eliminar el horario de la base de datos
                Horario::where([
                    'cod_doctor' => $id,
                    'dias_semana' => $horarioAnterior['dias_semana'],
                    'entrada' => $horarioAnterior['entrada'],
                    'salida' => $horarioAnterior['salida'],
                    // Asegúrate de ajustar estas condiciones según tu modelo y estructura de base de datos
                    // Puedes agregar más condiciones si es necesario
                ])->delete();
            }
        }

        $horariosNuevos = $request->input('horarios');

        foreach ($horariosNuevos as $horarioNuevo) {
            // Verificar si el horario no existe en la base de datos para este doctor
            $existenciaHorario = Horario::where([
                'cod_doctor' => $id,
                'dias_semana' => $horarioNuevo['dias_semana'],
                'entrada' => $horarioNuevo['entrada'],
                'salida' => $horarioNuevo['salida'],
                // Ajusta estas condiciones según tu modelo y estructura de base de datos
                // Puedes agregar más condiciones si es necesario
            ])->exists();
            // Si el horario no existe, regístralo
            if (!$existenciaHorario) {
                Horario::create([
                    'cod_doctor' =>  $id,
                    'dias_semana' => $horarioNuevo['dias_semana'],
                    'entrada' => $horarioNuevo['entrada'],
                    'salida' => $horarioNuevo['salida'],
                    // Ajusta estos campos según tu modelo y estructura de base de datos
                    // Puedes agregar más campos si es necesario
                ]);
            }
        }

        
        return response()->json(['message' => 'Doctor actualizado con éxito']);
    }
        

    public function eliminardoctor($id)
    {
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return response()->json(['error' => 'Doctor no encontrado'], 404);
        }

        // Elimina los horarios asociados al doctor
        $doctor->horarios()->delete();

        // Finalmente, elimina el doctor
        $doctor->delete();

        // Devuelve una respuesta actualizada, por ejemplo, la lista de doctores actualizada
        $doctores = Doctor::all();
        return response()->json($doctores);
    }
    //horario doctor//
    public function agregarhorario(Request $request)
    {
 
        try {

            DB::beginTransaction();

                $doctorId = $request->input('doctorId');    
                $horarios = $request->input('horarios');

                foreach ($horarios as $horarioData) {
                    
                    $horario = new Horario();
                    $horario->cod_doctor = $doctorId;
                    $horario->entrada = $horarioData['inicio'];
                    $horario->salida = $horarioData['fin'];
                    $horario->dias_semana = $horarioData['dias_semana'];
                    // Agrega otras propiedades según tu modelo Horario
                    $horario->save();
                }

            DB::commit();
           
            return [
                'action'    =>  'success',
                'title'     =>  'Bien!!',
                'message'   =>  ' Se registró con éxito.',
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


    public function buscarhorarios()
    {
        $horarios = Horario::all();
        return response()->json($horarios);
    }

    public function actualizarHorario($idDoctor, Request $request)
    {
        $nuevosHorarios = collect($request->json()->all());

     return $nuevosHorarios;

    }
    public function eliminarHorario($id)
    {
        try {
            $horario = Horario::findOrFail($id);
            $horario->delete();

            return response()->json(['success' => true, 'message' => 'Horario eliminado con éxito']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar el horario']);
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
