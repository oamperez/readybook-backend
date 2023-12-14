@extends('emails.layout')
@section('content')
    <p>Hola {{ $data['name'] }}, tu cita ha sido rechazada con razón: {{ $data['reason'] }}</p>
@stop
