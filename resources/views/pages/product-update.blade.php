@extends('templates.index')

@section('styles')
    <style>
        .example-modal .modal {
        position: relative;
        top: auto;
        bottom: auto;
        right: auto;
        left: auto;
        display: block;
        z-index: 1;
        }

        .example-modal .modal {
        background: transparent !important;
        }
    </style>
@endsection

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
                <th>Harga/Satuan</th>
                <th>Stok</th>
                <th>Kategori</th>
                <th>Edit</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                <tr>
                    <td>{{$item->name}}</td>
                    <td>Rp {{$item->price}}/{{$item->unit}}</td>
                    <td>{{$item->stock}} {{$item->unit}}</td>
                    <td>{{$item->category}}</td>
                    <td><button class="btn btn-block btn-primary btn-flat" type="button" data-target="#item{{$item->id}}" data-toggle="modal">Edit</button></td>
                    <div class="modal fade" id="item{{$item->id}}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <h4>Edit Produk {{$item->name}}</h4>
                                    </div>
                                    <div class="box-body">
                                        <form action="{{route('product.update')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$item->id}}">
                                            <div class="form-group">
                                                <label>Nama</label>
                                                <input type="text" class="form-control" value="{{$item->name}}" name="name">
                                            </div>
                                            <div class="form-group">
                                                <label>Harga(Rupiah)</label>
                                                <input type="text" class="form-control" value="{{$item->price}}" name="price">
                                            </div>
                                            <div class="form-group">
                                                <label>Kategori</label>
                                                <select class="form-control" name="category">
                                                    <option @if($item->category == "buah") selected @endif value="buah">Buah-Buahan</option>
                                                    <option @if($item->category == "sayuran") selected @endif value="sayuran">Sayuran</option>
                                                    <option @if($item->category == "menu") selected @endif value="menu">Menu Sehat</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Stok</label>
                                                <input type="text" class="form-control" value="{{$item->stock}}" name="stock">
                                            </div>
                                            <div class="form-group">
                                                <label>Satuan</label>
                                                <select class="form-control" name="unit">
                                                    <option @if($item->unit == "kg") selected @endif value="kg">Kg</option>
                                                    <option @if($item->unit == "liter") selected @endif value="liter">Liter</option>
                                                    <option @if($item->unit == "gram") selected @endif value="gram">Gram</option>
                                                    <option @if($item->unit == "ikat") selected @endif value="ikat">Ikat</option>
                                                    <option @if($item->unit == "buah") selected @endif value="buah">Buah</option>
                                                    <option @if($item->unit == "siung") selected @endif value="siung">Siung</option>
                                                    <option @if($item->unit == "pcs") selected @endif value="pcs">Pcs</option>
                                                    <option @if($item->unit == "box") selected @endif value="box">Box</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Deskripsi</label>
                                                <textarea class="form-control" rows="3" name="description">{{$item->description}}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Nutrisi</label>
                                                <input type="text" class="form-control" value="{{$item->nutrition}}" name="nutrition">
                                            </div>
                                            @if ($item->img != NULL)
                                            <div class="form-group">
                                                <label>Gambar Produk</label>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <img src="{{ asset('storage/'.$item->img) }}" height="150">
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="form-group">
                                                <label>@if ($item->img == NULL) Tambahkan @else Ubah @endif Gambar Produk</label>
                                                <input type="file" id="exampleInputFile" name="img" accept="image/*">
                                            </div>
                                    </div>
                                    <div class="modal-footer box-footer">
                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>    
                                        </form>
                                    </div>
                                </div>
                                {{-- <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Edit Produk ({{$item->name}})</h4>
                                </div>
                                <div class="modal-body">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div> --}}
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th>Nama</th>
                <th>Harga/Satuan</th>
                <th>Stok</th>
                <th>Kategori</th>
                <th>Edit</th>
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