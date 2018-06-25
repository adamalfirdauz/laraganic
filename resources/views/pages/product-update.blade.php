@extends('templates.index')

@section('header')
        <h1>
            {{$head->title}}
            <small>{{$head->subtitle}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> {{$head->title}}</a></li>
            <li class="active">{{$head->subtitle}}</li>
        </ol>
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Daftar Produk</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Nama</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < 35; $i++)
                <tr>
                    <td>Apel</td>
                    <td>Rp 25.000/kg</td>
                    <td>Buah-buahan</td>
                    <td>1000 kg</td>
                    <td><button class="btn btn-block btn-primary btn-flat" type="submit">Edit</button></td>
                </tr>
                @endfor
            </tbody>
            <tfoot>
            <tr>
                <th>Nama</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
            </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
@endsection

@section('script')
    <!-- DataTables -->
    <script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <!-- page script -->
    <script>
        $(function () {
            $('#example1').DataTable()
            $('#example2').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false
            })
        })
    </script>
@endsection