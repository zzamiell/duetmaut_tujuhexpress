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
                  <td><a class="btn btn-primary" href="{{ route('orders.show',$order->id)}}">{{ $order->order_status}}</a>
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


@endsection
@push('js')
  <script>
    $(document).ready(function() {
    $('#datatable').DataTable();
    $('#autoWidth').true();

} );
  </script>
@endpush
