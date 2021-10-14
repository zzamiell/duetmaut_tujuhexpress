@extends('layouts.app', [
    'namePage' => 'users',
    'class' => 'sidebar-mini',
    'activePage' => 'users',
  ])

@section('content')
  <div class="panel-header panel-header-sm">
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title"> Users </h4>
            <div class="card-body">
              <!-- Button trigger modal -->
              @if(session('access_menu'))
                @foreach(session('access_menu') as $menu)
                  @if($menu['tb_menu']['menu_function_id'] == 2 && $menu['tb_menu']['menu_name'] == 'component-(/user)-users-create')
                  <button
                    type="button"
                    class="btn btn-primary"
                    data-toggle="modal"
                    data-target="#userCreateModal"
                    onclick="addUser()"
                    >
                    Create User
                  </button>
                  @endif
                @endforeach
              @endif


                        <!-- Modal -->
                        <div class="modal fade" id="userCreateModal" tabindex="-1" role="dialog" aria-labelledby="userCreateModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="userCreateModalLabel">User Registration</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>

                              <div class="modal-body">

                                <form method="POST" action="{{ route('insert_user') }}" enctype="multipart/form-data" id="user_form">
                                  @csrf
                                  <!--Begin input name -->
                                  <div class="input-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text">
                                        <i class="now-ui-icons users_circle-08"></i>
                                      </div>
                                    </div>
                                    <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" type="text" name="name" value="{{ old('name') }}" required autofocus id="name">
                                    @if ($errors->has('name'))
                                      <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                      </span>
                                    @endif
                                  </div>

                                  <!--Begin input email -->
                                  <div class="input-group {{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text">
                                        <i class="now-ui-icons ui-1_email-85"></i>
                                      </div>
                                    </div>
                                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" type="email" name="email" value="{{ old('email') }}" id="email" required>
                                  </div>
                                  @if ($errors->has('email'))
                                      <span class="invalid-feedback" style="display: block;" role="alert">
                                          <strong>{{ $errors->first('email') }}</strong>
                                      </span>
                                  @endif
                                  <!--Begin input user type-->

                                  <!-- user role -->
                                  <div class="form-group">
                                      <select
                                        name="user_role_id"
                                        class="form-control"
                                        id="user_role_id"
                                        onchange="addingClientChoice();"
                                        >
                                          <optgroup label="Pilih User Role">
                                              @foreach($reff_user_role as $user_role )
                                               <option value="{{$user_role->id}}">{{$user_role->user_role_name}}</option>
                                              @endforeach
                                          </optgroup>
                                      </select>
                                  </div>

                                  <!-- clients -->
                                  <div class="form-group" id="clients_id">
                                      <select
                                        name="clients_id"
                                        class="form-control"
                                        id="client_id"
                                        >
                                          <optgroup label="Pilih Client">
                                              @foreach($clients as $client )
                                               <option value="{{$client->id}}">{{$client->id}} - {{$client->account_name}}</option>
                                              @endforeach
                                          </optgroup>
                                      </select>
                                  </div>

                                  <!--Begin input password -->
                                  <div  id="password" class="input-group {{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text">
                                        <i class="now-ui-icons objects_key-25"></i>
                                      </div>
                                    </div>
                                    <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" type="password" name="password" required>
                                    @if ($errors->has('password'))
                                      <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                      </span>
                                    @endif
                                  </div>

                                  <!--Begin input confirm password -->
                                  <div class="input-group" id="password-confirm">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text">
                                        <i class="now-ui-icons objects_key-25"></i></i>
                                      </div>
                                    </div>
                                    <input class="form-control" placeholder="{{ __('Confirm Password') }}" type="password" name="password_confirmation" required>
                                  </div>

                                  <input class="form-control" name="userid" id="userid" hidden>

                                  <div class="modal-footer ">
                                    <button id="button-user" type="submit" class="btn btn-primary btn-round btn-md">Register User</button>
                                  </div>
                              </form>


                              </div>
                            </div>
                          </div>
                        </div>




              <div class="table-responsive">
                @csrf
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                      User Id
                    </th>
                    <th>
                      Name
                    </th>
                    <th>
                      Email
                    </th>
                    <th>
                      User Role
                    </th>
                    <th colspan="2">
                      Actions
                    </th>


                  </thead>
                  <tbody>

                    @foreach ($users as $user )
                    <tr>
                      <td>{{ $user->id }}</td>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->email }}</td>
                      <td>{{ $user->user_role_name }}</td>
                      <td>
                        <button
                            type="button"
                            class="btn btn-warning"
                            onclick="editUser({{$user->id}});"
                            data-toggle="modal"
                            data-target="#userCreateModal"
                            >
                            <i class="now-ui-icons ui-1_settings-gear-63"></i>
                        </button>
                        <button
                            type="button"
                            class="btn btn-danger"
                            onclick="deleteUser({{$user->id}});"
                            >
                            <i class="now-ui-icons ui-1_simple-remove"></i>
                        </button>
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
            </div>
          </div>
        </div>
      </div>

@include('users.action')
@endsection
