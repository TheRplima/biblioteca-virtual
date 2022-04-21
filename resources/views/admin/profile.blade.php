@extends('layouts.app')
@section('title')
{{ $user->name }}
@endsection
@section('content')
<div>
  <ul class="list-group">
    <li class="list-group-item">
      Joined on {{$user->created_at->format('M d,Y \a\t h:i a') }}
    </li>
    <li class="list-group-item panel-body">
      <table class="table-padding">
        <style>
          .table-padding td{
            padding: 3px 8px;
          }
        </style>
        <tr>
          <td>Total Books</td>
          <td> {{$books_count}}</td>
          @if($author && $books_count)
          <td><a href="{{ url('/my-all-books')}}">Show All</a></td>
          @endif
        </tr>
        <tr>
          <td>Published Books</td>
          <td>{{$books_active_count}}</td>
          @if($books_active_count)
          <td><a href="{{ url('/user/'.$user->id.'/books')}}">Show All</a></td>
          @endif
        </tr>
        <tr>
          <td>Books in Draft </td>
          <td>{{$books_draft_count}}</td>
          @if($author && $books_draft_count)
          <td><a href="{{ url('my-drafts')}}">Show All</a></td>
          @endif
        </tr>
      </table>
    </li>
  </ul>
</div>
<div class="panel panel-default">
  <div class="panel-heading"><h3>Latest Books</h3></div>
  <div class="panel-body">
    @if(!empty($latest_books[0]))
    @foreach($latest_books as $latest_book)
      <p>
        <strong><a href="{{ url('/'.$latest_book->slug) }}">{{ $latest_book->title }}</a></strong>
        <span class="well-sm">On {{ $latest_book->created_at->format('M d,Y \a\t h:i a') }}</span>
      </p>
    @endforeach
    @else
    <p>You have not written any book till now.</p>
    @endif
  </div>
</div>
@endsection
