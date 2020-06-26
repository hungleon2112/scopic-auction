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
                            <th>Bid Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $key=> $item)
                            <tr>
                                <td>
                                    @if(!$item->deleted_at)
                                        <a href="{{route('items.edit', $item->id)}}">{{$item->name}}</a>
                                    @else
                                        {{$item->name}}
                                    @endif
                                </td>
                                <td>
                                <img class="img-fluid" style="height: 100px" src="/uploads/{{$item->image}}" /></td>
                                <td>{{$item->desc}}</td>
                                <td>{{$item->bid != null ? Constant::BID_STATUS_LABEL[$item->bid->status] :  null}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
