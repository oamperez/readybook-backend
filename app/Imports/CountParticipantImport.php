<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Validator;

class CountParticipantImport implements  ToModel, WithHeadingRow
{
    private $data = 0;

    public function model(array $row)
    {
        $this->data++;
        return;
    }

    public function getRowCount(): int
    {
        return $this->data;
    }
}
