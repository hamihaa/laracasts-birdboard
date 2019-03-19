<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
</body>
</html>

@extends('layouts.app')

@section('content')
<h1>Create a project</h1>

<form method="POST" action="{{ route('projects.store') }}">
    @csrf
    <div>
        <input type="text" name="title" id="">
    </div>

    <div>
        <textarea name="description" id="" cols="30" rows="10"></textarea>
    </div>

    <button type="submit">Submit</button>
    <a href="/projects">Go back</a>
</form>
</ul>
@endsection