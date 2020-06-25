<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}">Fibretrace</a></li>
    @if(strpos(\Request::route()->getName(),'index')!==false)
        <li class="breadcrumb-item active">{{str_replace('-',' ', ucfirst(explode('.',\Request::route()->getName())[0]))}}</li>
    @else
        <li class="breadcrumb-item"><a
                href="{{route(explode('.',\Request::route()->getName())[0].'.index')}}">{{str_replace('-',' ', ucfirst(explode('.',\Request::route()->getName())[0]))}}</a>
        </li>
        <li class="breadcrumb-item active">{{ucfirst(explode('.',\Request::route()->getName())[1])}} {{str_replace('-',' ',\Illuminate\Support\Str::singular(explode('.',\Request::route()->getName())[0]))}}</li>
    @endif
</ol>
