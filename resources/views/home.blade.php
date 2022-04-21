@extends('layouts.app')
@section('title')
    {{ $title }}
@endsection
@section('content')
    @if (!$books->count())
        There is no book till now. Login and write a new book now!!!
    @else
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach ($books as $book)
                <div class="col">
                    <div class="card h-100">
                        @if ($book->image != '')
                            <img class="card-img-top" src="/images/books/{{ $book->image }}"
                                alt="{{ $book->title }}" />
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">
                                <a class="subtitle" href="{{ url('/' . $book->slug) }}">{{ $book->title }}</a>
                            </h5>
                            <p class="card-text">
                                {!! Str::limit($book->body, $limit = 200, $end = '....... <a href=' . url('/' . $book->slug) . '>Read More</a>') !!}
                            </p>
                        </div>
                        <div class="card-footer">
                            <p class="card-text">
                                <small class="text-muted">
                                    By <a href="{{ url('/user/' . $book->author_id) }}">{{ $book->author->name }}</a> at {{ $book->created_at->format('d/m/Y') }}
                                </small>
                            </p>
                            @if (!Auth::guest() && ($book->author_id == Auth::user()->id || Auth::user()->is_admin()))
                                <div class="text-center">
                                    @if ($book->active == '1')
                                        <a class="btn btn-sm btn-primary" href="{{ url('edit/' . $book->slug) }}">Edit
                                            Book</a>
                                    @else
                                        <a class="btn btn-sm btn-primary" href="{{ url('edit/' . $book->slug) }}">Edit
                                            Draft</a>
                                    @endif
                                    <a class="btn btn-sm btn-danger" href="{{ url('delete/' . $book->id . '?_token=' . csrf_token()) }}">Delete</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
