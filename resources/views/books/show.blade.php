@extends('layouts.app')
@if ($book)
    @section('title')
        {{ $book->title }}
    @endsection
    @section('title-meta')
        <p class="card-text">
            <small class="text-muted">
                By <a href="{{ url('/user/' . $book->author_id) }}">{{ $book->author->name }}</a> at
                {{ $book->created_at->format('d/m/Y') }}
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
                <a class="btn btn-sm btn-danger"
                    href="{{ url('delete/' . $book->id . '?_token=' . csrf_token()) }}">Delete</a>
            </div>
        @endif
    @endsection
    @section('content')
        <article>
            @if ($book->image != '')
                <figure>
                    <img src="/images/books/{{ $book->image }}" alt="{{ $book->title }}" />
                </figure>
            @endif
            {!! $book->body !!}
        </article>
    @endsection
@else
    404 error
@endif
