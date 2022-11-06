@include('admin.parts.header')
@include('admin.parts.navbar')
@include('admin.parts.menu')
<div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
            	@yield('content')
            	
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>


@include('admin.parts.footer')