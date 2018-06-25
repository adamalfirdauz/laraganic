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
              <form role="form">
                <!-- text input -->
                <div class="form-group">
                  <label>Nama Produk</label>
                  <input type="text" class="form-control" placeholder="Nama Produk">
                </div>
                <div class="form-group">
                  <label>Jenis</label>
                  <select class="form-control">
                    <option>Sayuran</option>
                    <option>Buah-buahan</option>
                    <option>Menu Sehat</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Harga</label>
                  <input type="text" class="form-control" placeholder="Harga">
                </div>
                <div class="form-group">
                  <label>Stok</label>
                  <input type="text" class="form-control" placeholder="Jumlah Stok yang Tersedia">
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Keterangan</label>
                  <textarea class="form-control" rows="3" placeholder="Masukan keterangan ..."></textarea>
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">Gambar</label>
                  <input type="file" id="exampleInputFile">

                  <p class="help-block">Gambar dari produk.</p>
                </div>
              </form>
              <button class="btn btn-block btn-primary btn-flat" type="submit">Tambahkan</button>
            </div>
            
            <!-- /.box-body -->
          </div>
@endsection