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
    <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Tambahkan Produk Baru</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form role="form" action="{{route('product.new')}}" method="POST">
                <!-- text input -->
                @csrf
                <div class="form-group">
                  <label>Nama Produk</label>
                  <input type="text" class="form-control" placeholder="Nama Produk" name="name">
                </div>
                <div class="form-group">
                  <label>Jenis</label>
                  <select class="form-control" name="category">
                    <option value="sayuran">Sayuran</option>
                    <option value="buah">Buah-buahan</option>
                    <option value="menu">Menu Sehat</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Harga</label>
                  <input type="text" class="form-control" placeholder="Harga" name="price">
                </div>
                <div class="form-group">
                  <label>Stok</label>
                  <input type="text" class="form-control" placeholder="Jumlah Stok yang Tersedia" name="stock">
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Keterangan</label>
                  <textarea class="form-control" rows="3" placeholder="Masukan keterangan ..." name="qty"></textarea>
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">Gambar</label>
                  <input type="file" id="exampleInputFile">

                  <p class="help-block">Gambar dari produk.</p>
                </div>
                <button class="btn btn-block btn-primary btn-flat" type="submit">Tambahkan</button>
              </form>
            </div>
            
            <!-- /.box-body -->
          </div>
@endsection