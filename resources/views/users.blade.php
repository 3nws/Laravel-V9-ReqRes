@extends("layout")

@section("title", "Users List")

@section("description")
Users list
@endsection

@section("keywords")
list, users
@endsection



@section("content")

    
    <div class="ftco-blocks-cover-1">
        <div class="ftco-cover-1 overlay innerpage">
            <div class="container">
                <div class="row">
                    <div class="col-md-6" style="display: inline-block;">
                        <h1>Users</h1>
                    </div>
                    <div class="col-md-6" style="display: inline-block;">
                        <a href="{{ route("user_add") }}" class="button">Add a User</a>
                    </div>
                </div>
                @include("_message")
            </div>
        </div>
    </div>

    <div class="site-section bg-light">
        <div class="container" style="display: flex; flex-wrap: wrap;">
                @php
                $cnt = 1 + 10 * ($cur_page_number-1);
                @endphp
                @foreach($userslist as $user)

                <div class="card" style="flex: 1; margin: 2em; max-width:25%;">
                    <div class="card-image">
                      <figure class="image is-4by3">
                        <a href="{{ route('user_detail', ['id' => $user->id]) }}">
                          <img src="{{ $user->avatar }}" alt="Avatar image">
                        </a>
                      </figure>
                    </div>
                    <div class="card-content">
                      <div class="media">
                        <div class="media-left">
                          <figure class="image is-48x48">
                            <a href="{{ route('user_detail', ['id' => $user->id]) }}">
                              <img src="{{ $user->avatar }}" alt="Avatar image">
                            </a>
                          </figure>
                        </div>
                        <div class="media-content">
                        <span>{{ $cnt++ }}.</span>
                          <p class="title is-4"><a href="{{ route('user_detail', ['id' => $user->id]) }}">{{ isset($user->name) ? $user->name : $user->first_name . " " . $user->last_name }}</a></p>
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
                @endforeach
        </div>
        <div class="container">
            @include("_pagination")
        </div>
    </div>
@endsection