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
    <div class="row">
        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{App\User::count()}}</h3>

                    <p>Jumlah User</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{App\Item::count()}}</h3>

                    <p>Jumlah Produk</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{App\Transaction::where("status", '=', 1)->count()}}</h3>

                    <p>Barang Masuk</p>
                </div>
                <div class="icon">
                    <i class="ion ion-forward"></i>
                </div>
                
            </div>
        </div>

        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
              <div class="small-box bg-purple">
                  <div class="inner">
                      <h3>{{App\Transaction::where("status", '=', 2)->count()}}</h3>
  
                      <p>Barang Dibayar</p>
                  </div>
                  <div class="icon">
                      <i class="ion ion-cash"></i>
                  </div>
                  
              </div>
          </div>


        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{App\Transaction::where("status", '=', 3)->count()}}</h3>

                    <p>Barang Dikirim</p>
                </div>
                <div class="icon">
                    <i class="ion ion-paper-airplane"></i>
                </div>
                
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
              <div class="small-box bg-fuchsia">
                  <div class="inner">
                      <h3>{{App\Transaction::where("status", '=', 4)->count()}}</h3>
  
                      <p>Barang Diterima</p>
                  </div>
                  <div class="icon">
                      <i class="ion ion-home"></i>
                  </div>
                  
              </div>
          </div>

    </div>
      <!-- /.row -->
@endsection