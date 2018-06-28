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
                            <th>Total</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                        @if($transaction->status >= 1 && $transaction->status <= 2)
                        <tr>
                            <td>{{App\User::where('id', '=', $transaction->user_id)->first()->name}}</td>
                            <td>{{$transaction->code}}</td>
                            <td>@foreach ($transaction->product as $product)
                                <h1  class="label @if ($product->category == "buah")
                                    bg-green
                                @elseif ($product->category == "sayuran")
                                    bg-yellow
                                @elseif ($product->category == "menu")
                                    bg-purple
                                @else
                                    bg-maroon
                                @endif">{{$product->name}}</h1>
                            @endforeach</td>
                            {{-- <td>{{$transaction->price}}</td> --}}
                            {{-- <td>{{$transaction->qty}}</td> --}}
                            <td>Rp {{$transaction->total}}</td>
                            <td>
                                @if ($transaction->status==1) 
                                    <span class="label bg-blue">Menunggu Pembayaran</span>
                                @elseif ($transaction->status==2) 
                                    <span class="label bg-green">Periksa Bukti Bayar</span>
                                @endif</td>
                            <td>
                                <button class="btn btn-block btn-primary btn-flat" type="button" 
                                data-target="#diterima{{$transaction->id}}" data-toggle="modal">Detail</button>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Nama Pembeli</th>
                            <th>Kode Transaksi</th>
                            <th>Daftar Item</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div>
                @foreach ($transactions as $transaction)
                <div class="modal fade" id="diterima{{$transaction->id}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="box-header with-border">
                                <h4>Detail Transaksi {{$transaction->code}}</h4>
                            </div>
                            <div class="box-body">
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
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" value="{{App\User::where('id', '=', $transaction->user_id)->first()->address}}" name="username" disabled>
                                </div>
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <th style="width: 10px">No</th>
                                            <th>Nama Item</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                            <th>Total</th>
                                            <th>Pesan</th>
                                        </tr>
                                        <p hidden>
                                            @php
                                                $nomor = 1;
                                                $items = App\Transaction::where('code', '=', $transaction->code)->get();
                                                // dd($items);
                                            @endphp
                                        </p>
                                        @foreach ($items as $item)
                                        <tr>
                                            <td>{{$nomor++}}</td>
                                            <td>{{App\Item::where('id', '=', $item->item_id)->first()->name}}</td>
                                            <td>{{$item->qty}}</td>
                                            <td>Rp {{$item->price}}</td>
                                            <td>Rp {{$item->qty*$item->price}}</td>
                                            <td>
                                                @if ($item->msg != null)
                                                    {{$item->msg}}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="form-group">
                                    <label>Bukti Pembayaran</label>
                                    @if ($transaction->payment_proof != null)
                                    <div class="row">
                                        <div class="col-md-12" style="display:table-cell; vertical-align:middle; text-align:center">
                                            {{-- <p>{{}}</p> --}}
                                            <img src="{{ asset('storage/'.$transaction->payment_proof) }}" height="300">
                                        </div>
                                    </div>
                                    @else
                                    <input type="text" class="form-control" disabled value="Belum Ada Bukti Pembayaran.">
                                    @endif
                                </div>
                            </div>
                            <div class="modal-footer box-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                <a href="/transaction/{{$transaction->code}}/3"><button type="button" class="btn btn-primary" 
                                    @if ($transaction->payment_proof == null)
                                        disabled
                                    @endif >Kirim Barang</button></a>
                                </form>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                @endforeach
            </div>
            <div class="tab-pane" id="tab_2">
                <table id="tableDikirim" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama Pembeli</th>
                            <th>Alamat Penerima</th>
                            <th>Kode Transaksi</th>
                            <th>Daftar Item</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                        @if($transaction->status == 3)
                        <tr>
                            <td>{{App\User::where('id', '=', $transaction->user_id)->first()->name}}</td>
                            <td>{{App\User::where('id', '=', $transaction->user_id)->first()->address}}</td>
                            <td>{{$transaction->code}}</td>
                            <td>@foreach ($transaction->product as $product)
                                <h1  class="label @if ($product->category == "buah")
                                    bg-green
                                @elseif ($product->category == "sayuran")
                                    bg-yellow
                                @elseif ($product->category == "menu")
                                    bg-purple
                                @else
                                    bg-maroon
                                @endif">{{$product->name}}</h1>
                            @endforeach</td>
                            {{-- <td>{{$transaction->price}}</td> --}}
                            {{-- <td>{{$transaction->qty}}</td> --}}
                            <td>Rp {{$transaction->total}}</td>
                            <td>
                                @if ($transaction->status==1) 
                                    <span class="label bg-blue">Menunggu Pembayaran</span>
                                @elseif ($transaction->status==2) 
                                    <span class="label bg-green">Periksa Bukti Bayar</span>
                                @elseif ($transaction->status==3) 
                                    <span class="label bg-maroon">Sedang Dikirim</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-block btn-primary btn-flat" type="button" 
                                data-target="#dikirim{{$transaction->id}}" data-toggle="modal">Detail</button>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Nama Pembeli</th>
                            <th>Alamat Penerima</th>
                            <th>Kode Transaksi</th>
                            <th>Daftar Item</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div>
                @foreach ($transactions as $transaction)
                <div class="modal fade" id="dikirim{{$transaction->id}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="box-header with-border">
                                <h4>Detail Transaksi {{$transaction->code}}</h4>
                            </div>
                            <div class="box-body">
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
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" value="{{App\User::where('id', '=', $transaction->user_id)->first()->address}}" name="username" disabled>
                                </div>
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <th style="width: 10px">No</th>
                                            <th>Nama Item</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                            <th>Total</th>
                                            <th>Pesan</th>
                                        </tr>
                                        <p hidden>
                                            @php
                                                $nomor = 1;
                                                $items = App\Transaction::where('code', '=', $transaction->code)->get();
                                                // dd($items);
                                            @endphp
                                        </p>
                                        @foreach ($items as $item)
                                        <tr>
                                            <td>{{$nomor++}}</td>
                                            <td>{{App\Item::where('id', '=', $item->item_id)->first()->name}}</td>
                                            <td>{{$item->qty}}</td>
                                            <td>Rp {{$item->price}}</td>
                                            <td>Rp {{$item->qty*$item->price}}</td>
                                            <td>
                                                @if ($item->msg != null)
                                                    {{$item->msg}}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="form-group">
                                    <label>Bukti Pembayaran</label>
                                    @if ($transaction->payment_proof != null)
                                    <div class="row">
                                        <div class="col-md-12" style="display:table-cell; vertical-align:middle; text-align:center">
                                            {{-- <p>{{}}</p> --}}
                                            <img src="{{ asset('storage/'.$transaction->payment_proof) }}" height="300">
                                        </div>
                                    </div>
                                    @else
                                    <input type="text" class="form-control" disabled value="Belum Ada Bukti Pembayaran.">
                                    @endif
                                </div>
                            </div>
                            <div class="modal-footer box-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                @endforeach
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_3">
                <table id="tableSelesai" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama Pembeli</th>
                            <th>Alamat Penerima</th>
                            <th>Kode Transaksi</th>
                            <th>Daftar Item</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                        @if($transaction->status == 4)
                        <tr>
                            <td>{{App\User::where('id', '=', $transaction->user_id)->first()->name}}</td>
                            <td>{{App\User::where('id', '=', $transaction->user_id)->first()->address}}</td>
                            <td>{{$transaction->code}}</td>
                            <td>@foreach ($transaction->product as $product)
                                <h1  class="label @if ($product->category == "buah")
                                    bg-green
                                @elseif ($product->category == "sayuran")
                                    bg-yellow
                                @elseif ($product->category == "menu")
                                    bg-purple
                                @else
                                    bg-maroon
                                @endif">{{$product->name}}</h1>
                            @endforeach</td>
                            {{-- <td>{{$transaction->price}}</td> --}}
                            {{-- <td>{{$transaction->qty}}</td> --}}
                            <td>Rp {{$transaction->total}}</td>
                            <td>
                                @if ($transaction->status==1) 
                                    <span class="label bg-blue">Menunggu Pembayaran</span>
                                @elseif ($transaction->status==2) 
                                    <span class="label bg-green">Periksa Bukti Bayar</span>
                                @elseif ($transaction->status==3) 
                                    <span class="label bg-maroon">Sedang Dikirim</span>
                                @elseif ($transaction->status==4) 
                                    <span class="label bg-purple">Barang Sudah Diterima</span>
                                @endif
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{$transaction->code}}/{{5}}">
                                            <button class="btn btn-block bg-green btn-flat" type="button" 
                                            >Arsipkan</button>
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <button class="btn btn-block btn-primary btn-flat" type="button" 
                                        data-target="#selesai{{$transaction->id}}" data-toggle="modal">Detail</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Nama Pembeli</th>
                            <th>Alamat Penerima</th>
                            <th>Kode Transaksi</th>
                            <th>Daftar Item</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div>
                @foreach ($transactions as $transaction)
                <div class="modal fade" id="selesai{{$transaction->id}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="box-header with-border">
                                <h4>Detail Transaksi {{$transaction->code}}</h4>
                            </div>
                            <div class="box-body">
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
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" value="{{App\User::where('id', '=', $transaction->user_id)->first()->address}}" name="username" disabled>
                                </div>
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <th style="width: 10px">No</th>
                                            <th>Nama Item</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                            <th>Total</th>
                                            <th>Pesan</th>
                                        </tr>
                                        <p hidden>
                                            @php
                                                $nomor = 1;
                                                $items = App\Transaction::where('code', '=', $transaction->code)->get();
                                                // dd($items);
                                            @endphp
                                        </p>
                                        @foreach ($items as $item)
                                        <tr>
                                            <td>{{$nomor++}}</td>
                                            <td>{{App\Item::where('id', '=', $item->item_id)->first()->name}}</td>
                                            <td>{{$item->qty}}</td>
                                            <td>Rp {{$item->price}}</td>
                                            <td>Rp {{$item->qty*$item->price}}</td>
                                            <td>
                                                @if ($item->msg != null)
                                                    {{$item->msg}}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="form-group">
                                    <label>Bukti Pembayaran</label>
                                    @if ($transaction->payment_proof != null)
                                    <div class="row">
                                        <div class="col-md-12" style="display:table-cell; vertical-align:middle; text-align:center">
                                            {{-- <p>{{}}</p> --}}
                                            <img src="{{ asset('storage/'.$transaction->payment_proof) }}" height="300">
                                        </div>
                                    </div>
                                    @else
                                    <input type="text" class="form-control" disabled value="Belum Ada Bukti Pembayaran.">
                                    @endif
                                </div>
                            </div>
                            <div class="modal-footer box-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                @endforeach
            </div>
            <div class="tab-pane" id="tab_4">
                <table id="tableArsip" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama Pembeli</th>
                            <th>Alamat Penerima</th>
                            <th>Kode Transaksi</th>
                            <th>Daftar Item</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                        @if($transaction->status == 5)
                        <tr>
                            <td>{{App\User::where('id', '=', $transaction->user_id)->first()->name}}</td>
                            <td>{{App\User::where('id', '=', $transaction->user_id)->first()->address}}</td>
                            <td>{{$transaction->code}}</td>
                            <td>@foreach ($transaction->product as $product)
                                <h1  class="label @if ($product->category == "buah")
                                    bg-green
                                @elseif ($product->category == "sayuran")
                                    bg-yellow
                                @elseif ($product->category == "menu")
                                    bg-purple
                                @else
                                    bg-maroon
                                @endif">{{$product->name}}</h1>
                            @endforeach</td>
                            {{-- <td>{{$transaction->price}}</td> --}}
                            {{-- <td>{{$transaction->qty}}</td> --}}
                            <td>Rp {{$transaction->total}}</td>
                            <td>
                                @if ($transaction->status==1) 
                                    <span class="label bg-blue">Menunggu Pembayaran</span>
                                @elseif ($transaction->status==2) 
                                    <span class="label bg-green">Periksa Bukti Bayar</span>
                                @elseif ($transaction->status==3) 
                                    <span class="label bg-maroon">Sedang Dikirim</span>
                                @elseif ($transaction->status==4) 
                                    <span class="label bg-purple">Barang Sudah Diterima</span>
                                @elseif ($transaction->status==5) 
                                    <span class="label bg-purple">Arsip</span>
                                @endif
                            </td>
                            <td>
                                <div class="row">
                                    {{-- <div class="col-md-6">
                                        <button class="btn btn-block bg-green btn-flat" type="button" 
                                        data-target="#arsip{{$transaction->id}}" data-toggle="modal">Arsipkan</button>
                                    </div> --}}
                                    <div class="col-md-12">
                                        <button class="btn btn-block btn-primary btn-flat" type="button" 
                                        data-target="#arsip{{$transaction->id}}" data-toggle="modal">Detail</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Nama Pembeli</th>
                            <th>Alamat Penerima</th>
                            <th>Kode Transaksi</th>
                            <th>Daftar Item</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div>
                @foreach ($transactions as $transaction)
                <div class="modal fade" id="arsip{{$transaction->id}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="box-header with-border">
                                <h4>Detail Transaksi {{$transaction->code}}</h4>
                            </div>
                            <div class="box-body">
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
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" value="{{App\User::where('id', '=', $transaction->user_id)->first()->address}}" name="username" disabled>
                                </div>
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <th style="width: 10px">No</th>
                                            <th>Nama Item</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                            <th>Total</th>
                                            <th>Pesan</th>
                                        </tr>
                                        <p hidden>
                                            @php
                                                $nomor = 1;
                                                $items = App\Transaction::where('code', '=', $transaction->code)->get();
                                                // dd($items);
                                            @endphp
                                        </p>
                                        @foreach ($items as $item)
                                        <tr>
                                            <td>{{$nomor++}}</td>
                                            <td>{{App\Item::where('id', '=', $item->item_id)->first()->name}}</td>
                                            <td>{{$item->qty}}</td>
                                            <td>Rp {{$item->price}}</td>
                                            <td>Rp {{$item->qty*$item->price}}</td>
                                            <td>
                                                @if ($item->msg != null)
                                                    {{$item->msg}}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="form-group">
                                    <label>Bukti Pembayaran</label>
                                    @if ($transaction->payment_proof != null)
                                    <div class="row">
                                        <div class="col-md-12" style="display:table-cell; vertical-align:middle; text-align:center">
                                            {{-- <p>{{}}</p> --}}
                                            <img src="{{ asset('storage/'.$transaction->payment_proof) }}" height="300">
                                        </div>
                                    </div>
                                    @else
                                    <input type="text" class="form-control" disabled value="Belum Ada Bukti Pembayaran.">
                                    @endif
                                </div>
                            </div>
                            <div class="modal-footer box-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                @endforeach
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