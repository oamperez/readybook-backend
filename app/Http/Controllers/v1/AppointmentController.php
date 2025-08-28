<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CountParticipantImport;
use Illuminate\Support\Facades\Storage;
use App\Imports\ParticipantImport;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use App\Mail\AppointmentMail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\MailSetting;
use App\Models\Appointment;
use App\Models\Participant;
use App\Models\Category;
use App\Jobs\ImportJob;
use App\Models\User;
use Carbon\Carbon;
use Validator;

class AppointmentController extends Controller
{
    public function list(Request $request)
    {
        $data = Appointment::with('user', 'category', 'schedule', 'participants')->get();
        return response()->json($data, 200);
    }

    public function index(Request $request)
    {
        $appointments = Appointment::all();
        $data = collect();
        foreach ($appointments as $item) {
            $data->push([
                'id' => $item->id,
                'state' => $item->state,
                'name' => '#' . $item->id . ' / ' . ($item->user->name ?? ''),
                'start' => Carbon::parse($item->date . ' ' . $item->schedule->start_time)->format('Y-m-d h:i'),
                'end' => Carbon::parse($item->date . ' ' . $item->schedule->end_time)->format('Y-m-d h:i')
            ]);
        }
        return response()->json($data, 200);
    }

    public function my(Request $request)
    {
        $appointments = Appointment::where('user_id', $request->user()->id)->get();
        $data = collect();
        foreach ($appointments as $item) {
            $data->push([
                'id' => $item->id,
                'state' => $item->state,
                'name' => '#' . $item->id . ' / ' . $item->user->first_name . ' ' . $item->user->last_name,
                'start' => Carbon::parse($item->date . ' ' . $item->schedule->start_time)->format('Y-m-d h:i'),
                'end' => Carbon::parse($item->date . ' ' . $item->schedule->end_time)->format('Y-m-d h:i')
            ]);
        }
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'step' => 'required',
            'category_id' => $request->step == 1 ? 'required|exists:categories,id' : '',
            'date' => $request->step == 1 ? 'required' : '',
            'schedule_id' => $request->step == 2 ? 'required|exists:schedules,id' : '',
            // 'file' => $request->step == 3 ? 'required|max:5120' : '',
            'first_name' => $request->step == 4 ? 'required' : '',
            'last_name' => $request->step == 4 ? 'required' : '',
            'phone' => $request->step == 4 ? 'required' : '',
            'email' => $request->step == 4 ? 'required' : '',
            'detail' => $request->step == 4 ? 'required' : '',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        $appointments = Appointment::where('date', $request->date)->count();

        if ($request->step == 5) {
            $user = User::withTrashed()->where('email', $request->email)->first();
            if (is_null($user)) {
                $user = User::create($request->all());
                $user->save();
            } else {
                if ($user->trashed()) {
                    $user->restore();
                }
                $user->update($request->all());
                $user->save();
            }
            $data = Appointment::create($request->all());
            $data->user_id = $user->id;
            $data->save();
            if ($request->file('file')) {
                $file = $request->file('file');
                $name = time() . Str::random(5) . '.' . $file->getClientOriginalExtension();
                $path = Storage::putFileAs('/', $request->file('file'), $name);
                ImportJob::dispatch($path, $data->id);
            }
            foreach (json_decode($request->appends, true) as $item) {
                $participant = Participant::create($item);
                $participant->appointment_id = $data->id;
                $participant->save();
            }
            try {
                $mail = MailSetting::latest()->first();
                if ($mail) {
                    config([
                        'mail.mailers.smtp' => [
                            'transport' => $mail->MAIL_MAILER,
                            'host' => $mail->MAIL_HOST,
                            'port' => $mail->MAIL_PORT,
                            'encryption' => $mail->MAIL_ENCRYPTION,
                            'username' => $mail->MAIL_USERNAME,
                            'password' => $mail->MAIL_PASSWORD,
                        ]
                    ]);
                    config([
                        'mail.from' => [
                            'address' => $mail->MAIL_FROM_ADDRESS,
                            'name' => $mail->MAIL_FROM_NAME,
                        ]
                    ]);
                    $category = Category::find($request->category_id);
                    \Mail::to($request->email)->send(new AppointmentMail([
                        'state' => 0,
                        'name' => $data->user->name ?? '',
                        'date' => $request->date,
                        'hour' => ($data->schedule->start_time ?? '') . ' - ' . ($data->schedule->end_time ?? ''),
                        'category' => $category->name
                    ], 'Cita'));
                    foreach ($category->users as $user) {
                        if ($user->email != $request->email) {
                            \Mail::to($user->email)->send(new AppointmentMail([
                                'state' => 0,
                                'name' => $user->name ?? '',
                                'email' => $request->email,
                                'date' => $request->date,
                                'hour' => ($data->schedule->start_time ?? '') . ' - ' . ($data->schedule->end_time ?? ''),
                                'category' => $category->name,
                                'other' => true
                            ], 'Cita Agendada'));
                        }
                    }
                }
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => $th->getMessage(),
                    'data' => $data
                ], 201);
            }
            return response()->json([
                'message' => 'Cita generada con éxito.',
                'data' => $data
            ], 201);
        }
        return response()->json(['step' => intval($request->step) + 1], 200);
    }

    public function show(Request $request, $id)
    {
        $data = Appointment::with('user', 'category', 'schedule', 'participants')->find($id);
        if (is_null($data)) {
            return response()->json(['message' => 'No se encontró el registro.'], 404);
        }
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $data = Appointment::find($id);
        if (is_null($data)) {
            return response()->json(['message' => 'No se encontró el registro.'], 404);
        }
        $validator = Validator::make($request->all(), [
            'state' => 'required',
            'reason' => 'required_if:state,==,2',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        $data->update($request->all());
        $data->save();
        try {
            $mail = MailSetting::latest()->first();
            if ($mail) {
                config([
                    'mail.mailers.smtp' => [
                        'transport' => $mail->MAIL_MAILER,
                        'host' => $mail->MAIL_HOST,
                        'port' => $mail->MAIL_PORT,
                        'encryption' => $mail->MAIL_ENCRYPTION,
                        'username' => $mail->MAIL_USERNAME,
                        'password' => $mail->MAIL_PASSWORD,
                    ]
                ]);
                config([
                    'mail.from' => [
                        'address' => $mail->MAIL_FROM_ADDRESS,
                        'name' => $mail->MAIL_FROM_NAME,
                    ]
                ]);
                \Mail::to($data->user->email)->send(new AppointmentMail(['state' => $data->state, 'reason' => $request->reason, 'name' => $data->user->name ?? ''], 'Cita ' . ($data->state == 1 ? 'Aprobada' : 'Rechazada')));
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'data' => $data
            ], 201);
        }
        return response()->json([
            'message' => 'Evento ' . ($request->state == 1 ? 'Aprobado' : 'Rechazado') . ' con éxito.',
            'data' => $data
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $data = Appointment::find($id);
        if (is_null($data)) {
            return response()->json(['message' => 'No se encontró el registro.'], 404);
        }
        $data->delete();
        return response()->json([
            'message' => 'Registro eliminado con éxito.'
        ], 200);
    }

    public function participants(Request $request)
    {
        $import = new CountParticipantImport;
        Excel::import($import, request()->file('file'));
        return response()->json($import->getRowCount(), 200);
    }

    public function participants_destroy(Request $request, $id)
    {
        $data = Participant::find($id);
        if (is_null($data)) {
            return response()->json(['message' => 'No se encontró el registro.'], 404);
        }
        $data->delete();
        return response()->json([
            'message' => 'Participante eliminado con éxito.'
        ], 200);
    }

    public function participants_append(Request $request, $id)
    {
        $appointment = Appointment::find($id);
        if (is_null($appointment)) {
            return response()->json(['message' => 'No se encontró el registro.'], 404);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        if ($request->cui) {
            $participant = Participant::where(['cui' => $request->cui, 'appointment_id' => $appointment->id])->first();
            if ($participant) {
                return response()->json(['message' => 'El participante ingresado ya ha sido registrado.'], 422);
            }
        }
        $data = Participant::create($request->all());
        $data->appointment_id = $appointment->id;
        $data->save();
        return response()->json([
            'message' => 'Participante eliminado con éxito.',
            'data' => $data
        ], 200);
    }

    public function rating(Request $request)
    {
        $request->merge(['comment' => $request->comment ?? "-"]);

        $endpoint = env('BPM_URL', 'https://bpm.movil-max.com/api');

        $response = Http::acceptJson()
            ->retry(3, 100)
            ->withoutVerifying()
            ->post($endpoint . '/ratings/generate', $request->all())
            ->object();

        return $response;
    }
}
