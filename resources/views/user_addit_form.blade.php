@extends("layout")

@section("title")
{{ $operation==0 ? "Create": "Edit" }}  User
@endsection

@section("description")
{{ $operation==0 ? "Create": "Edit" }}  a user
@endsection

@section("keywords")
{{ $operation==0 ? "Create": "Edit" }}  user, form
@endsection



@section("content")

    <div class="ftco-blocks-cover-1">
        <div class="ftco-cover-1 overlay innerpage">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 text-center">
                        <h1>{{ $operation==0 ? "Create": "Edit" }} User</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="site-section bg-light" id="contact-section">
        <div class="row">
            <div class="col-lg-10 pr-0">
                <div class="container">
                    <form class="user" action="{{ $operation==0 ? route("user_create") : route("user_update", ["id" => $id]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user"
                                   name="name"
                                   placeholder="Name"
                                   value="{{ $name ? $name : ""}}">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user"
                                   name="job"
                                   placeholder="Job">
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            {{ $operation==0 ? "Create": "Edit" }} User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("footerjs")
@endsection