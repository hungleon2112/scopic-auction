<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>@yield('title') - Scopic - Auction Admin</title>
    <meta content="Admin Dashboard" name="description"/>
    <meta content="Auction" name="author"/>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" href="{{asset('admin/plugins/morris/morris.css')}}">

    <!-- DataTables -->
    <link href="{{asset('admin/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin/css/jquery-ui.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin/css/metismenu.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin/css/icons.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin/plugins/datatables/rowReorder.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}" rel="stylesheet">
    
</head>


<body onload="startTime()">

<!-- Begin page -->
<div id="wrapper">

    <!-- Include TopBar to layout -->
    @includeWhen(\Request::route()->getName()!='getLogin','admin.layouts.TopBar')
    <!-- Include SideBar to layout -->
    @includeWhen(\Request::route()->getName()!='getLogin','admin.layouts.SideBar')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    @if(\Request::route()->getName()!='getLogin')
        <div class="content-page">
            <!-- Start content -->
            <div class="content">

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title-box">
                                @include('admin.layouts.Alert')
                                <h4 class="page-title">@yield('title')</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                    @yield('content')

                </div> <!-- container-fluid -->

            </div> <!-- content -->

            <!-- Include Footer to layout -->
            @include('admin.layouts.Footer')

        </div>
    @else
        @yield('content')
        <div class="text-center">
            <p>© {{date('Y')}} Scopic - Auction</p>
        </div>
    @endif
    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->

</div>
<!-- END wrapper -->
<!-- jQuery  -->
<script src="{{asset('admin/js/jquery.min.js')}}"></script>
<script src="{{asset('admin/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('admin/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('admin/js/metisMenu.min.js')}}"></script>
<script src="{{asset('admin/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('admin/js/waves.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
<!-- Required datatable js -->
<script src="{{asset('admin/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/plugins/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables/rowReorder.min.js')}}"></script>
<script src="{{asset('admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<script src="{{asset('admin/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>

<!--Morris Chart-->
{{--<script src="{{asset('admin/plugins/morris/morris.min.js')}}"></script>--}}
{{--<script src="{{asset('admin/plugins/raphael/raphael-min.js')}}"></script>--}}
{{--<script src="{{asset('admin/pages/dashboard.js')}}"></script>--}}

<!-- App js -->
<script src="{{asset('admin/js/app.js')}}"></script>
<!-- Datatable init js -->
<script src="{{asset('admin/pages/datatables.init.js')}}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@stack('scripts')
</body>
</html>
