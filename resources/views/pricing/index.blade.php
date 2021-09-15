@extends('layouts.app', [
    'namePage' => 'pricing',
    'class' => 'sidebar-mini',
    'activePage' => 'pricing',
  ])

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <div class="panel-header panel-header-sm">
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            {{-- <h4 class="card-title"> Clients List </h4> --}}
            <div class="card-body">
                <h3 class="float-left mt-3">Pricing List</h3>
                <a href="" type="button"
                    class="btn btn-dark waves-effect waves-light mt-3 float-right text-white"
                    style="background-color: #39BEAA; color: black; text-decoration: none;" data-toggle="modal" data-target="#exampleModal">Add new clients</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                       <th>No</th>
                       <th>province</th>
                       <th>area</th>
                       <th>district</th>
                       <th>subdistrict id</th>
                       <th>subdistrict</th>
                       <th>zip code</th>
                       <th>servcie order</th>
                       <th>service type</th>
                       <th>delivery fee</th>
                      </thead>
                      <tbody>
                          @foreach ($pricing as $key => $item)
                          <tr>
                              <td style="vertical-align: middle;">{{ $key=1 }}</td>
                              <td style="vertical-align: middle;">{{ $item->province }}</td>
                              <td style="vertical-align: middle;">{{ $item->area }}</td>
                              <td style="vertical-align: middle;">{{ $item->district }}</td>
                              <td style="vertical-align: middle;">{{ $item->subdistrict_id }}</td>
                              <td style="vertical-align: middle;">{{ $item->subdistrict }}</td>
                              <td style="vertical-align: middle;">{{ $item->zip_code }}</td>
                              <td style="vertical-align: middle;">{{ $item->service_order }}</td>
                              <td style="vertical-align: middle;">{{ $item->service_type }}</td>
                              <td style="vertical-align: middle;">{{ $item->price }}</td>
                              <td style="vertical-align: middle;">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn" data-toggle="modal" data-target="#edit{{ $item->id }}"><i
                                    class="now-ui-icons ui-1_zoom-bold"></i></button>
                                <button type="button" class="btn btn-danger"  onclick=deletedata(<?= $item->id ?>)><i
                                    class="now-ui-icons ui-1_simple-remove"></i></button>
                                </div>
                            </td>
                          </tr>

                            <!-- Modal isi tambah banner -->
                            <div class="modal fade" id="edit{{ $item->id }}" tabindex="-1" role="dialog"
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
                                                <div class="form-group">
                                                    <label>Province</label>
                                                    <input type="text" name="province" value="{{ $item->province }}" class="form-control" required />
                                                </div>

                                                <div class="form-group">
                                                    <label>Area</label>
                                                    <input type="text" name="area" class="form-control" value="{{ $item->area }}" required />
                                                </div>

                                                <div class="form-group">
                                                    <label>District</label>
                                                    <input type="text" name="district" class="form-control" value="{{ $item->district }}" required />
                                                </div>

                                                <div class="form-group">
                                                    <label>Subdistrict Id</label>
                                                    <input type="text" name="subdistrict_id" class="form-control" value="{{ $item->subdistrict_id }}" required />
                                                </div>

                                                <div class="form-group">
                                                    <label>Subdistrict</label>
                                                    <input type="text" name="subdistrict" class="form-control" value="{{ $item->subdistrict }}" required />
                                                </div>

                                                <div class="form-group">
                                                    <label>Zip code</label>
                                                    <input type="text" name="zipcode" class="form-control" value="{{ $item->zip_code }}" required />
                                                </div>

                                                <div class="form-group">
                                                    <label>Service order</label>
                                                    <input type="text" name="service_order" class="form-control" value="{{ $item->service_order }}"  required />
                                                </div>

                                                <div class="form-group">
                                                    <label>Service type</label>
                                                    <input type="text" name="service_type" class="form-control" value="{{ $item->service_type }}" required />
                                                </div>

                                                <div class="form-group">
                                                    <label>Delivery fee</label>
                                                    <input type="text" name="delivery_fee" class="form-control" value="{{ $item->price }}" required />
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
                          @endforeach
                      </tbody>
                    </table>
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
        <form action="" method="POST" id="form-program" class="form-class" name="form-name"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New pricing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- isi --}}
                <div class="form-group">
                    <label>Province</label>
                    <input type="text" name="province" class="form-control" required />
                </div>

                <div class="form-group">
                    <label>Area</label>
                    <input type="text" name="area" class="form-control" required />
                </div>

                <div class="form-group">
                    <label>District</label>
                    <input type="text" name="district" class="form-control" required />
                </div>

                <div class="form-group">
                    <label>Subdistrict Id</label>
                    <input type="text" name="subdistrict_id" class="form-control" required />
                </div>

                <div class="form-group">
                    <label>Subdistrict</label>
                    <input type="text" name="subdistrict" class="form-control" required />
                </div>

                <div class="form-group">
                    <label>Zip code</label>
                    <input type="text" name="zipcode" class="form-control" required />
                </div>

                <div class="form-group">
                    <label>Service order</label>
                    <input type="text" name="service_order" class="form-control" required />
                </div>

                <div class="form-group">
                    <label>Service type</label>
                    <input type="text" name="service_type" class="form-control" required />
                </div>

                <div class="form-group">
                    <label>Delivery fee</label>
                    <input type="text" name="delivery_fee" class="form-control" required />
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
<script type="text/javascript">
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
