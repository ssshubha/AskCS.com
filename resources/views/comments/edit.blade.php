@extends('layouts.app')
@section('title')
Edit Comment
@endsection
@section('content')

<form method="post" action='{{ url("/commentupdate") }}'>
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="comment_id" value="{{ $comment->id }}{{ old('comment_id') }}">
  
  <div class="form-group">
    <textarea name='body'class="form-control">
      @if(!old('body'))
      {!! $comment->body !!}
      @endif
      {!! old('body') !!}
    </textarea>
  </div>
  
  <input type="submit" name='publish' class="btn btn-success" value = "Update"/>
  
  <a href="{{  url('commentdelete/'.$comment->id.'?_token='.csrf_token()) }}" class="btn btn-danger">Delete</a>
</form>
@endsection