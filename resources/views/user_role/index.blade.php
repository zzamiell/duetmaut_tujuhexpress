@extends('layouts.app', [
    'namePage' => 'user-role',
    'class' => 'sidebar-mini',
    'activePage' => 'user-role',
  ])

@section('content')
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
                <h3 class="float-left mt-3">Manage role user access</h3>

                @if(session('access_menu'))
                    @foreach(session('access_menu') as $key => $menu)
                        @if($menu['tb_menu']['menu_function_id'] == 2 && $menu['tb_menu']['menu_name'] == 'userrole-create')
                            <a href="" type="button"
                            class="btn btn-dark waves-effect waves-light mt-3 float-right text-white"
                            style="background-color: #39BEAA; color: black; text-decoration: none;" data-toggle="modal" data-target="#exampleModal">Add new role</a>
                        @endif
                    @endforeach
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                       <th>No</th>
                       <th>User Role</th>
                       <th>action</th>
                      </thead>
                      <tbody>
                          @foreach ($role as $key => $item)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$item->user_role_name}}</td>
                                <td style="vertical-align: middle;">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="#" data-toggle="modal" data-target="#exampleModal{{$item->id}}" type="button" class="btn"><i
                                        class="now-ui-icons ui-1_zoom-bold"></i></a>
                                    <button type="button" class="btn btn-danger"  onclick=deletedata(<?= $item->id ?>)><i
                                        class="now-ui-icons ui-1_simple-remove"></i></button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal isi edit user role -->
                            <div class="modal fade" id="exampleModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('role.update') }}" method="POST" id="form-program" class="form-class" name="form-name"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Update role</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            {{-- isi --}}
                                            <input type="hidden" name="id" value="{{$item->id}}">
                                            <div class="form-group">
                                                <label>Roles name</label>
                                                <input type="text" name="role" value="{{$item->user_role_name}}" class="form-control" required />
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
                          @endforeach
                      </tbody>
                    </table>
                  </div>
            </div>
          </div>
        </div>
      </div>


  <!-- Modal isi tambah user role -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <form action="{{ route('role.store') }}" method="POST" id="form-program" class="form-class" name="form-name"
              enctype="multipart/form-data">
              @csrf
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">New role</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  {{-- isi --}}
                  <div class="form-group">
                      <label>Roles name</label>
                      <input type="text" name="role" class="form-control" required />
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
  swal("", "Berhasil tambah user role", "success");
</script>
@endif

@if(Session::has('update'))
<script type="text/javascript">
  swal("", "Berhasil mengubah user role", "success");
</script>
@endif

<script type="text/javascript">

        function deletedata(id) {
        event.preventDefault();
        swal({
                title: "Apa Anda Yakin?",
                text: "User role yang dihapus akan hilang ",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{url('/role/delete-user-role')}}/" + id,
                        type: "post",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id,
                        },
                        success: function (data) {
                            console.log(data);
                            swal({
                                title: "Good job",
                                text: "User role berhasil dihapus",
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
                            swal('User role gagal di hapus', 'error');
                        }
                    });
                }
            });
    }
</script>

@endsection
