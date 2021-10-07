@extends('layouts.app', [
'namePage' => 'menu',
'class' => 'sidebar-mini',
'activePage' => 'menu',
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
                        <h3 class="float-left mt-3">Manage menu role access</h3>
                        <a href="" type="button"
                            class="btn btn-dark waves-effect waves-light mt-3 float-right text-white"
                            style="background-color: #39BEAA; color: black; text-decoration: none;" data-toggle="modal"
                            data-target="#exampleModal">Add new menu</a>
                    </div>
                    <br>
                    <div class="card-body">
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6">
                                <form action="/menu/index" method="get">
                                    {{ csrf_field() }}
                                    <div class="input-group mb-3">
                                        <input type="text" name="cari" class="form-control" placeholder="orders">
                                        <div class="input-group-append">
                                            <input type="submit" class="input-group-text" id="basic-addon2"
                                                value="Cari Menu Name">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <th>No</th>
                                    <th>Menu name</th>
                                    <th>Url</th>
                                    <th>Icon</th>
                                    <th>Menu Function</th>
                                    <th>action</th>
                                </thead>
                                <tbody>
                                    @foreach ($menu as $key => $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$item->menu_name}}</td>
                                        <td>{{$item->url}}</td>
                                        <td>{{$item->icon}}</td>
                                        <td>{{$item->function_name}}</td>
                                        <td style="vertical-align: middle;">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                {{-- @if(session('access_menu'))
                                        @foreach(session('access_menu') as $key => $menu)
                                            @if($menu['tb_menu']['menu_function_id'] == 2 && $menu['tb_menu']['menu_name'] == 'userrole-update') --}}
                                                <a href="#" data-toggle="modal" data-target="#exampleModal{{$item->id}}"
                                                    type="button" class="btn"><i
                                                        class="now-ui-icons ui-1_zoom-bold"></i></a>
                                                {{-- @endif --}}

                                                {{-- @if($menu['tb_menu']['menu_function_id'] == 2 && $menu['tb_menu']['menu_name'] == 'userrole-delete') --}}
                                                <button type="button" class="btn btn-danger"
                                                    onclick=deletedata(<?= $item->id ?>)><i
                                                        class="now-ui-icons ui-1_simple-remove"></i></button>
                                                {{-- @endif
                                        @endforeach
                                    @endif --}}
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal isi tambah menu -->
                                    <div class="modal fade" id="exampleModal{{$item->id}}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('menu.update') }}" method="POST" id="form-program"
                                                    class="form-class" name="form-name" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">New menu</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{-- isi --}}
                                                        <input type="hidden" name="id" value="{{$item->id}}">

                                                        <div class="form-group">
                                                            <label>Menu name</label>
                                                            <input type="text" name="menu_name" class="form-control" value="{{$item->menu_name}}"
                                                                required />
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Url</label>
                                                            <input type="text" name="url" class="form-control" value="{{$item->url}}"
                                                                required />
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Icon</label>
                                                            <input type="text" name="icon" class="form-control" value="{{$item->icon}}"
                                                                required />
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Menu parent</label>
                                                            <select name="parent" class="form-control">
                                                                <option value="0">Tentukan menu dari submenu</option>
                                                                @foreach ($submenu as $sub)
                                                                <option value="{{$sub->id}}" @if ($sub->id == $item->menu_parent_id) selected @endif>{{$sub->menu_name}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Menu function</label>
                                                            <select name="menu_functuin" class="form-control">
                                                                <option value="0">Pilih fungsi menu</option>
                                                                @foreach ($reff as $ref)
                                                                <option value="{{$ref->id}}" @if ($ref->id == $item->menu_function_id) selected @endif>{{$ref->function_name}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        {{-- end isi --}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit"
                                                            class="btn text-white btn-success">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                            <hr>
                            <div class="text-center">
                                {{$menu->links("pagination::bootstrap-4")}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal isi tambah menu -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form action="{{ route('menu.store') }}" method="POST" id="form-program" class="form-class"
                        name="form-name" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New menu</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{-- isi --}}
                            <div class="form-group">
                                <label>Menu name</label>
                                <input type="text" name="menu_name" class="form-control" required />
                            </div>

                            <div class="form-group">
                                <label>Url</label>
                                <input type="text" name="url" class="form-control" required />
                            </div>

                            <div class="form-group">
                                <label>Icon</label>
                                <input type="text" name="icon" class="form-control" required />
                            </div>

                            <div class="form-group">
                                <label>Menu parent</label>
                                <select name="parent" class="form-control">
                                    <option value="0">Tentukan menu dari submenu</option>
                                    @foreach ($submenu as $sub)
                                    <option value="{{$sub->id}}">{{$sub->menu_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Menu function</label>
                                <select name="menu_functuin" class="form-control">
                                    <option value="0">Pilih fungsi menu</option>
                                    @foreach ($reff as $ref)
                                    <option value="{{$ref->id}}">{{$ref->function_name}}</option>
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
            swal("", "Berhasil tambah menu", "success");

        </script>
        @endif

        @if(Session::has('update'))
        <script type="text/javascript">
            swal("", "Berhasil mengubah menu", "success");

        </script>
        @endif

        <script type="text/javascript">

            function deletedata(id) {
            event.preventDefault();
            swal({
                    title: "Apa Anda Yakin?",
                    text: "Menu yang dihapus akan hilang ",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "{{url('/menu/delete-menu')}}/" + id,
                            type: "post",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id,
                            },
                            success: function (data) {
                                console.log(data);
                                swal({
                                    title: "Good job",
                                    text: "Menu berhasil dihapus",
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
                                swal('Menu gagal di hapus', 'error');
                            }
                        });
                    }
                });
        }
    </script>

        @endsection
