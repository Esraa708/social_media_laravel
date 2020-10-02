@extends('layouts.app')

@section('content')


<home :user='@json($user)'></home>
@endsection