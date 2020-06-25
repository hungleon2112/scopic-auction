<div class="form-group row">
    <label class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" required name="name" placeholder="Name"
               value="{{old('name', $item->name ?? '')}}" />
    </div>
</div>

<div class="form-group row" id="image">
    <label class="col-sm-2 col-form-label">Image {!! isset($item) ? '<code class="highlighter-rouge">(optional)</code>': '' !!}</label>
    <div class="col-sm-10">
        <input {{!isset($product) ? 'required': ''}} class="form-control mb-2" type="file" name="file" id="">
        @if(isset($item->image))
            <img class="img-thumbnail" width="200" src="{{$item->image}}" />
        @endif
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label">Description</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" required name="description" placeholder="Description"
               value="{{old('description', $item->description ?? '')}}" />
    </div>
</div>

