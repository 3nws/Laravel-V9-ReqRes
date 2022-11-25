@extends('layout')

@section('title',  isset($user->name) ? $user->name : $user->first_name . " " . $user->last_name)

@section('description')
{{ $user->email }}
@endsection

@section('keywords')
{{ $user->email }}, details
@endsection



@section('content')

    <div class="ftco-blocks-cover-1">
        <div class="ftco-cover-1 overlay innerpage">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 text-center">
                        <h1>{{ isset($user->name) ? $user->name : $user->first_name . " " . $user->last_name }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="site-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8 blog-content">
                    <p class="lead">{{ $user->email }}</p>
                </div>
                <div class="col-md-4 sidebar">
                    <div class="sidebar-box">
                        <div>
                            <a href="{{ route('user_edit', ['id' => $user->id]) }}">Edit</a>
                            <a href="{{ route('user_delete', ['id' => $user->id]) }}">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footerjs')

@endsection