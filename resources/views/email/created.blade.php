@extends('layouts.email')
@section('content')
    <table class="table">
        @foreach($data as $key => $value)
            <td> {{$key}} </td>
            <td> {{$value}} </td>
        @endforeach
    </table>
@endsection