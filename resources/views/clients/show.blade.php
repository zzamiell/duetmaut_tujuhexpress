@extends('layouts.app', [
'namePage' => 'clients',
'class' => 'sidebar-mini',
'activePage' => 'clients',
])

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{ asset('assets/mask_input/jquery.maskedinput.js') }}"></script>
<div class="panel-header panel-header-sm">
</div>
<div class="content">
    <style>
        table, th, td {
          border: 1px solid black;
        }
        </style>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
            @if(session('access_menu'))
                @foreach(session('access_menu') as $menu)
                    @if($menu['tb_menu']['menu_function_id'] == 2 && $menu['tb_menu']['menu_name'] == 'component-(/clients/index)-clients-update')
                        <!-- update -->
                        <button
                            type="button"
                            data-toggle="modal"
                            data-target="#edit{{ $clients[0]['id'] }}"
                            style="float: right"
                            class="btn btn-primary waves-effect waves-light mr-3 mt-3">
                            Update Data
                        </button>
                    @endif
                @endforeach
            @endif

                <div class="card-header">
                    <h5 class="title">Data Client ({{$clients[0]['account_name']}})</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">

                            <div class="col-md-12 pr-1">
                                <div class="form-group">
                                    <label>Account name</label>
                                    <input type="text" class="form-control" value="{{$clients[0]['account_name']}}" readonly>
                                </div>
                            </div>

                            <div class="col-md-12 pr-1">
                                <div class="form-group">
                                    <label>Account name</label>
                                    <select name="clients_category" class="form-control" id="" readonly>
                                        <optgroup label="Pilih scope">
                                            @foreach ($category as $kt)
                                            <option value="{{$kt->id}}" @if($kt->id==$clients[0]['id']) selected @endif>{{$kt->client_category}}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 pr-1">
                                <div class="form-group">
                                    <label>PIC name</label>
                                    <input type="text" class="form-control" value="{{$clients[0]['pic_name']}}" readonly>
                                </div>
                            </div>

                            <div class="col-md-12 pr-1">
                                <div class="form-group">
                                    <label>PIC number</label>
                                    <input type="text" class="form-control" value="{{$clients[0]['pic_number']}}" readonly>
                                </div>
                            </div>

                            <div class="col-md-12 pr-1">
                                <div class="form-group">
                                    <label>Sales agent</label>
                                    <input type="text" class="form-control" value="{{$clients[0]['sales_agent']}}" readonly>
                                </div>
                            </div>

                            <div class="col-md-12 pr-1">
                                <div class="form-group">
                                    <label>Cod fee</label>
                                    <input type="text" id="cod" class="form-control" value="{{$clients[0]['cod_fee']}}%" readonly>
                                </div>
                            </div>

                            <div class="col-md-12 pr-1">
                                <div class="form-group">
                                    <label>Insurance fee</label>
                                    <input type="text" class="form-control" value="{{$clients[0]['insurance_fee']}}%" readonly>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </form>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                {{-- <button type="button" data-toggle="modal" data-target="#pricing{{ $clients->id }}" style="float: right"
                    class="btn btn-primary waves-effect waves-light mr-3 mt-3">Add Pricing</button> --}}

                    @if(session('access_menu'))
                        @foreach(session('access_menu') as $menu)
                            @if($menu['tb_menu']['menu_function_id'] == 2 && $menu['tb_menu']['menu_name'] == 'component-(/clients/index)-clients-create-data-pricing')
                                <!-- add pricing -->
                                <a
                                    type="button"
                                    href="/add_pricing/{{$clients[0]['id']}}"
                                    style="float: right"
                                    class="btn btn-primary waves-effect waves-light mr-3 mt-3">
                                    Add Pricing
                                </a>
                            @endif
                        @endforeach
                    @endif

                    @if(session('access_menu'))
                        @foreach(session('access_menu') as $menu)
                            @if($menu['tb_menu']['menu_function_id'] == 2 && $menu['tb_menu']['menu_name'] == 'component-(/clients/index)-clients-export-data-pricing')
                                <!-- export -->
                                <a
                                    style="float: right"
                                    class="btn btn-success mt-3"
                                    href="/pricing/index/export/{{$pricing->currentPage()}}/{{Request::segment(3)}}">
                                    Export
                                </a>
                            @endif
                        @endforeach
                    @endif
                    {{-- <a type="button" data-toggle="modal" data-target="#exampleModal" style="float: right" class="btn btn-primary waves-effect waves-light mt-3 text-white">Filter Service</a> --}}

                    @if(session('access_menu'))
                        @foreach(session('access_menu') as $menu)
                            @if($menu['tb_menu']['menu_function_id'] == 2 && $menu['tb_menu']['menu_name'] == 'component-(/clients/index)-clients-upload-data-pricing')
                                <!-- upload -->
                                <a type="button"
                                    data-toggle="modal"
                                    data-target="#uploadModal"
                                    style="float: right"
                                    class="btn btn-primary waves-effect waves-light mt-3 text-white">
                                    Upload Data Pricing
                                </a>
                            @endif
                        @endforeach
                    @endif
                <div class="card-header">
                    <h5 class="title">Data Pricing ({{$clients[0]['account_name']}})</h5>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <!-- Filter Section -->
                        <form action="{{Request::fullUrl()}}" method="GET" enctype="multipart/form-data">
                          <div class="row">
                                <div class="col-md-9">
                                  {{ csrf_field() }}
                                </div>

                                <div class="col-md-3">
                                  <select name="service_order" onchange="this.form.submit()" class="form-control" id="">
                                  {{-- <optgroup label="Pilih service order"> --}}
                                      <option value="">==Pilih service order===</option>
                                      @foreach ($breadcumb as $key => $item)
                                      <option value="{{$item->service_order}}">{{$item->service_order}}</option>
                                      @endforeach
                                  {{-- </optgroup> --}}
                                  </select>
                                </div>
                              </div>
                          </form>
                        </div>
                    {{-- <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            @foreach ($breadcumb as $key => $item )
                            <li class="breadcrumb-item"><a href="index/{{Request::segment(3)}}/{{$item->service_order}}">{{ $item->service_order }}</a></li>
                            @endforeach
                        </ol>
                      </nav> --}}
                      <div class="row">
                        <div class="col-md-8">
                            <div class="text-center pagination">
                                {{$pricing->links("pagination::bootstrap-4")}}
                            </div>
                        </div>
                        <div class="col-md-4">
                        </div>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table" style="border: none">
                          <thead class=" text-primary">
                           <th>No</th>
                           <th>acc name</th>
                           <th>Pic number</th>
                           <th>Service order</th>
                           <th>Province</th>
                           <th>Area</th>
                           <th>Districr</th>
                           <th>Subdistrict</th>
                           <th>Postal code</th>
                           <th>Pricing</th>
                          </thead>
                          <tbody>
                              @foreach ($pricing as $key => $item)
                              @php
                            //   $created_at = date("Y-m-d", strtotime($item['created_at']));
                              @endphp
                              <tr style="border: none" align="center">
                                  <td style="vertical-align: middle; border: none">{{ $key+1 }}</td>
                                  <td style="vertical-align: middle; border: none">{{ $item->account_name }}</td>
                                  <td style="vertical-align: middle; border: none">{{ $item->pic_number }}</td>
                                  <td style="vertical-align: middle; border: none">{{ $item->service_order }}</td>
                                  <td style="vertical-align: middle; border: none">{{ $item->province_name }}</td>
                                  <td style="vertical-align: middle; border: none">{{ $item->area_name }}</td>
                                  <td style="vertical-align: middle; border: none">{{ $item->district_name }}</td>
                                  <td style="vertical-align: middle; border: none">{{ $item->sub_district_name }}</td>
                                  <td style="vertical-align: middle; border: none">{{ $item->postal_code }}</td>
                                  <td style="vertical-align: middle; border: none">{{ $item->pricing }}</td>
                              </tr>
                              {{-- <tr style="border: none" align="center">
                                  <td style="vertical-align: middle; border: none">{{ $key+1 }}</td>
                                  <td style="vertical-align: middle; border: none">{{ $item['tb_client']['account_name'] }}</td>
                                  <td style="vertical-align: middle; border: none">{{ $item['tb_client']['pic_number'] }}</td>
                                  <td style="vertical-align: middle; border: none">{{ $item['reff_service_order']['service_order'] }}</td>
                                  <td style="vertical-align: middle; border: none">{{ $item['reff_area']['province_name'] }}</td>
                                  <td style="vertical-align: middle; border: none">{{ $item['reff_area']['area_name'] }}</td>
                                  <td style="vertical-align: middle; border: none">{{ $item['reff_area']['district_name'] }}</td>
                                  <td style="vertical-align: middle; border: none">{{ $item['reff_area']['sub_district_name'] }}</td>
                                  <td style="vertical-align: middle; border: none">{{ $item['reff_area']['postal_code'] }}</td>
                              </tr> --}}
                              @endforeach
                          </tbody>
                          <div class="text-center pagination">
                            {{$pricing->links("pagination::bootstrap-4")}}
                        </div>
                        </table>
                      </div>
                </div>
            </div>
        </div>


    </div>
</div>
</div>
</div>
</div>
</div>


 <!-- Modal isi tambah banner -->
 <div class="modal fade" id="edit{{ $clients[0]['id'] }}" tabindex="-1" role="dialog"
 aria-labelledby="exampleModalLabel" aria-hidden="true">
 <div class="modal-dialog modal-lg" role="document">
     <div class="modal-content">
         <form action="{{route('update_client', $clients[0]['id'])}}" method="POST" id="form-program" class="form-class" name="form-name" enctype="multipart/form-data">
            {{-- @method('PUT') --}}
            @csrf
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Change client
                 </h5>
                 <button type="button" class="close" data-dismiss="modal"
                     aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 {{-- isi --}}
                 <div class="form-group">
                     <label>Account Name</label>
                     <input type="text" name="acc_name" class="form-control" value="{{ $clients[0]['account_name'] }}" required />
                 </div>

                <div class="form-group">
                     <label>Clients Category</label>
                     <select name="clients_category" class="form-control" id="">
                     <optgroup label="Pilih scope">
                         @foreach ($category as $kt)
                         <option value="{{$kt->id}}" @if($kt->id==$clients[0]['id']) selected @endif>{{$kt->client_category}}</option>
                         @endforeach
                     </optgroup>
                     </select>
                 </div>

                 <div class="form-group">
                     <label>Pic Name</label>
                     <input type="text" name="pic_name" class="form-control" value="{{ $clients[0]['pic_name'] }}" required />
                 </div>

                 <div class="form-group">
                     <label>Pic Number</label>
                     <input type="text" name="pic_number" class="form-control" value="{{ $clients[0]['pic_number'] }}" required />
                 </div>

                 <div class="form-group">
                     <label>Sales Agent</label>
                     <input type="text" name="sales_agent" class="form-control" value="{{ $clients[0]['sales_agent'] }}" required />
                 </div>

                 <div class="form-group">
                     <label>Cod Fee</label>
                     <input type="text" name="cod_fee" id="codnya" class="form-control" value="{{ $clients[0]['cod_fee'] }}%" placeholder="00%" required />
                 </div>

                 <div class="form-group">
                     <label>Insurance Fee</label>
                     <input type="text" name="insurance_fee" id="insurance" class="form-control" value="{{ $clients[0]['insurance_fee'] }}%" placeholder="00%" required />
                 </div>
                 {{-- end isi --}}
             </div>
             <div class="modal-footer">
                 <button type="submit" class="btn text-white"
                     style="background-color: #fc6400">Submit</button>
             </div>
         </form>
     </div>
 </div>
</div>

 <!-- Modal isi tambah banner -->
 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
 aria-hidden="true">
 <div class="modal-dialog modal-lg" role="document">
     <div class="modal-content">
         <form action="{{Request::fullUrl()}}" method="GET" id="form-program" class="form-class" name="form-name"
             enctype="multipart/form-data">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Filter berdasarkan service order</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 {{-- isi --}}
                <div class="form-group">
                     <label>Service order</label>
                     <select name="service_order" class="form-control" id="">
                     <optgroup label="Pilih service order">
                         @foreach ($breadcumb as $key => $item)
                         <option value="{{$item->service_order}}">{{$item->service_order}}</option>
                         @endforeach
                     </optgroup>
                     </select>
                 </div>
                 {{-- end isi --}}
             </div>
             <div class="modal-footer">
                 <button type="submit" class="btn text-white btn-success">Submit</button>
             </div>
         </form>
     </div>
 </div>
 </div>


 <!-- Modal upload data pricing -->
 <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
 aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Data Pricing</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>

            <div class="modal-body">
                    {{-- isi --}}
                    <div class="input-group">

                        <div class="input-group-text">
                            <i class="now-ui-icons arrows-1_cloud-upload-94"></i>
                        </div>
                        <form class="form-class" id="formupload">
                            <input
                                        type="file"
                                        name="import_file" id="datapricingid">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                    </div>
                                    {{-- end isi --}}
                                </div>
                            <div class="modal-footer">
                                <button type="button" class="btn text-white btn-success" onclick="processImport()">Upload</button>
                            </div>
                        </form>
                     </div>
            </div>
        </div>
    </div>
 </div>




<script src="{{ asset('sweetalert/sweetalert.min.js') }}"></script>

@if(Session::has('edit'))
<script type="text/javascript">
  swal("", "Berhasil mengubah data client", "success");
</script>
@endif

@if(Session::has('price'))
<script type="text/javascript">
  swal("", "Berhasil menambah data pricing client", "success");
</script>
@endif

@if(Session::has('export_pricing'))
<script type="text/javascript">
  swal("", "Export pricing has been downloaded!", "success");
</script>
@endif

<script type="text/javascript">
  jQuery(function($){
$("#codnya").mask("99%");
$("#insurance").mask("99%");
});

function myFunction(id) {
    $("#area").val("area sudah terpilih");
    $("#id_area").val(id);
}

function processImport(){

    if($('#file').val()===''){
        $( "#file" ).addClass( "is-invalid" );
        return false;
    }else{
        $("#file").removeClass( "is-invalid" );

    }

    var formData = new FormData();
    formData.append( 'file', $( '#datapricingid' )[0].files[0] );

    console.log("FORM DATA :");
    console.log(formData);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('#token').val()
        }
    });

    console.log("UPLOAD BRO...");
    console.log('{{ route('importExcelTbPricing') }}');

    $.ajax({
        type: 'POST',
        url: '{{ route('importExcelTbPricing') }}',
        data: formData,
        processData: false,
        contentType: false,
        success: function (res){
            console.log("THIS IS FROM AJAX : ");
            console.log(res);
            console.log("================");
            var parse = $.parseJSON(res);
            console.log("================");

            if (parse.statusCode == 200){
                console.log("success upload");
                console.log(parse.message);
                swal("", parse.message, "success");
                $('#uploadModal').modal('toggle');
            } else {
                console.log("error upload");
                console.log(parse.message);
                swal("", parse.message, "error");
                $('#uploadModal').modal('toggle');
            }
        }
    });



}
</script>

@endsection
