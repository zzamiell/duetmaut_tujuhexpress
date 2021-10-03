@extends('layouts.app', [
    'namePage' => 'Menu Management',
    'class' => 'sidebar-mini',
    'activePage' => 'Menu Management',
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
                <a href="" type="button"
                    class="btn btn-dark waves-effect waves-light mt-3 float-right text-white"
                    style="background-color: #39BEAA; color: black; text-decoration: none;" data-toggle="modal" data-target="#exampleModal">Add new access</a>
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
                      </tbody>
                    </table>
                  </div>
            </div>
          </div>
        </div>
      </div>
<script src="{{ asset('sweetalert/sweetalert.min.js') }}"></script>

@if(Session::has('data'))
<script type="text/javascript">
  swal("", "Berhasil tambah data client", "success");
</script>
@endif
@endsection
