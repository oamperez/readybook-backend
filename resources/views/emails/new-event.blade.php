@extends('emails.layout')
@section('content')
    @if($data['other'] ?? false)
    <p>Hola {{ $data['name'] }}, se reservo un nuevo evento: <br>
    fecha: {{ $data['date'] }} <br>
    hora: {{ $data['hour'] }} <br>
    usuario: {{ $data['email'] }} <br>
    categoria: {{ $data['category'] }}
    </p>
    @else
    <p>Hola {{ $data['name'] }}, tu cita ha sido creada con éxito, estaremos notificando el proceso.</p>
    @endif
@stop
