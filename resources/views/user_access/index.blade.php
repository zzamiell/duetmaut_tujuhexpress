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
                    <div class="card-body">
                        <h3 class="float-left mt-3">Manage role user access</h3>

                        @if(session('access_menu'))
                            @foreach(session('access_menu') as $key => $menu)
                                @if($menu['tb_menu']['menu_function_id'] == 2 && $menu['tb_menu']['menu_name'] == 'component-(/access)-useraccess-create')
                                    <a 
                                        href="" type="button"
                                        class="btn btn-dark waves-effect waves-light mt-3 float-right text-white"
                                        style="background-color: #39BEAA; color: black; text-decoration: none;" data-toggle="modal"
                                        data-target="#exampleModal">Add new access</a>
                                @endif
                            @endforeach
                         @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table">
                                <thead class=" text-primary">
                                    <th>No</th>
                                    <th>Menu</th>
                                    <th>Jenis</th>
                                    <th>Created at</th>
                                    <th>Updated by</th>
                                    <th>action</th>
                                </thead>
                                <tbody>
                                    @foreach ($access as $key => $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$item->menu_name}}</td>
                                        <td>{{$item->function_name}}</td>
                                        <td>{{$item->created_at}}</td>
                                        <td>{{$item->created_by}}</td>
                                        <td style="vertical-align: middle;">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                @if(session('access_menu'))
                                                    @foreach(session('access_menu') as $key => $menu)
                                                        @if($menu['tb_menu']['menu_function_id'] == 2 && $menu['tb_menu']['menu_name'] == 'component-(/access)-useraccess-delete')
                                                            <button 
                                                                type="button" 
                                                                class="btn btn-danger" 
                                                                onclick=deletedata(<?= $item->id ?>)>
                                                                <i class="now-ui-icons ui-1_simple-remove"></i>
                                                            </button>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
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
                    <form action="{{ route('access.store') }}" method="POST" id="form-program" class="form-class"
                        name="form-name" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New role</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{-- isi --}}
                            <input type="hidden" name="role" value="{{ Request::segment(2) }}">

                            <div class="form-group">
                                <label>Jenis</label>
                                <select id="jenis" onchange="jenisnya(this);" class="form-control">
                                    <option value="">Pilih jenis</option>
                                    <option value="1">Side Bar</option>
                                    <option value="2">Component</option>
                                </select>
                            </div>

                            <div class="form-group" id="menu" style="display: none">
                                <label>Menu</label>
                                <select name="menu" class="form-control">
                                    <option value="">Pilih menu</option>
                                    @foreach ($simenu as $subs)
                                    <option value="{{ $subs->id }}">{{$subs->menu_name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" id="component" style="display: none">
                                <label>Component</label>
                                <select name="component" class="form-control">
                                    <option value="">Pilih component</option>
                                    @foreach ($component as $sub)
                                    <option value="{{$sub->id}}">{{$sub->menu_name}}
                                    </option>
                                    @endforeach
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

        <script src="{{ asset('sweetalert/sweetalert.min.js') }}"></script>

        @if(Session::has('data'))
        <script type="text/javascript">
            swal("", "Berhasil menambah access", "success");

        </script>
        @endif

        @if(Session::has('update'))
        <script type="text/javascript">
            swal("", "Berhasil mengubah user role", "success");

        </script>
        @endif

        <script type="text/javascript">
            function jenisnya(item) {
                var jenis = $("#jenis").val();
                console.log(jenis);

                if (jenis == 1) {
                    $('#menu').show();
                    $('#component').hide();
                } else {
                    $('#menu').hide();
                    $('#component').show();
                }
            }

            function deletedata(id) {
            event.preventDefault();
            swal({
                    title: "Apa Anda Yakin?",
                    text: "Access yang dihapus akan hilang ",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "{{url('/access/delete')}}/" + id,
                            type: "post",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id,
                            },
                            success: function (data) {
                                console.log(data);
                                swal({
                                    title: "Good job",
                                    text: "Access berhasil dihapus",
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
                                swal('Access gagal di hapus', 'error');
                            }
                        });
                    }
                });
        }

        </script>

        @endsection
