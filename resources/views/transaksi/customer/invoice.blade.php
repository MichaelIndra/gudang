<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="{{asset('css/style.css')}}" media="all" />
  <style>
    @media print{
      #printPageButton{
        display: none;
      }
      header nav, footer{
        display: none;
      }
      @page :left{
        margin:0.5cm;
      }
      @page :right{
        margin:0.8cm;
      }
    }
  </style>
</head>
<body>
    <button id="printPageButton" onClick="window.print();">Print</button>
    <header class="clearfix">
      <h1>{{$glb->id_trans_cust}}</h1>
      <div id="company" >
        <div><span>CUSTOMER</span>&nbsp;{{$glb->nama_cust}}</div>
        <div><span>ALAMAT</span>&nbsp;{{$glb->alamat}}</div>
        
        
      </div>
      <div id="project" >
        <div><span>INV</span>&nbsp;{{$glb->id_trans_cust}}</div>
        <div><span>CETAK</span>&nbsp;{{$now}}</div>
        @if ($glb->metode == 'TERM')
          <div><span>TERM</span>&nbsp;{{$glb->term}} hari</div>
          <div><span>JATUH TEMPO</span>&nbsp;{{Carbon\Carbon::now()->addDays($glb->term)->format('d/m/Y')}}</div>
        @else
          <div><span>TERM</span>&nbsp;{{$glb->metode}}</div>
        @endif
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th>NO</th>
            <th>NAMA ITEM</th>
            <th>HARGA SATUAN</th>
            <th>TOTAL BELI</th>
            <th>TOTAL HARGA</th>
          </tr>
        </thead>
        <tbody>
            @php 
                $i=1; 
                $totbyr=0;
                $tempTot = 0;
                $qty =0;
                $hrgsat = 0;
            @endphp
            @foreach($det as $data)
            
            <tr>
              <td>{{ $i++ }}</td>
              <td>{{$data->nama_brg}}</td>
              <td>{{number_format($data->harga_satuan, 2, ',', '.')}}</td>
              <td>{{$data->qty}}</td>
              <td>{{number_format($data->harga_total,2,',','.')}}</td>
            </tr>
            @endforeach

            <tr>
                <td colspan="4">SUBTOTAL</td>
                <td class="total">{{number_format($summ['harga_total'], 2, ',', '.')}}</td>
            </tr>
            <tr>
                <td colspan="4" class="grand total">GRAND TOTAL</td>
                <td class="grand total">{{number_format($summ['harga_total'], 2, ',', '.')}}</td>
            </tr>         
        </tbody>
      </table>
      <div id="notices">
        <div id="penjual">PENJUAL : </div>
        <div id="pembeli">PEMBELI : </div> 
      </div>
    </main>
</body>
</html>