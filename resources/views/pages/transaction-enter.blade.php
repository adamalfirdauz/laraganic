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
                        <?php if($transaction->status == "1") { ?>
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
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">Default Modal {{$transaction->id}}</h4>
                                        </div>
                                    <div class="modal-body">
                                        <p>One fine body&hellip;</p>
                                    </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        </tr>
                        <?php }?>
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
                                <?php if($transaction->status == "2") { ?>
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
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title">Default Modal {{$transaction->id}}</h4>
                                                </div>
                                            <div class="modal-body">
                                                <p>One fine body&hellip;</p>
                                            </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                </tr>
                                <?php }?>
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
                                <?php if($transaction->status == "3") { ?>
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
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title">Default Modal {{$transaction->id}}</h4>
                                                </div>
                                            <div class="modal-body">
                                                <p>One fine body&hellip;</p>
                                            </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                </tr>
                                <?php }?>
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
                                <?php if($transaction->status == "4") { ?>
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
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title">Default Modal {{$transaction->id}}</h4>
                                                </div>
                                            <div class="modal-body">
                                                <p>One fine body&hellip;</p>
                                            </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                </tr>
                                <?php }?>
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