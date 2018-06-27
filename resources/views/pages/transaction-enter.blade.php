@extends('templates.index')

@section('styles')
    {{-- <style>
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
    </style> --}}
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
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><b>Masuk</b></a></li>
            <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><b>Dikirim</b></a></li>
            <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false"><b>Selesai</b></a></li>
            <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false"><b>Arsip</b></a></li>
            {{-- <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                    Dropdown <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
                    <li role="presentation" class="divider"></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
                </ul>
            </li> --}}
            {{-- <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li> --}}
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <table id="tableMasuk" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama Pembeli</th>
                            <th>Kode Transaksi</th>
                            <th>Daftar Item</th>
                            {{-- <th>Harga</th> --}}
                            {{-- <th>Kuantitas</th> --}}
                            <th>Total</th>
                            <th>Status</th>
                            {{-- <th>Kategori</th>
                            <th>Stok</th> --}}
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                        @if($transaction->status >= 1 && $transaction->status <= 3)
                        <tr>
                            <td>{{App\User::where('id', '=', $transaction->user_id)->first()->name}}</td>
                            <td>{{$transaction->code}}</td>
                            <td>@foreach ($transaction->product as $product)
                                <h1  class="label @if ($product->category == "buah")
                                    bg-red
                                @elseif ($product->category == "sayuran")
                                    bg-green
                                @elseif ($product->category == "menu")
                                    bg-yellow
                                @else
                                    bg-maroon
                                @endif">{{$product->name}}</h1>
                            @endforeach</td>
                            {{-- <td>{{$transaction->price}}</td> --}}
                            {{-- <td>{{$transaction->qty}}</td> --}}
                            <td>Rp {{$transaction->total}}</td>
                            <td>
                                @if ($transaction->status==1) 
                                    Menunggu Pembayaran
                                @elseif ($transaction->status==2) 
                                    Periksa Bukti Bayar 
                                @else
                                    Menunggu Pengiriman
                                @endif</td>
                            <td><button class="btn btn-block btn-primary btn-flat" type="button" data-target="#item{{$transaction->id}}" data-toggle="modal">Detail</button></td>
                            <div class="modal fade" id="item{{$transaction->id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="box-header with-border">
                                            <h4>Detail Transaksi {{$transaction->code}}</h4>
                                        </div>
                                        <div class="box-body">
                                            <form action="{{route('product.update')}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$transaction->id}}">
                                                <div class="form-group">
                                                    <label>Kode Transaksi</label>
                                                    <input type="text" class="form-control" value="{{$transaction->code}}" name="code" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Nama Pembeli</label>
                                                    <input type="text" class="form-control" value="{{App\User::where('id', '=', $transaction->user_id)->first()->name}}" name="username" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Nama Item</label>
                                                    <input type="text" class="form-control" value="{{App\Item::where('id', '=', $transaction->item_id)->first()->name}}" name="itemname" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Harga</label>
                                                    <input type="text" class="form-control" value="{{$transaction->price}}" name="code" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Kuantitas</label>
                                                    <input type="text" class="form-control" value="{{$transaction->qty}}" name="code" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Total</label>
                                                    <input type="text" class="form-control" value="{{$transaction->price*$transaction->qty}}" name="code" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <input type="text" class="form-control" value="{{$transaction->status}}" name="code" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Keterangan</label>
                                                    <input type="textarea" class="form-control" value="{{$transaction->msg}}" name="code" disabled>
                                                </div>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Nama Pembeli</th>
                            <th>Kode Transaksi</th>
                            <th>Daftar Item</th>
                            {{-- <th>Harga</th> --}}
                            {{-- <th>Kuantitas</th> --}}
                            <th>Total</th>
                            <th>Status</th>
                            {{-- <th>Kategori</th>
                            <th>Stok</th> --}}
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="tab-pane" id="tab_2">
                <table id="tableDikirim" class="table table-bordered table-striped">
                        <thead>
                                <tr>
                                    <th>Kode Transaksi</th>
                                    <th>Nama Pembeli</th>
                                    <th>Nama Item</th>
                                    <th>Harga</th>
                                    <th>Kuantitas</th>
                                    <th>Total</th>
                                    {{-- <th>Kategori</th>
                                    <th>Stok</th> --}}
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                @if($transaction->status == "2")
                                <tr>
                                    
                                    <td>{{$transaction->code}}</td>
                                    <td>{{App\User::where('id', '=', $transaction->user_id)->first()->name}}</td>
                                    <td>{{App\Item::where('id', '=', $transaction->item_id)->first()->name}}</td>
                                    <td>{{$transaction->price}}</td>
                                    <td>{{$transaction->qty}}</td>
                                    <td>{{$transaction->price*$transaction->qty}}</td>
                                    <td><button class="btn btn-block btn-primary btn-flat" type="button" data-target="#item{{$transaction->id}}" data-toggle="modal">Detail</button></td>
                                    <div class="modal fade" id="item{{$transaction->id}}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="box-header with-border">
                                                    <h4>Detail Transaksi {{$transaction->code}}</h4>
                                                </div>
                                                <div class="box-body">
                                                    <form action="{{route('product.update')}}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$transaction->id}}">
                                                        <div class="form-group">
                                                            <label>Kode Transaksi</label>
                                                            <input type="text" class="form-control" value="{{$transaction->code}}" name="code" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Nama Pembeli</label>
                                                            <input type="text" class="form-control" value="{{App\User::where('id', '=', $transaction->user_id)->first()->name}}" name="username" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Nama Item</label>
                                                            <input type="text" class="form-control" value="{{App\Item::where('id', '=', $transaction->item_id)->first()->name}}" name="itemname" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Harga</label>
                                                            <input type="text" class="form-control" value="{{$transaction->price}}" name="code" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Kuantitas</label>
                                                            <input type="text" class="form-control" value="{{$transaction->qty}}" name="code" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Total</label>
                                                            <input type="text" class="form-control" value="{{$transaction->price*$transaction->qty}}" name="code" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Status</label>
                                                            <input type="text" class="form-control" value="{{$transaction->status}}" name="code" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Keterangan</label>
                                                            <input type="textarea" class="form-control" value="{{$transaction->msg}}" name="code" disabled>
                                                        </div>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Kode Transaksi</th>
                                    <th>Nama Pembeli</th>
                                    <th>Nama Item</th>
                                    <th>Harga</th>
                                    <th>Kuantitas</th>
                                    <th>Total</th>
                                    {{-- <th>Kategori</th>
                                    <th>Stok</th> --}}
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_3">
                <table id="tableSelesai" class="table table-bordered table-striped">
                        <thead>
                                <tr>
                                    <th>Kode Transaksi</th>
                                    <th>Nama Pembeli</th>
                                    <th>Nama Item</th>
                                    <th>Harga</th>
                                    <th>Kuantitas</th>
                                    <th>Total</th>
                                    {{-- <th>Kategori</th>
                                    <th>Stok</th> --}}
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                @if($transaction->status == "3")
                                <tr>
                                    
                                    <td>{{$transaction->code}}</td>
                                    <td>{{App\User::where('id', '=', $transaction->user_id)->first()->name}}</td>
                                    <td>{{App\Item::where('id', '=', $transaction->item_id)->first()->name}}</td>
                                    <td>{{$transaction->price}}</td>
                                    <td>{{$transaction->qty}}</td>
                                    <td>{{$transaction->price*$transaction->qty}}</td>
                                    <td><button class="btn btn-block btn-primary btn-flat" type="button" data-target="#item{{$transaction->id}}" data-toggle="modal">Detail</button></td>
                                    <div class="modal fade" id="item{{$transaction->id}}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="box-header with-border">
                                                    <h4>Detail Transaksi {{$transaction->code}}</h4>
                                                </div>
                                                <div class="box-body">
                                                    <form action="{{route('product.update')}}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$transaction->id}}">
                                                        <div class="form-group">
                                                            <label>Kode Transaksi</label>
                                                            <input type="text" class="form-control" value="{{$transaction->code}}" name="code" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Nama Pembeli</label>
                                                            <input type="text" class="form-control" value="{{App\User::where('id', '=', $transaction->user_id)->first()->name}}" name="username" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Nama Item</label>
                                                            <input type="text" class="form-control" value="{{App\Item::where('id', '=', $transaction->item_id)->first()->name}}" name="itemname" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Harga</label>
                                                            <input type="text" class="form-control" value="{{$transaction->price}}" name="code" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Kuantitas</label>
                                                            <input type="text" class="form-control" value="{{$transaction->qty}}" name="code" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Total</label>
                                                            <input type="text" class="form-control" value="{{$transaction->price*$transaction->qty}}" name="code" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Status</label>
                                                            <input type="text" class="form-control" value="{{$transaction->status}}" name="code" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Keterangan</label>
                                                            <input type="textarea" class="form-control" value="{{$transaction->msg}}" name="code" disabled>
                                                        </div>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Kode Transaksi</th>
                                    <th>Nama Pembeli</th>
                                    <th>Nama Item</th>
                                    <th>Harga</th>
                                    <th>Kuantitas</th>
                                    <th>Total</th>
                                    {{-- <th>Kategori</th>
                                    <th>Stok</th> --}}
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
            </div>
            <div class="tab-pane" id="tab_4">
                <table id="tableArsip" class="table table-bordered table-striped">
                        <thead>
                                <tr>
                                    <th>Kode Transaksi</th>
                                    <th>Nama Pembeli</th>
                                    <th>Nama Item</th>
                                    <th>Harga</th>
                                    <th>Kuantitas</th>
                                    <th>Total</th>
                                    {{-- <th>Kategori</th>
                                    <th>Stok</th> --}}
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                @if($transaction->status == "4")
                                <tr>
                                    
                                    <td>{{$transaction->code}}</td>
                                    <td>{{App\User::where('id', '=', $transaction->user_id)->first()->name}}</td>
                                    <td>{{App\Item::where('id', '=', $transaction->item_id)->first()->name}}</td>
                                    <td>{{$transaction->price}}</td>
                                    <td>{{$transaction->qty}}</td>
                                    <td>{{$transaction->price*$transaction->qty}}</td>
                                    <td><button class="btn btn-block btn-primary btn-flat" type="button" data-target="#item{{$transaction->id}}" data-toggle="modal">Detail</button></td>
                                    <div class="modal fade" id="item{{$transaction->id}}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="box-header with-border">
                                                    <h4>Detail Transaksi {{$transaction->code}}</h4>
                                                </div>
                                                <div class="box-body">
                                                    <form action="{{route('product.update')}}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$transaction->id}}">
                                                        <div class="form-group">
                                                            <label>Kode Transaksi</label>
                                                            <input type="text" class="form-control" value="{{$transaction->code}}" name="code" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Nama Pembeli</label>
                                                            <input type="text" class="form-control" value="{{App\User::where('id', '=', $transaction->user_id)->first()->name}}" name="username" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Nama Item</label>
                                                            <input type="text" class="form-control" value="{{App\Item::where('id', '=', $transaction->item_id)->first()->name}}" name="itemname" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Harga</label>
                                                            <input type="text" class="form-control" value="{{$transaction->price}}" name="code" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Kuantitas</label>
                                                            <input type="text" class="form-control" value="{{$transaction->qty}}" name="code" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Total</label>
                                                            <input type="text" class="form-control" value="{{$transaction->price*$transaction->qty}}" name="code" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Status</label>
                                                            <input type="text" class="form-control" value="{{$transaction->status}}" name="code" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Keterangan</label>
                                                            <input type="textarea" class="form-control" value="{{$transaction->msg}}" name="code" disabled>
                                                        </div>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Kode Transaksi</th>
                                    <th>Nama Pembeli</th>
                                    <th>Nama Item</th>
                                    <th>Harga</th>
                                    <th>Kuantitas</th>
                                    <th>Total</th>
                                    {{-- <th>Kategori</th>
                                    <th>Stok</th> --}}
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
            </div>
            <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
    </div>
@endsection

@section('script')
    <!-- DataTables -->
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <!-- page script -->
    <script>
        $(function () {
            $('#tableMasuk').DataTable()
            $('#tableDikirim').DataTable({
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true
            })
            $('#tableSelesai').DataTable()
            $('#tableArsip').DataTable()
        })
    </script>
@endsection