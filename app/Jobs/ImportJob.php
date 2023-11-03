<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ParticipantImport;
use Illuminate\Support\Facades\Log;

class ImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file;
    protected $id;

    public function __construct($file, $id)
    {
        $this->file = $file;
        $this->id = $id;
    }

    public function handle(): void
    {
        Log::info(Storage::path($this->file));
        $import = new ParticipantImport($this->id);
        Excel::import($import, Storage::path($this->file));
    }
}
