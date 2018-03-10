@extends('layouts.app')

@section('content');

<h1>Filmovi</h1>
<br>
<div class="jumbotron text-center">
    <?php
    
    foreach(range ('A','Z') as $char){
    
    $b=action('MoviesController@show',['first' =>$char]);
    echo "<a href=  $b >| $char   </a>";
    }
    $c= url()->current();
    $c= substr($c,-1);
    $movies = \Illuminate\Support\Facades\DB::table('films')->where('naslov','LIKE',$c.'%')->get();
    
    ?>
    </div>

@if(count($movies)>0)
    @foreach($movies as $movie)
    <div class="jumbotron text-center">
      
                        <img style = 'width:15%' src=/storage/cover_images/{{$movie->cover_image}}>
                        <p>{{$movie->naslov}} ({{$movie->godina}})</p>
                        <p>Trajanje: {{$movie->trajanje}}</p>
                      </div> 
      
    @endforeach
@else
    <p>Ne postoji film pod tim slovom</p>
@endif

@endsection