@extends("layout")

@section("title",  isset($user->name) ? $user->name : $user->first_name . " " . $user->last_name)

@section("description")
{{ $user->email }}
@endsection

@section("keywords")
{{ $user->email }}, details
@endsection



@section("content")
<div class="container">
    <div class="card" style="width: 25%;">
      <div class="card-image">
        <figure class="image is-4by3">
          <img src="{{ $user->avatar }}" alt="Avatar image">
        </figure>
      </div>
      <div class="card-content">
        <div class="media">
          <div class="media-left">
            <figure class="image is-48x48">
              <img src="{{ $user->avatar }}" alt="Avatar image">
            </figure>
          </div>
          <div class="media-content">
            <p class="title is-4">{{ isset($user->name) ? $user->name : $user->first_name . " " . $user->last_name }}</p>
          </div>
        </div>
    
        <div class="content">
          <p class="lead">{{ $user->email }} / {{ isset($user->job) ? $user->job : "-" }}</p>
          <br>
          <div>
              <a href="{{ route("user_edit", ["id" => $user->id]) }}"><i class="fa-solid fa-pen-to-square"></i></a>
              <a href="{{ route("user_delete", ["id" => $user->id]) }}"><i class="fa-solid fa-trash"></i></a>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection

@section("footerjs")

@endsection