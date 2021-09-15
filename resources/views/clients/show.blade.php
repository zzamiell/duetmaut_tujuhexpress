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
                <button type="button" data-toggle="modal" data-target="#pricing{{ $clients->id }}" style="float: right"
                    class="btn btn-primary waves-effect waves-light mr-3 mt-3">Add Pricing</button>
                <div class="card-header">
                    <h5 class="title">Data Client ({{$clients->account_name}})</h5>
                </div>
                <div class="card-body">
                    <table>
                        <thead>
                            <thead>tes</thead>
                            <thead>tes</thead>
                            <thead>tes</thead>
                        </thead>
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
                    {{-- <div class="form-group">
                        <label>Account Name</label>
                        <input type="text" name="acc_name" class="form-control" value="{{ $clients->account_name }}" required />
                    </div> --}}

                   <div class="form-group">
                        <label>Clients Category</label>
                        <select name="clients_category" class="form-control" id="">
                        <optgroup label="Pilih scope">
                            @foreach ($area as $ar)
                            {{-- <option value="{{$ar->id}}">{{$ar->province_name .'-'.$ar->area_name.'-'.$ar->district_name.'-'.$ar->sub_district_name.'-'.$ar->pricing}}</option> --}}
                            @endforeach
                        </optgroup>
                        </select>
                    </div>

                    {{-- <div class="form-group">
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
                    </div> --}}
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
@endsection
