<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Book;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /*
   * Display active books of a particular user
   *
   * @param int $id
   * @return view
   */
    public function user_books($id)
    {
        //
        $books = Book::where('author_id', $id)->where('active', 1)->orderBy('created_at', 'desc')->paginate(5);
        $title = User::find($id)->name;
        return view('home')->with('books', $books)->with('title', $title);
    }

    /*
   * Display all of the books of a particular user
   *
   * @param Request $request
   * @return view
   */
    public function user_books_all(Request $request)
    {
        //
        $user = $request->user();
        $books = Book::where('author_id', $user->id)->orderBy('created_at', 'desc')->paginate(5);
        $title = $user->name;
        return view('home')->with('books', $books)->with('title', $title);
    }

    /*
   * Display draft books of a currently active user
   *
   * @param Request $request
   * @return view
   */
    public function user_books_draft(Request $request)
    {
        //
        $user = $request->user();
        $books = Book::where('author_id', $user->id)->where('active', 0)->orderBy('created_at', 'desc')->paginate(5);
        $title = $user->name;
        return view('home')->with('books', $books)->with('title', $title);
    }

    /**
     * profile for user
     */
    public function profile(Request $request, $id)
    {
        $data['user'] = User::find($id);
        if (!$data['user'])
            return redirect('/');
        if ($request->user() && $data['user']->id == $request->user()->id) {
            $data['author'] = true;
        } else {
            $data['author'] = null;
        }
        // $data['comments_count'] = $data['user'] -> comments -> count();
        $data['books_count'] = $data['user']->books->count();
        $data['books_active_count'] = $data['user']->books->where('active', '1')->count();
        $data['books_draft_count'] = $data['books_count'] - $data['books_active_count'];
        $data['latest_books'] = $data['user']->books->where('active', '1')->take(5);
        // $data['latest_comments'] = $data['user'] -> comments -> take(5);
        return view('admin.profile', $data);
    }
}
