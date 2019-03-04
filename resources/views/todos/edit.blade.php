@extends('master')

@section('master')
  
{!! Form::model($todo, ['route' => ['todos.update', $todo->id], 'method' => 'PUT', 'class' => 'form']) !!}
  {!! Form::text('title', $todo->title, ['class' => 'form-control']); !!}
  {!! Form::submit('Update', ['class' => 'btn btn-primary ml-auto mt-3']); !!}
{!! Form::close() !!}

{!! Form::open(['route' => ['todos.delete', $todo->id], 'method' => 'delete', 'class' => 'form']) !!}
    {!! Form::submit('Delete', ['class' => 'btn btn-danger mt-3']); !!}
  {!! Form::close() !!}	

@endsection