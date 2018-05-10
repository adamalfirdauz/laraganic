<!DOCTYPE html>
<html>
@include('templates.part.head')
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  @include('templates.part.header')
  @include('templates.part.sidebar')  
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      @yield('header')
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      @yield('content')
    </section>
    <!-- /.content -->
  </div>
  @include('templates.part.footer')
</div>
@include('templates.part.script')
</body>
</html>
