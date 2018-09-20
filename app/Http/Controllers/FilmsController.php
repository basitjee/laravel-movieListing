<?php

namespace App\Http\Controllers;

use App\Film;
use App\Comment;
use Illuminate\Http\Request;
use GuzzleHttp;
use Route;

class FilmsController extends Controller
{
    //
    public function getAllFilms() {
        $films = Film::all();

        return $films;
    }

    public function showAllFilms() {
//        $request = Request::create('/api/all-films', 'GET');
//
//        $response = Route::dispatch($request);

        $films = Film::paginate(1);

        return view('films.viewall', ['films' => $films]);

    }

    public function showFilm($slug) {

        $film = Film::where('slug' , $slug)->first();
        $comments = Comment::where('film_id', $film->id)->get();

//        var_dump($film);

        return view('films.viewfilm', ['film' => $film, 'comments' => $comments]);


    }

    public function getComments($film_id) {
        return Comment::where('film_id', $film_id)->get();
    }
    public function newFilm(Request $request) {
/*        $this->validate($request, [
            'film_cover' => 'required|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);*/
/*        $file = $request->file('image');
        $getimageName = time().'.'.$request->image->getClientOriginalExtension();
        $file->move(public_path('images'), '123.jpg');*/
//        var_dump($request->file('film_image'));

        if(Film::insert([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'release_date' => $request->input('release_date'),
            'rating' => $request->input('rating'),
            'ticket_price' => $request->input('ticket_price'),
            'country' => $request->input('country'),
            'genre' => $request->input('genre'),
            'slug' => $request->input('slug'),
            'photo' => 'image.jpg'
        ]));
        return redirect('films')->with('film_success', 'New film added successfully');

    }
    public function newComment(Request $request) {
        if(Comment::insert([
            'name' => $request->input('name'),
            'film_id' => $request->input('film_id'),
            'comment' => $request->input('comment')
        ]));
        return back()->with('comment_success', 'New comment added successfully');

    }
}