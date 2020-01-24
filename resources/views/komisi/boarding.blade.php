@extends('index')

@section('head')
<a href="{{route('komisis.create')}}" class="btn btn-info ml-3" id="create-new-user">Tambah Komisi Sales</a>
<a href="{{route('komisi.byinvoice')}}" class="btn btn-info ml-3" id="create-new-user">Lihat Invoice</a>
@endsection

@section('content')

    <div class="row-md-1">   
        <table class="display " id="table" style="width:100%">
            <thead>
            <tr>
                <th>Nama Sales</th>
                <th>Komisi</th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="row-md-4">
        <div class ="column-md-2">
            <input name="bulan" id="bulan" class="form-control datepicker-autoclose" placeholder="Please select start date" />    
        </div>
        <div class ="column-md-2">
        <button id="search">Search</button>
        </div>
    </div>
    
    
    
@endsection

@section('script')
    <script>
         $(function() {
            var table = $('#table').DataTable({
               processing: true,
               serverSide: true,
               ajax: {
                    url : "{{ route('komisi.dataglobal') }}",
                    type : 'GET',
                    data : function (d){
                        d.bulan = $('#bulan').val();
                    }
               },
               columns :[
                     {data : 'nama_sales', name: 'nama_sales'},
                     {data : 'total_komisi', name : 'total_komisi', render: $.fn.dataTable.render.number( ',', '.', 2 )},
                     
                     
                  ],
                  columnDefs : [
                    {targets : [1], className : 'dt-right'    },
                ] 
            });

            $('#search').click(function(){

                table.draw(true);
            });
            $('#bulan').datepicker(
            {
                dateFormat: "mm-yy",
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                onClose: function(dateText, inst) {


                    function isDonePressed(){
                        return ($('#ui-datepicker-div').html().indexOf('ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all ui-state-hover') > -1);
                    }

                    if (isDonePressed()){
                        var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                        $(this).datepicker('setDate', new Date(year, month, 1)).trigger('change');
                        
                            $('.date-picker').focusout()//Added to remove focus from datepicker input box on selecting date
                    }
                },
                beforeShow : function(input, inst) {

                    inst.dpDiv.addClass('month_year_datepicker')

                    if ((datestr = $(this).val()).length > 0) {
                        year = datestr.substring(datestr.length-4, datestr.length);
                        month = datestr.substring(0, 2);
                        $(this).datepicker('option', 'defaultDate', new Date(year, month-1, 1));
                        $(this).datepicker('setDate', new Date(year, month-1, 1));
                        $(".ui-datepicker-calendar").hide();
                    }
                }
            })

         });

         
        
    </script>
    
@endsection

@section('scriptcss')
    <style>
        .ui-datepicker-calendar {
            display: none;
        }
    </style>
@endsection