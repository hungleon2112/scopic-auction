@extends('admin.layouts.Main')
@section('title', __('Create item'))
@section('breadcrumb')
    @include('admin.layouts.DefaultBreadcrumb')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data"  action="{{route('items.store')}}">
                        @csrf
                        @include('admin.ItemsPartial')
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
