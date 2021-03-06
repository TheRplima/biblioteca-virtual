@extends('layouts.app')

@section('title')
    Add New Book
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
    <form action="/new-book" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title" class="form-label">Title</label>
            <input required="required" placeholder="Enter title here" type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" />
        </div>
        <div class="form-group mt-2">
            <label for="image" class="form-label">Book cover</label>
            <input value="{{ old('title') }}" type="file" name="image" id="image" class="form-control" />
        </div>
        <div class="form-group mt-2">
            <label for="body" class="form-label">Body</label>
            <textarea name='body' id="body" class="form-control">{{ old('body') }}</textarea>
        </div>
        <div class="form-group mt-2">
            <input type="submit" name='publish' class="btn btn-success" value="Publish" />
            <input type="submit" name='save' class="btn btn-default" value="Save Draft" />
        </div>
    </form>
@endsection
