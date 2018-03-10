@extends('layouts.app')

@section('content');

<h1>Unos filmo</h1>

{!! Form::open(['action' => 'MoviesController@store', 'method' => 'POST','enctype' => 'multipart/form-data']) !!}
    <div class = 'form-group'>
        {{Form::label('naslov','Naslov:')}}
        {{Form::text('naslov', '', ['class' => 'form-control', 'placeholder' => 'Naslov'])}}
    </div>
    <div class = 'form-group'>
        {{Form::label('zanr_id','Zanr:')}}
        {{Form::select('zanr_id', $zanr)}}
    </div>
    <div class = 'form-group'>
        {{Form::label('godina','Godina:')}}
        {{Form::selectRange('godina', 2018, 1900, ['class' => 'form-control', 'placeholder' => 'Godina'])}}
    </div>
    <div class = 'form-group'>
        {{Form::label('trajanje','Trajanje:')}}
        {{Form::text('trajanje', '', ['class' => 'form-control', 'placeholder' => 'Trajanje'])}}
    </div>
    <div class = 'form-group'>
        {{Form::label('Slika filma:')}}
        {{Form::file('cover_image')}}
    </div>
    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
{!! Form::close() !!}



<?php

$movies= \Illuminate\Support\Facades\DB::table('films')->get();

?>
<br>
<br>
@if(count($movies)>0)
    @foreach($movies as $movie)
    <div class="card card-body bg-light">
            <table class="table table-bordered">
                    <thead class="align-middle" align="center">
                      <tr>
                        <th>Slika</th>
                        <th>Naslov</th>
                        <th>Godina</th>
                        <th>Trajanje</th>
                        <th>Akcija</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td align="center"><img style = 'width:50%' src=/storage/cover_images/{{$movie->cover_image}}></td>
                        <td class="align-middle" align="center"><h3>{{$movie->naslov}}</a></h3></td>
                        <td class="align-middle" align="center"><h3>{{$movie->godina}}</h3></td>
                        <td class="align-middle" align="center"><h3>{{$movie->trajanje}}</h3></td>
                        <td class="align-middle" align="center">
                        {!!Form::open(['action'=> ['MoviesController@destroy', $movie->id], 'method' => 'Post'])!!}
                          {{Form::hidden('_method', 'DELETE')}}
                          {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                        {!!Form::close()!!}
                        </td>
                      </tr>
                    </tbody>
                  </table>      
            
       </div>
    @endforeach
@else
    <p>Nema filmova u kolekciji</p>
@endif


@endsection