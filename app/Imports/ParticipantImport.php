<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Participant;
use Carbon\Carbon;
use Validator;

class ParticipantImport implements ToModel, WithHeadingRow
{
    use Importable;

    protected $appointment_id;

    public function  __construct($appointment_id)
    {
        $this->appointment_id = $appointment_id;
    }

    public function model(array $row)
    {
        $request = [
            'cui' => $row['dpi'],
            'name' => $row['nombre_completo'],
            'appointment_id' => $this->appointment_id,
            'age' => $row['edad'],
            'gender' => $row['genero'],
            'country' => $row['pais_de_origen'],
        ];
        $data = Participant::create($request);
        $data->save();
        return;
    }
}
