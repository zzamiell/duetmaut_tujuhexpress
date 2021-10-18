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
                <div class="row mt-5">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6">
                        <form action="{{route('clients.index')}}" method="get">
                            <div class="input-group mb-3">
                                <input type="text" name="cari" value="{{app('request')->input('cari')}}" class="form-control" placeholder="Chilibeli">
                                <div class="input-group-append">
                                  <input type="submit" class="input-group-text" id="basic-addon2" value="Cari Clients">
                                </div>
                              </div>
                            </form>
                        </div>
                </div>
                <div class="table-responsive">
                    <table class="table" id="data">
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
                          @php
                            $page = (int)$clients['current_page'];
                            $limit = $clients['max_page'];
                            $limit_start = ($page - 1) * $limit;
                            $no = $limit_start + 1;
                          @endphp
                          @foreach ($clients['rows'] as $key => $item)
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
                    <div class="container">
                        <form action="{{ route('clients.index') }}" method="GET">
                        <div class="row" style="float: left">
                            <div class="form-group">
                                <label class="d-inline-block" style="text-color: black" for="max_page"><strong>Total Data : </strong></label>
                                <select name="max_page" onchange="this.form.submit()" class="form-control form-control-sm d-inline-block" style="width: auto;" id="max_page">
                                    <option value="10" @if($clients['max_page'] == "10") selected @endif>10</option>
                                    <option value="50" @if($clients['max_page'] == "50") selected @endif>50</option>
                                    <option value="100" @if($clients['max_page'] == "100") selected @endif>100</option>
                                    <option value="200" @if($clients['max_page'] == "200") selected @endif>200</option>
                                </select>

                            </div>
                        </div>
                        </form>
                        <nav class="mt-3">
                            <ul class="pagination justify-content-end">
                              @php
                              $jumlah_page = $clients['total_page'];
                              $jumlah_number = 1;
                              $start_number = ($page > $jumlah_number) ? $page - $jumlah_number : 1;
                              $end_number = ($page < ($jumlah_page - $jumlah_number)) ? $page + $jumlah_number : $jumlah_page;
                              if ($page == 1 || $page == 0) {
                                echo '<li class="page-item disabled"><a class="page-link" href="#">First</a></li>';
                                echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
                              } else {
                                $link_prev = ($page > 1) ? $page - 1 : 1;
                                echo '<li class="page-item"><a class="page-link" href="?page=1">First</a></li>';
                                echo '<li class="page-item"><a class="page-link" href="?page=' . $link_prev . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
                              }

                              for ($i = $start_number; $i <= $end_number; $i++) {
                                $link_active = ($page == $i) ? ' active' : '';
                                echo '<li class="page-item ' . $link_active . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                              }

                              if ($page == $jumlah_page || $page == 0) {
                                echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>';
                                echo '<li class="page-item disabled"><a class="page-link" href="#">Last</a></li>';
                              } else {
                                $link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page;
                                echo '<li class="page-item"><a class="page-link" href="?page=' . $link_next . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
                                echo '<li class="page-item"><a class="page-link" href="?page=' . $jumlah_page . '">Last</a></li>';
                              }
                              @endphp
                            </ul>
                          </nav>
                    </div>

            {{-- <div style="float: left">
                <label>
                    <span>Sell in</span>
                    <div>
                        <div class="form-group">
                            <div class="input-group">
                                <select class="form-control" name="max_page" id="max_page">
                                    <option value="10" @if($clients['max_page'] == "10") selected @endif>10</option>
                                    <option value="50" @if($clients['max_page'] == "50") selected @endif>50</option>
                                    <option value="100" @if($clients['max_page'] == "100") selected @endif>100</option>
                                    <option value="200" @if($clients['max_page'] == "200") selected @endif>200</option>
                                </select>
                            </div>
                        </div>

                    </div>
                  </label>
            </div> --}}

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

$(document).ready(function(){
    // console.log('cek');
    //   load_data();
    //   function load_data(page){
    //       console.log('masuk ke ajax');
    //       console.log(page);
    //        $.ajax({
    //             url:"{{url('/clients/index')}}",
    //             method:"GET",
    //             data:{page:page},
    //             success:function(data){
    //                  $('#data').html(data);
    //             }
    //        })
    //   }

    //   $(document).on('click', '.halaman', function(){
    //        var page = $(this).attr("id");
    //        load_data(page);
    //   });
 });

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
