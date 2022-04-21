<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Book;

use App\Http\Requests\BookFormRequest;

class BookController extends Controller
{
    public function index()
    {
        //fetch 5 books from database which are active and latest
        $books = Book::where('active', 1)->orderBy('created_at', 'desc')->paginate(5);
        //page heading
        $title = 'Latest Book';
        //return home.blade.php template from resources/views folder
        return view('home')->with('books', $books)->with('title', $title);
    }

    public function create(Request $request)
    {
        //
        if ($request->user()->can_post()) {
            return view('books.create');
        } else {
            return redirect('/')->withErrors('You have not sufficient permissions for writing book');
        }
    }

    public function store(BookFormRequest $request)
    {
        $book = new Book();
        $book->title = $request->get('title');
        $book->body = $request->get('body');
        $book->slug = Str::slug($book->title);

        $duplicate = Book::where('slug', $book->slug)->first();
        if ($duplicate) {
            return redirect('new-book')->withErrors('Title already exists.')->withInput();
        }

        $book->author_id = $request->user()->id;

        // Image Upload
        if ($request->hasFile('image') && $request->file('image')->isValid()){
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName().strtotime("now")).'.'.$extension;
            $requestImage->move(public_path('images/books'), $imageName);
            $book->image = $imageName;
        }

        if ($request->has('save')) {
            $book->active = 0;
            $message = 'Book saved successfully';
        } else {
            $book->active = 1;
            $message = 'Book published successfully';
        }
        $book->save();
        return redirect('edit/' . $book->slug)->withMessage($message);
    }

    public function show($slug)
    {
        $book = Book::where('slug', $slug)->first();
        if (!$book) {
            return redirect('/')->withErrors('requested page not found');
        }
        //   $comments = $book->comments;
        return view('books.show')->with('book', $book);
    }

    public function edit(Request $request, $slug)
    {
        $book = Book::where('slug', $slug)->first();
        if ($book && ($request->user()->id == $book->author_id || $request->user()->is_admin()))
            return view('books.edit')->with('book', $book);
        return redirect('/')->withErrors('you have not sufficient permissions');
    }

    public function update(Request $request)
    {
      //
      $book_id = $request->input('book_id');
      $book = Book::find($book_id);
      if ($book && ($book->author_id == $request->user()->id || $request->user()->is_admin())) {
        $title = $request->input('title');
        $slug = Str::slug($title);
        $duplicate = Book::where('slug', $slug)->first();
        if ($duplicate) {
          if ($duplicate->id != $book_id) {
            return redirect('edit/' . $book->slug)->withErrors('Title already exists.')->withInput();
          } else {
            $book->slug = $slug;
          }
        }

        $book->title = $title;
        $book->body = $request->input('body');

        if ($request->has('save')) {
          $book->active = 0;
          $message = 'Book saved successfully';
          $landing = 'edit/' . $book->slug;
        } else {
          $book->active = 1;
          $message = 'Book updated successfully';
          $landing = $book->slug;
        }
        $book->save();
        return redirect($landing)->withMessage($message);
      } else {
        return redirect('/')->withErrors('you have not sufficient permissions');
      }
    }

    public function destroy(Request $request, $id)
    {
      //
      $book = Book::find($id);
      if($book && ($book->author_id == $request->user()->id || $request->user()->is_admin()))
      {
        $book->delete();
        $data['message'] = 'Book deleted Successfully';
      }
      else
      {
        $data['errors'] = 'Invalid Operation. You have not sufficient permissions';
      }
      return redirect('/')->with($data);
    }
}
