@extends('admin.layouts.Main')
@section('title', __('Items'))
@section('breadcrumb')
    @include('admin.layouts.DefaultBreadcrumb')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="btn-toolbar mb-4 justify-content-end">
                        <a href="{{route('items.create')}}"><button class="btn btn-primary">Create item</button></a>
                    </div>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Description</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>
                                    @if(!$item->deleted_at)
                                        <a href="{{route('items.edit', $item->id)}}">{{$item->name}}</a>
                                    @else
                                        {{$item->name}}
                                    @endif
                                </td>
                                <td>{{$product->image}}</td>
                                <td>{{$product->description}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
