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
                <div class="card-header">
                    <h5 class="title">Data Pricing ({{$clients->account_name}})</h5>
                </div>
                <div class="card-body">
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
                                  <td style="vertical-align: middle; border: none">{{ $item['tb_client']['account_name'] }}</td>
                                  <td style="vertical-align: middle; border: none">{{ $item['tb_client']['pic_number'] }}</td>
                                  <td style="vertical-align: middle; border: none">{{ $item['reff_service_order']['service_order'] }}</td>
                                  <td style="vertical-align: middle; border: none">{{ $item['reff_area']['province_name'] }}</td>
                                  <td style="vertical-align: middle; border: none">{{ $item['reff_area']['area_name'] }}</td>
                                  <td style="vertical-align: middle; border: none">{{ $item['reff_area']['district_name'] }}</td>
                                  <td style="vertical-align: middle; border: none">{{ $item['reff_area']['sub_district_name'] }}</td>
                                  <td style="vertical-align: middle; border: none">{{ $item['reff_area']['postal_code'] }}</td>
                              </tr>
                              @endforeach
                          </tbody>
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
<div class="modal fade" id="pricing{{ $clients->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('insert_pricing') }}" method="POST" id="form-program" class="form-class" name="form-name" enctype="multipart/form-data">
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
                        <input type="text" name="acc_name" class="form-control" value="{{ $clients->account_name }}" readonly />
                        <input type="hidden" name="id_client" class="form-control" value="{{ $clients->id }}" readonly />
                    </div>

                   <div class="form-group">
                        <label>Service Order</label>
                        <select name="service_order" class="form-control" id="">
                        <optgroup label="Pilih service order">
                            @foreach ($service as $ar)
                            <option value="{{$ar->id}}">{{$ar->service_order}}</option>
                            @endforeach
                        </optgroup>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Price</label>
                        <input type="text" name="price" class="form-control" />
                    </div>

                    <div class="form-group">
                        <label>Area</label>
                        <input type="text" name="area" id="area" placeholder="Pilih area pada table dibawah" class="form-control" readonly/>
                        <input type="hidden" name="id_area" id="id_area" class="form-control" readonly/>
                    </div>
                    <hr>
                    <div>
                        <small style="float: left; color:red" class="mt-5">*Silahkan pilih area</small>
                        <div style="float: right" class="col-md-4">
                            {{-- <form action="/orders/index" method="get"> --}}
                                {{-- {{ csrf_field() }} --}}
                                {{-- <input name="search" class="form-control mb-2" placeholder="Cari perusahaan" type="text" /><input type="submit"> --}}
                                <div class="input-group">
                                    <input type="text" name="cari" class="form-control" placeholder="TX-210914000001">
                                    <div class="input-group-append">
                                      <input type="submit" class="input-group-text" id="basic-addon2" value="Cari Area">
                                    </div>
                                </div>
                            {{-- </form> --}}
                        </div>
                    </div>
                    <table style="width: 100%">
                        <tr>
                          <th>Province</th>
                          <th>Area</th>
                          <th>District</th>
                          <th>Subdistrict</th>
                          <th>Postal code</th>
                          <th>Action</th>
                        </tr>
                        @foreach ($area as $pilih)
                        <tr align="center">
                          <td>{{ $pilih->province_name }}</td>
                          <td>{{ $pilih->area_name }}</td>
                          <td>{{ $pilih->district_name }}</td>
                          <td>{{ $pilih->sub_district_name }}</td>
                          <td>{{ $pilih->postal_code }}</td>
                          <td><button type="button" onclick="myFunction(<?= $pilih->id ?>)">Pilih area</button></td>
                        </tr>
                        @endforeach
                      </table>
                      <hr>
                      <div class="text-center">
                        {{$area->links("pagination::bootstrap-4")}}
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

<script type="text/javascript">
function myFunction(id) {
    $("#area").val("area sudah terpilih");
    $("#id_area").val(id);
}
</script>

@endsection
