<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Departamento;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function buscarcitas()
    {
        // $doctores = Doctor::with([
        //     'horarios' => function ($query) {
        //         $query->where('horarios.activo', 'S');
        //     },
        //     'departamento' => function ($query) {
        //         $query->where('departamentos.activo', 'S');
        //     },
        //     'especialidades' => function ($query) {
        //         $query->where('especialidades.activo', 'S');
        //     }
        // ])
        // ->where('doctores.activo', 'S')
        // ->get();
        // $departamentos = Departamento::where('activo', 'S')->get();       
        $citas = Cita::where('activo', 'S')->get();
        return response()->json([
            'citas' => $citas,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function agregarcitas(Request $request)
    {
        try {

    
            DB::beginTransaction();

            $cita = new Cita();
            $cita ->cod_paciente =$request->cod_paciente;
            $cita ->cod_doctor =$request->cod_doctor;
            $cita->cod_departamento =$request->cod_departamento;
            $cita->fecha =$request->fecha;
            $cita->hora_inicio=$request->hora_inicio;
            $cita->hora_fin=$request->hora_fin;
            $cita->updated_at= now();
            $cita->save();

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


       public function actualizarcitas(Request $request, $id)
    {
        DB::beginTransaction();
        // Recupera el paciente que deseas editar desde la base de datos
        $citapaciente = Cita::find($id);

        // Verifica si se encontró un paciente
        if ($citapaciente) {
            // Actualiza los datos del paciente
            $citapaciente ->cod_paciente =$request->cod_paciente;
            $citapaciente ->cod_doctor =$request->cod_doctor;
            $citapaciente->cod_departamento =$request->cod_departamento;
            $citapaciente->fecha =$request->fecha;
            $citapaciente->hora_inicio=$request->hora_inicio;
            $citapaciente->hora_fin=$request->hora_fin;
            $citapaciente->updated_at=$request->now();
            $citapaciente->save();
            }

            DB::commit();

            return [
                'action' => 'success',
                'title' => 'Bien!!',
                'message' => 'Los enlaces se crearon con éxito.'
            ];

    }

    public function eliminarcitas($id)
    {
        try {
            $horario = Cita::findOrFail($id);
            $horario->delete();

            return response()->json(['success' => true, 'message' => 'Cita eliminado con éxito']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar el horario']);
        }
    }

}
