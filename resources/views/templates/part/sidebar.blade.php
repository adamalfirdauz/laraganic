<aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{Auth::user()->name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i>
          @role('admin')
              Admin
          @else
              Super Admin
          @endrole
          </a>
        </div>
      </div>
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="@if ($sidebar==1) active @endif">
          <a href="{{route('dashboard.index')}}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        {{-- <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li> --}}
        <li class="@if ($sidebar>20 && $sidebar<30) active @endif treeview">
          <a href="#">
            <i class="fa fa-book"></i> <span>Produk</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li @if ($sidebar==21) class="active" @endif><a href="{{route('product.page.add')}}"><i class="fa fa-circle-o"></i>Tambah Produk</a></li>
            <li @if ($sidebar==22) class="active" @endif><a href="{{route('product.page.update')}}"><i class="fa fa-circle-o"></i>Update Produk</a></li>
          </ul>
        </li>
        <li class="@if ($sidebar>30 && $sidebar<40) active @endif treeview">
          <a href="#">
            <i class="fa fa-money"></i> <span>Transaksi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li @if ($sidebar==31) class="active" @endif><a href="{{route('transaction.page.enter')}}"><i class="fa fa-circle-o"></i>Masuk</a></li>
            <li @if ($sidebar==32) class="active" @endif><a href="{{route('transaction.page.sending')}}"><i class="fa fa-circle-o"></i>Dikirim</a></li>
            <li @if ($sidebar==33) class="active" @endif><a href="{{route('transaction.page.accepted')}}"><i class="fa fa-circle-o"></i>Diterima</a></li>
            <li @if ($sidebar==34) class="active" @endif><a href="{{route('transaction.page.archive')}}"><i class="fa fa-circle-o"></i>Arsip</a></li>
          </ul>
        </li>
      </ul>
    </section>
  </aside>
