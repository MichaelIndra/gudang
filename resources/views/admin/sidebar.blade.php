<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      @switch(Auth::user()->role)
        @case('OWN')
          <span class="brand-text font-weight-light">OWNER</span>
        @break
        @case('ADM')
          <span class="brand-text font-weight-light">ADMIN</span>
        @break
      @endswitch  
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Starter Pages
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            @if (Auth::user()->role == 'OWN')
            <ul class="nav nav-treeview">
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
              </li>
              
              <li class="nav-item ">
                <a href="{{route('suppliers.index')}}" class="nav-link {{set_active(['suppliers.index',  'suppliers.create', 'suppliers.edit'])}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>MASTER SUPPLIER</p>
                </a>
              </li>
              <li class="nav-item ">
                <a href="{{route('customers.index')}}" class=" nav-link {{set_active(['customers.index',  'customers.create', 'suppliers.edit'])}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>MASTER CUSTOMER</p>
                </a>
              </li>
              <li class="nav-item ">
                <a href="{{route('sales.index')}}" class=" nav-link {{set_active(['sales.index',  'sales.create', 'sales.edit'])}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>MASTER SALES</p>
                </a>
              </li>
              <li class="nav-item ">
                <a href="{{route('barangs.index')}}" class=" nav-link {{set_active(['barangs.index',  'barangs.create', 'barangs.edit'])}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>MASTER BARANG</p>
                </a>
              </li>
              
              <li class="nav-item ">
                <a href="{{route('hargasupps.index')}}" class=" nav-link {{set_active(['hargasupps.index',  'hargasupps.create', 'hargasupps.edit'])}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>HARGA SUPPLIER</p>
                </a>
              </li>
              
              <li class="nav-item ">
                <a href="{{route('hargacusts.index')}}" class=" nav-link {{set_active(['hargacusts.index',  'hargacusts.create', 'hargacusts.edit'])}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>HARGA CUSTOMER</p>
                </a>
              </li>

              <li class="nav-item ">
                <a href="{{route('stoks.index')}}" class=" nav-link {{set_active(['stoks.index'])}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>STOK</p>
                </a>
              </li>
              
              <li class="nav-item ">
                <a href="{{route('transaksisupplier.index')}}" class=" nav-link {{set_active(['transaksisupplier.index', 'transaksisupplier.detail', 'transaksisupplier.create'])}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>TRANSAKSI SUPPLIER</p>
                </a>
              </li>
              
              <li class="nav-item ">
                <a href="{{route('transaksicustomer.index')}}" class=" nav-link {{set_active(['transaksicustomer.index', 'transaksicustomer.create'])}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>TRANSAKSI CUSTOMER</p>
                </a>
              </li>
              
              <li class="nav-item ">
                <a href="{{route('retur.index')}}" class=" nav-link {{set_active(['retur.index', 'retur.add'])}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>RETUR</p>
                </a>
              </li>
              
              <li class="nav-item ">
                <a href="{{route('komisis.index')}}" class=" nav-link {{set_active(['komisis.index', 'komisis.create', 'komisi.byinvoice'])}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>KOMISI</p>
                </a>
              </li>

              <li class="nav-item ">
                <a href="{{route('reports.index')}}" class=" nav-link {{set_active(['reports.index'])}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>REPORT</p>
                </a>
              </li>
              @else
              <li class="nav-item ">
                <a href="{{route('transaksicustomer.index')}}" class=" nav-link {{set_active(['transaksicustomer.index', 'transaksicustomer.create'])}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>TRANSAKSI CUSTOMER</p>
                </a>
              </li>
              @endif
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>