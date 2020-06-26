@extends('admin.layouts.Main')
@section('title', __('Login'))
@section('content')
    <div class="wrapper-page">
        <div class="card">
            <div class="card-body">
                <div id="systemTime" style="text-align: center; font-weight: bolder; margin-bottom: 15px"></div>
                

                <div class="p-3" style="margin-top: -30px">
                    <h4 class="text-muted font-18 m-b-5 text-center">Welcome Back !</h4>
                    <p class="text-muted text-center">Sign in to continue to Scopic Auction.</p>

                    @include('admin.layouts.Alert')

                    <form class="form-horizontal m-t-30" method="POST" action="{{route('login')}}">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required placeholder="Enter username">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required placeholder="Enter password">
                    </div>

                    <div class="form-group row m-t-20">
                        <div class="col-12 text-center">
                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
