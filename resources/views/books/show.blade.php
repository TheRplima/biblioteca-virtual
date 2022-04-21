@extends('layouts.app')
@if ($book)
    @section('title')
        {{ $book->title }}
    @endsection
    @section('title-meta')
        {{ $book->created_at->format('M d,Y \a\t h:i a') }} By <a
            href="{{ url('/user/' . $book->author_id) }}">{{ $book->author->name }}</a>
        @if (!Auth::guest() && ($book->author_id == Auth::user()->id || Auth::user()->is_admin()))
            <a class="btn btn-sm btn-primary" href="{{ url('edit/' . $book->slug) }}">Edit Book</a>
        @endif
    @endsection
    @section('content')
        <article>
            @if ($book->image != '')
            <figure>
                <img src="/images/books/{{$book->image}}" alt="{{ $book->title }}" />
            </figure>
            @endif
            {!! $book->body !!}
        </article>
    @endsection
@else
    404 error
@endif
