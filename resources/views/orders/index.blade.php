@extends('layouts.app', [
    'namePage' => 'Orders',
    'class' => 'sidebar-mini',
    'activePage' => 'Orders',
  ])

@section('content')
  <div class="panel-header panel-header-sm">
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title"> Order List </h4>



            <div> <a class="btn btn-success" href="{{ route('orders.create')}}">Add Order</a>

              <!-- Button trigger modal -->
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importModal">
                Import Order
              </button>
              <!-- Button trigger modal -->
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateModal">
                Mass Order Update
              </button>

              <!-- Button filter modal -->
              <button onclick="openFilterModal()" type="button" class="btn btn-primary" data-toggle="modal">
                Filter
              </button>
              <!-- <a href="javascript:void(0)" onclick="openFilterModal()" class="btn btn-danger waves-effect waves-light"><i class="fa fa-file-pdf-o">Filter 2</i> </a> -->
            </div>






        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>

        @endif
        <div class="card-body">
          <div class="table-responsive">
            <table id="datatable" class="table">
              <thead class=" text-primary">
                <th>
                  Date Request
                </th>
                <th>
                  AWB
                </th>
                <th>
                  Ref ID
                </th>
                <th>
                  Account Name
                </th>
                <th>
                  Service Type
                </th>

                <th>
                  Total Fee
                </th>
                <th>
                  Status
                </th>

              </thead>
              <tbody>

                @foreach ($orders as $order )
                <tr>
                  <td>{{ $order->date_requested }}</td>
                  <td>{{ $order->awb }}</td>
                  <td>{{ $order->ref_id }}</td>
                  <td>{{ $order->account_name }}</td>

                  <td>{{ $order->service_type }}</td>
                  <td>{{ $order->total_fee }}</td>
                  <td><a class="btn btn-primary" href="{{ route('orders.show',$order->awb)}}">{{ $order->order_status}}</a>
                    {{ csrf_field() }}</td>



                </tr>
                @endforeach

              </tbody>
            </table>


                <div> <a class="btn btn-success" href="{{ route('orders.export')}}">Export</a>
                </div>

            </div>
                <!-- Modal -->
                <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Upload CSV</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>

                      <div class="modal-body">
                        <form action="{{ route('orders.import') }}" method="POST" enctype="multipart/form-data">
                          {{ csrf_field() }}
                            <input type="file" name="import_file" />

                            <input type="submit" value="import" class="btn btn-primary"/>

                        </form>

                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Mass Update CSV</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>

                      <div class="modal-body">
                        <form action="{{ route('orders.importupdate') }}" method="POST" enctype="multipart/form-data">
                          {{ csrf_field() }}
                            <input type="file" name="import_update_file" />

                            <input type="submit" value="import" class="btn btn-primary"/>

                        </form>

                      </div>
                    </div>
                  </div>
                </div>




              </div>
            </div>
          </div>
        </div>
      </div>

<!-- modal filter export -->
<div class="modal fade" id="modalFilterExport" tabindex="-1" aria-labelledby="modalFilterExport" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter</h5>
                <button type="button" class="close btnClose" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="formExport" method="GET">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tanggal</label>
                        <div class="input-group input-daterange">
                            <input type="text" class="form-control" value="2012-04-05">
                            <div class="input-group-addon">to</div>
                            <input type="text" class="form-control" value="2012-04-19">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Max Page</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="max_page" value="100">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btnClose" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary btnSubmit" value="Download">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
  <script>
      $(document).ready(function() {
      $('#datatable').DataTable();
      $('#autoWidth').true();
  } );
  function openFilterModal(){
      console.log("==> hello");
      $("#modalFilterExport").modal('show');
  }

  </script>
@endpush
