@extends('admin.layouts.Main')
@section('title', __('Edit item'))
@section('breadcrumb')
    @include('admin.layouts.DefaultBreadcrumb')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" action="{{route('items.update', $id)}}">
                        @csrf
                        @method('PUT')
                        @include('admin.ItemsPartial')
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                Submit
                            </button>
                            @includeWhen($item->isDeletable(), 'admin.layouts.DeleteButton')
                            @includeUnless($item->isDeletable(), 'admin.layouts.DisabledDeleteButton', ['text' => sprintf(Constant::TOOLTIP_DISABLED_DELETE_BUTTON, 'bid')])
                        </div>
                    </form>
                    @includeWhen($item->isDeletable(), 'admin.layouts.DeleteForm', ['url' => route('items.destroy', $id)])
                </div>
            </div>
        </div>
    </div>
    @includeWhen($item->canSetBid(), 'admin.layouts.SetBidButton', ['id' => $id])
    @includeWhen(!$item->canSetBid(), 'admin.layouts.BidHistory')
@endsection
