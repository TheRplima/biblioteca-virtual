@extends('layouts.app')
@section('title')
{{$title}}
@endsection
@section('content')
@if ( !$books->count() )
There is no book till now. Login and write a new book now!!!
@else
<div class="">
  @foreach( $books as $book )
  <div class="list-group">
    <div class="list-group-item">
      <h3><a href="{{ url('/'.$book->slug) }}">{{ $book->title }}</a>
        @if(!Auth::guest() && ($book->author_id == Auth::user()->id || Auth::user()->is_admin()))
          @if($book->active == '1')
          <button class="btn" style="float: right"><a href="{{ url('edit/'.$book->slug)}}">Edit Book</a></button>
          @else
          <button class="btn" style="float: right"><a href="{{ url('edit/'.$book->slug)}}">Edit Draft</a></button>
          @endif
        @endif
      </h3>
      <p>{{ $book->created_at->format('M d,Y \a\t h:i a') }} By <a href="{{ url('/user/'.$book->author_id)}}">{{ $book->author->name }}</a></p>
    </div>
    <div class="list-group-item">
      <article>
        {!! Str::limit($book->body, $limit = 1500, $end = '....... <a href='.url("/".$book->slug).'>Read More</a>') !!}
      </article>
    </div>
  </div>
  @endforeach
  {!! $books->render() !!}
</div>
@endif
@endsection
