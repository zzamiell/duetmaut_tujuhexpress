@extends('layouts.app', [
    'namePage' => 'clients',
    'class' => 'sidebar-mini',
    'activePage' => 'clients',
  ])

@section('content')
<style>
     .pagination {
        display: -ms-flexbox;
    flex-wrap: wrap;
    display: flex;
    padding-left: 0;
    list-style: none;
    border-radius: 0.25rem;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{ asset('assets/mask_input/jquery.maskedinput.js') }}"></script>
  <div class="panel-header panel-header-sm">
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            {{-- <h4 class="card-title"> Clients List </h4> --}}
            <div class="card-body">
                <h3 class="float-left mt-3">Clients List</h3>
                @if(session('access_menu'))
                    @foreach(session('access_menu') as $menu)
                        @if($menu['tb_menu']['menu_function_id'] == 2 && $menu['tb_menu']['menu_name'] == 'component-(/clients/index)-clients-create')
                        <a href="" type="button"
                            class="btn btn-dark waves-effect waves-light mt-3 float-right text-white"
                            style="background-color: #39BEAA; color: black; text-decoration: none;"
                            data-toggle="modal"
                            data-target="#exampleModal">Add new clients</a>
                        @endif
                    @endforeach
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                       <th>No</th>
                       <th>acc name</th>
                       <th>catgory</th>
                       <th>pic name</th>
                       <th>pic number</th>
                       <th>sales agent</th>
                       <th>cod fee</th>
                       <th>insurance fee</th>
                       <th>created at</th>
                       <th>action</th>
                      </thead>
                      <tbody>
                          @foreach ($clients['rows'] as $key => $item)
                          @php
                            $batas = $clients['max_page'];
                            $halaman = isset($clients['current_page'])?(int)$clients['current_page'] : 1;
                            $halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;
                            $previous = $halaman - 1;
				            $next = $halaman + 1;
                            $jumlah_data = $clients['total_data'];
				            $total_halaman = $clients['total_page'];
                            $nomor = $halaman_awal+1;

                          $created_at = date("Y-m-d", strtotime($item['created_at']));
                          @endphp
                          <tr>
                              <td style="vertical-align: middle;">{{ $key+1 }}</td>
                              <td style="vertical-align: middle;">{{ $item['account_name'] }}</td>
                              <td style="vertical-align: middle;">{{ $item['reff_client_category']['client_category'] }}</td>
                              <td style="vertical-align: middle;">{{ $item['pic_name'] }}</td>
                              <td style="vertical-align: middle;">{{ $item['pic_number'] }}</td>
                              <td style="vertical-align: middle;">{{ $item['sales_agent'] }}</td>
                              <td style="vertical-align: middle;">{{ $item['cod_fee'] }} %</td>
                              <td style="vertical-align: middle;">{{ $item['insurance_fee'] }} %</td>
                              <td style="vertical-align: middle;">{{ $item['created_at'] }}</td>
                              <td style="vertical-align: middle;">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                <!-- show -->
                                @if(session('access_menu'))
                                    @foreach(session('access_menu') as $menu)
                                        @if($menu['tb_menu']['menu_function_id'] == 2 && $menu['tb_menu']['menu_name'] == 'component-(/clients/index)-clients-show')
                                            <a href="index/{{$item['id']}}/0"
                                                type="button"
                                                class="btn">
                                                <i class="now-ui-icons ui-1_zoom-bold"></i>
                                            </a>
                                        @endif
                                    @endforeach
                                @endif

                                @if(session('access_menu'))
                                    @foreach(session('access_menu') as $menu)
                                        @if($menu['tb_menu']['menu_function_id'] == 2 && $menu['tb_menu']['menu_name'] == 'component-(/clients/index)-clients-delete')
                                            <button type="button"
                                                class="btn btn-danger"
                                                onclick=deletedata(<?= $item['id'] ?>)>
                                                <i class="now-ui-icons ui-1_simple-remove"></i>
                                            </button>
                                        @endif
                                    @endforeach
                                @endif

                                </div>
                            </td>
                          </tr>

                            <!-- Modal isi tambah banner -->
                            <div class="modal fade" id="edit{{ $item['id'] }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <form action="" method="POST"
                                            id="form-program" class="form-class" name="form-name"
                                            enctype="multipart/form-data">
                                            @method('PUT')
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
                                                    <input type="text" name="acc_name" class="form-control" value="{{ $item->account_name }}" required />
                                                </div>

                                               <div class="form-group">
                                                    <label>Clients Category</label>
                                                    <select name="clients_category" class="form-control" id="">
                                                    <optgroup label="Pilih scope">
                                                        @foreach ($category as $kt)
                                                        <option value="{{$kt->id}}">{{$kt->client_category}}</option>
                                                        @endforeach
                                                    </optgroup>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>Pic Name</label>
                                                    <input type="text" name="pic_name" class="form-control" value="{{ $item->pic_name }}" required />
                                                </div>

                                                <div class="form-group">
                                                    <label>Pic Number</label>
                                                    <input type="text" name="pic_number" class="form-control" value="{{ $item->pic_number }}" required />
                                                </div>

                                                <div class="form-group">
                                                    <label>Sales Agent</label>
                                                    <input type="text" name="sales_agent" class="form-control" value="{{ $item->sales_agent }}" required />
                                                </div>

                                                <div class="form-group">
                                                    <label>Cod Fee</label>
                                                    <input type="text" name="cod_fee" class="form-control" value="{{ $item->cod_fee }}" required />
                                                </div>

                                                <div class="form-group">
                                                    <label>Insurance Fee</label>
                                                    <input type="text" name="insurance_fee" class="form-control" value="{{ $item->insurance_fee }}" required />
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

                          @endforeach
                      </tbody>
                    </table>

                    <nav>
                        <ul class="pagination text-left">
                            <li class="page-item">
                                <a class="page-link" <?php if($halaman > 1){ echo "href='?halaman=$Previous'"; } ?>>Previous</a>
                            </li>
                            <?php
                            for($x=1;$x<=$total_halaman;$x++){
                                ?>
                                <li class="page-item"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
                                <?php
                            }
                            ?>
                            <li class="page-item">
                                <a  class="page-link" <?php if($halaman < $total_halaman) { echo "href='?halaman=$next'"; } ?>>Next</a>
                            </li>
                        </ul>
                    </nav>
                  </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal isi tambah banner -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <form action="{{ route('insert_client') }}" method="POST" id="form-program" class="form-class" name="form-name"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- isi --}}
                <div class="form-group">
                    <label>Account Name</label>
                    <input type="text" name="acc_name" class="form-control" required />
                </div>

               <div class="form-group">
                    <label>Clients Category</label>
                    <select name="clients_category" class="form-control" id="">
                    <optgroup label="Pilih scope">
                        @foreach ($category as $kt)
                        <option value="{{$kt->id}}">{{$kt->client_category}}</option>
                        @endforeach
                    </optgroup>
                    </select>
                </div>

                <div class="form-group">
                    <label>Pic Name</label>
                    <input type="text" name="pic_name" class="form-control" required />
                </div>

                <div class="form-group">
                    <label>Pic Number</label>
                    <input type="text" name="pic_number" class="form-control" required />
                </div>

                <div class="form-group">
                    <label>Sales Agent</label>
                    <input type="text" name="sales_agent" class="form-control" required />
                </div>

                <div class="form-group">
                    <label>Cod Fee</label>
                    <input type="text" name="cod_fee" class="form-control" id="cod" placeholder="00%" required />
                </div>

                <div class="form-group">
                    <label>Insurance Fee</label>
                    <input type="text" name="insurance_fee" id="insurance" placeholder="00%" class="form-control" required />
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


<script src="{{ asset('sweetalert/sweetalert.min.js') }}"></script>

@if(Session::has('data'))
<script type="text/javascript">
  swal("", "Berhasil tambah data client", "success");
</script>
@endif

<script type="text/javascript">
    jQuery(function($){
$("#cod").mask("99%");
$("#insurance").mask("99%");
});


        function tanggal_local(tanggal) {
            return tanggal;
        }
        function deletedata(id) {
        event.preventDefault();
        swal({
                title: "Apa Anda Yakin?",
                text: "Client yang dihapus akan hilang ",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{url('/hapus_clients')}}/" + id,
                        type: "post",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id,
                        },
                        success: function (data) {
                            console.log(data);
                            swal({
                                title: "Good job",
                                text: "Client berhasil dihapus",
                                icon: "success",
                                showCancelButton: false, // There won't be any cancel button
                                showConfirmButton: true
                            }).then(function (isConfirm) {
                                if (isConfirm) {
                                    location.reload();
                                } else {
                                    //if no clicked => do something else
                                }
                            });
                        },
                        error: function () {
                            swal('Client gagal di hapus', 'error');
                        }
                    });
                }
            });
    }
</script>

@endsection
