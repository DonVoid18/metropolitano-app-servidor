<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PacienteController extends Controller
{

    public function listarPaciente()
    {
        $pacientes = Paciente::all();
        return response()->json($pacientes);
    }

    public function agregarpaciente(Request $request)
    {
        try {

            DB::beginTransaction();

            $pacientes = new Paciente();
            $pacientes->nombres = $request->nombre;
            $pacientes->email = $request->email;
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
    public function eliminar($id)
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
    public function update(Request $request, $id)
    {
        // Valida los datos del formulario

        DB::beginTransaction();
        // Recupera el paciente que deseas editar desde la base de datos
        $paciente = Paciente::find($id);

        // Verifica si se encontró un paciente
        if ($paciente) {
            // Actualiza los datos del paciente
            $paciente->nombres = $request->nombre;
            $paciente->email = $request->email;
            $paciente->save();

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
