@extends('layouts.app')
@section('title')
    Edit Boook
@endsection
@section('content')
    <script type="text/javascript" src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: "textarea",
            height: 500,
            menubar: false,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
        });
    </script>
    <form method="post" action='{{ url('/update') }}' enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="book_id" value="{{ $book->id }}{{ old('book_id') }}">
        <div class="form-group">
            <label for="title" class="form-label">Title</label>
            <input required="required" placeholder="Enter title here" type="text" id="title" name="title" class="form-control"
                value="@if (!old('title')) {{ $book->title }} @endif{{ old('title') }}" />
        </div>
        <div class="form-group mt-2">
            <label for="image" class="form-label">Book cover</label>
            <input type="file" name="image" id="image" value="{{ old('title') }}" class="form-control" />
            @if (!old('image'))
            <img src="/images/books/{{ $book->image }}" alt="{{ $book->title }}" class="img-thumbnail rounded" style="width:150px;" />
            @endif
        </div>
        <div class="form-group mt-2">
            <label for="body" class="form-label">Body</label>
            <textarea id="body" name='body' class="form-control">
                @if (!old('body'))
                    {!! $book->body !!}
                @endif
                {!! old('body') !!}
            </textarea>
        </div>
        <div class="form-group mt-2">
            @if ($book->active == '1')
                <input type="submit" name='publish' class="btn btn-success" value="Update" />
            @else
                <input type="submit" name='publish' class="btn btn-success" value="Publish" />
            @endif
            <input type="submit" name='save' class="btn btn-secondary" value="Save As Draft" />
            <a href="{{ url('delete/' . $book->id . '?_token=' . csrf_token()) }}" class="btn btn-danger">Delete</a>
        </div>
    </form>
@endsection
