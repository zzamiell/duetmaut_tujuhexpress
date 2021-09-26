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
                <div class="card-header">
                    <h5 class="title">Add Data Pricing</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('insert_pricing') }}" method="POST" id="form-program" class="form-class" name="form-name" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group">
                                <label>Account Name</label>
                                <input type="text" name="acc_name" class="form-control" value="{{ $clients->account_name }}" readonly />
                                <input type="hidden" name="id_client" class="form-control" value="{{ $clients->id }}" readonly />
                            </div>

                           <div class="form-group">
                                <label>Service Order</label>
                                <input type="text" name="service_order" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label>Price</label>
                                <input type="text" name="price" id="price" class="form-control" />
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
                                  <th>Price Template</th>
                                  <th>Action</th>
                                </tr>
                                @foreach ($area as $pilih)
                                <tr align="center">
                                  <td>{{ $pilih->province_name }}</td>
                                  <td>{{ $pilih->area_name }}</td>
                                  <td>{{ $pilih->district_name }}</td>
                                  <td>{{ $pilih->sub_district_name }}</td>
                                  <td>{{ $pilih->postal_code }}</td>
                                  <td>{{ $pilih->price_template }}</td>
                                  <td><button type="button" onclick="chooseArea(<?= $pilih->id ?>, <?= $pilih->price_template ?>)">Pilih area</button></td>
                                </tr>
                                @endforeach
                              </table>
                              <hr>
                              <div class="text-center">
                                {{$area->links("pagination::bootstrap-4")}}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn text-white"
                                style="background-color: #fc6400">Submit</button>
                        </div>
                    </form>
                </div>
        </div>
    </form>
    </div>
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

<script type="text/javascript">
function chooseArea(id, price_template) {
    $("#area").val("area sudah terpilih");
    $("#id_area").val(id);
    $("#price").val(price_template);
}
</script>

@endsection
