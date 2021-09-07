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
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#userCreateModal">
                Create User
              </button>

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
                                
                                <form method="POST" action="{{ route('register') }}">
                                  @csrf
                                  <!--Begin input name -->
                  <div class="input-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <i class="now-ui-icons users_circle-08"></i>
                      </div>
                    </div>
                    <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" type="text" name="name" value="{{ old('name') }}" required autofocus>
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
                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" type="email" name="email" value="{{ old('email') }}" required>
                  </div>
                  @if ($errors->has('email'))
                      <span class="invalid-feedback" style="display: block;" role="alert">
                          <strong>{{ $errors->first('email') }}</strong>
                      </span>
                  @endif
                  <!--Begin input user type-->
                  
                  <!--Begin input password -->
                  <div class="input-group {{ $errors->has('password') ? ' has-danger' : '' }}">
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
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <i class="now-ui-icons objects_key-25"></i></i>
                      </div>
                    </div>
                    <input class="form-control" placeholder="{{ __('Confirm Password') }}" type="password" name="password_confirmation" required>
                  </div>
                  <!--<div class="form-check text-left">
                    <label class="form-check-label">
                      <input class="form-check-input" type="checkbox">
                      <span class="form-check-sign"></span>
                      {{ __('I agree to the') }}
                      <a href="#something">{{ __('terms and conditions') }}</a>.
                    </label>
                  </div>-->
                  <div class="card-footer ">
                    <button type="submit" class="btn btn-primary btn-round btn-lg">{{__('Create User')}}</button>
                  </div>
                </form>


                              </div>
                            </div>
                          </div>
                        </div>




              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <th>
                      Name
                    </th>
                    <th>
                      Email
                    </th>
                   <!-- <th>
                      actions
                    </th>-->
                    
                   
                  </thead>
                  <tbody>
    
                    @foreach ($users as $user )
                    <tr>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->email }}</td>
                      
                     
    
    
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
      

@endsection