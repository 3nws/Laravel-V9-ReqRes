@extends('layout')

@section('title', 'Users List')

@section('description')
Users list
@endsection

@section('keywords')
list, users
@endsection



@section('content')

    
    <div class="ftco-blocks-cover-1">
        <div class="ftco-cover-1 overlay innerpage" style="background-image: url('{{ asset('assets') }}/images/hero_1.jpg')">
            <div class="container">
                <div class="row">
                    <div class="col-md-6" style="display: inline-block;">
                        <h1>Users</h1>
                    </div>
                    <div class="col-md-6" style="display: inline-block;">
                        <a href="{{ route("user_add") }}" class="button">Add a User</a>
                    </div>
                </div>
                @include('_message')
            </div>
        </div>
    </div>

    <div class="site-section bg-light">
        <div class="container">
            <div class="row">
                @foreach($userslist as $rs)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="item-1">
                        <div class="item-1-contents">
                            <div class="text-center">
                                <h3><a href="{{ route('user_detail', ['id' => $rs->id]) }}">{{ isset($rs->name) ? $rs->name : $rs->first_name . " " . $rs->last_name }}</a></h3>
                                <div class="rating">
                                    <span class="icon-star text-warning"></span>
                                    <span class="icon-star text-warning"></span>
                                    <span class="icon-star text-warning"></span>
                                    <span class="icon-star text-warning"></span>
                                    <span class="icon-star text-warning"></span>
                                </div>
                            </div>
                            <ul class="specs">
                                <li>
                                    <span class="spec">{{ $rs->email }}</span>
                                </li>
                            </ul>
                            <div class="d-flex action">
                                <a href="{{ route('user_delete', ['id' => $rs->id]) }}">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection