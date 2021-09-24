@extends('layouts.app', [
'namePage' => 'clients',
'class' => 'sidebar-mini',
'activePage' => 'clients',
])

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
                <button type="button" data-toggle="modal" data-target="#edit{{ $clients->id }}" style="float: right"
                    class="btn btn-primary waves-effect waves-light mr-3 mt-3">Update Data</button>
                <div class="card-header">
                    <h5 class="title">Data Client ({{$clients->account_name}})</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">

                            <div class="col-md-12 pr-1">
                                <div class="form-group">
                                    <label>Account name</label>
                                    <input type="text" class="form-control" value="{{$clients->account_name}}" readonly>
                                </div>
                            </div>

                            <div class="col-md-12 pr-1">
                                <div class="form-group">
                                    <label>Account name</label>
                                    <select name="clients_category" class="form-control" id="" readonly>
                                        <optgroup label="Pilih scope">
                                            @foreach ($category as $kt)
                                            <option value="{{$kt->id}}" @if($kt->id==$clients->id) selected @endif>{{$kt->client_category}}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 pr-1">
                                <div class="form-group">
                                    <label>PIC name</label>
                                    <input type="text" class="form-control" value="{{$clients->pic_name}}" readonly>
                                </div>
                            </div>

                            <div class="col-md-12 pr-1">
                                <div class="form-group">
                                    <label>PIC number</label>
                                    <input type="text" class="form-control" value="{{$clients->pic_number}}" readonly>
                                </div>
                            </div>

                            <div class="col-md-12 pr-1">
                                <div class="form-group">
                                    <label>Sales agent</label>
                                    <input type="text" class="form-control" value="{{$clients->sales_agent}}" readonly>
                                </div>
                            </div>

                            <div class="col-md-12 pr-1">
                                <div class="form-group">
                                    <label>Cod fee</label>
                                    <input type="text" class="form-control" value="{{$clients->cod_fee}}" readonly>
                                </div>
                            </div>

                            <div class="col-md-12 pr-1">
                                <div class="form-group">
                                    <label>Insurance fee</label>
                                    <input type="text" class="form-control" value="{{$clients->insurance_fee}}"
                                        readonly>
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
                    <a type="button" href="/add_pricing/{{$clients->id}}" style="float: right" class="btn btn-primary waves-effect waves-light mr-3 mt-3">Add Pricing</a>
                    <a style="float: right" class="btn btn-success mt-3" href="/pricing/index/export/{{$pricing->currentPage()}}/{{Request::segment(3)}}">Export</a>
                    <a type="button" data-toggle="modal" data-target="#exampleModal" style="float: right" class="btn btn-primary waves-effect waves-light mt-3 text-white">Filter Service</a>
                    <a type="button" data-toggle="modal" data-target="#uploadModal" style="float: right" class="btn btn-primary waves-effect waves-light mt-3 text-white">Upload Data Pricing</a>
                <div class="card-header">
                    <h5 class="title">Data Pricing ({{$clients->account_name}})</h5>
                </div>
                <div class="card-body">
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
 <div class="modal fade" id="edit{{ $clients->id }}" tabindex="-1" role="dialog"
 aria-labelledby="exampleModalLabel" aria-hidden="true">
 <div class="modal-dialog modal-lg" role="document">
     <div class="modal-content">
         <form action="{{route('update_client', $clients->id)}}" method="POST" id="form-program" class="form-class" name="form-name" enctype="multipart/form-data">
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
                     <input type="text" name="acc_name" class="form-control" value="{{ $clients->account_name }}" required />
                 </div>

                <div class="form-group">
                     <label>Clients Category</label>
                     <select name="clients_category" class="form-control" id="">
                     <optgroup label="Pilih scope">
                         @foreach ($category as $kt)
                         <option value="{{$kt->id}}" @if($kt->id==$clients->id) selected @endif>{{$kt->client_category}}</option>
                         @endforeach
                     </optgroup>
                     </select>
                 </div>

                 <div class="form-group">
                     <label>Pic Name</label>
                     <input type="text" name="pic_name" class="form-control" value="{{ $clients->pic_name }}" required />
                 </div>

                 <div class="form-group">
                     <label>Pic Number</label>
                     <input type="text" name="pic_number" class="form-control" value="{{ $clients->pic_number }}" required />
                 </div>

                 <div class="form-group">
                     <label>Sales Agent</label>
                     <input type="text" name="sales_agent" class="form-control" value="{{ $clients->sales_agent }}" required />
                 </div>

                 <div class="form-group">
                     <label>Cod Fee</label>
                     <input type="text" name="cod_fee" class="form-control" value="{{ $clients->cod_fee }}" required />
                 </div>

                 <div class="form-group">
                     <label>Insurance Fee</label>
                     <input type="text" name="insurance_fee" class="form-control" value="{{ $clients->insurance_fee }}" required />
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
                console.log(parse.message)
            } else {
                console.log("error upload");
                console.log(parse.message)
            }
        }
    });


    
}
</script>

@endsection
