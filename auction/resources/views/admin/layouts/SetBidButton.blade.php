<div class="row">
    <div class="col-12">
        <div class="card m-b-20">
            <div class="card-body">
                <h3>Auction this Item</h3>
                <form id="bidForm" method="POST" enctype="multipart/form-data" action="{{route('items.bid')}}">
                    @csrf
                    @method('POST')
                    <input type="hidden" value={{$id}} name="item_id" />
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Closed Date</label>
                        <div class="col-sm-10">
                            <input type='text' class="form-control datepicker" name="closed_date" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Closed Time (24h format)</label>
                        <div class="col-sm-10">
                            <input type='text' class="form-control" name="closed_time" placeholder="15:00"/>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <a href="javascript:void(0)"
                        onclick="if(confirm('Are you sure you want to auction this item?')){document.getElementById('bidForm').submit();}"
                        class="btn btn-danger">Auction</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>