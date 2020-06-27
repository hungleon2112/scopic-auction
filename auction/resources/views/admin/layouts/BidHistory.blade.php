<div class="row">
    <div class="col-12">
        <div class="card m-b-20">
            <div class="card-body">
                    <h4>BID Status: {{Constant::BID_STATUS_LABEL[$item->bid->status]}}</h4>
                    <form id="bidForm" method="POST" enctype="multipart/form-data" action="{{route('items.bid-update')}}">
                        @csrf
                        @method('POST')
                        <input type="hidden" value={{$id}} name="item_id" />
                        <input type="hidden" value={{$item->bid->id}} name="id" />
                        <?php
                        $dateTime = strtotime($item->bid->closed_date);
                        ?>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Closed Date</label>
                            <div class="col-sm-10">
                                <input value={{date('Y-m-d', $dateTime)}} type='text' class="form-control datepicker" name="closed_date" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Closed Time (24h format)</label>
                            <div class="col-sm-10">
                                <input value={{date('H:i', $dateTime)}} type='text' class="form-control" name="closed_time" placeholder="15:00"/>
                            </div>
                        </div>
                        @if($item->bid->isUpdatable())
                        <div class="form-group text-right">
                            <a href="javascript:void(0)"
                            onclick="if(confirm('Are you sure you want to update bid for this item?')){document.getElementById('bidForm').submit();}"
                            class="btn btn-danger">Update Bid (new Closed Date Time must greater than current)</a>
                        </div>
                        @endif
                    </form>


                    <h4>BID History</h4>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Bid Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($item->bid->bidDetail as $bid)
                            <tr>
                                <td>
                                {{$bid->user->name}}
                                </td>
                                <td>
                                {{$bid->price}}</td>
                                <td>{{$bid->created_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
</div>