<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Film;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class MoviesController extends Controller
{  



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Film::orderby('naslov','asc')->get();
        return view('movies.index')->with('movies',$movies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $zanr = DB::table('zanr')->pluck('zanr');

        return view('movies.create',compact('zanr'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'naslov' => 'required',
            'zanr_id' => 'required',
            'godina' => 'required',
            'trajanje' => 'required',
            'cover_image'=>'image|nullable|max:1999'
        ]);

        //Handle file upload
        if($request->hasFile('cover_image')){
            //get filename with ext
            $filenameWithExt=$request->file('cover_image')->getClientOriginalName();
            // get just filename
            $filename= pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            //Upload to image
            $path = $request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);
        }else{
            $fileNameToStore = 'noimage.jpg';
        }

        //cREATE movies
        $movie = new Film;
        $movie->naslov = $request->input('naslov');
        $movie->zanr_id = $request->input('zanr_id')+1;
        $movie->godina = $request->input('godina');
        $movie->trajanje = $request->input('trajanje');
        $movie->cover_image = $fileNameToStore;
        $movie->save();

        return redirect('/movies/create')->with('success','Film unesen');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$movie = Film::find($id);
        //return view('movies.index')->with('movie',$movie);
        $a = DB::table('films')->where('naslov','LIKE',$id.'%');
        return view ('movies.index',compact('a'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movies = Film::find($id);
        $movies->delete();
        return redirect('/movies/create')->with('success','Film Izbrisan');
    }
}
