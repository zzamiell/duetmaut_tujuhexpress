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

               <!-- Button trigger modal -->
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#filterModal">
                Filter
              </button>
              <div> <a class="btn btn-success" href="{{ route('orders.export')}}">Export</a>
              </div>
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

                <!-- Modal -->
                <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="filterModalLabel">Filter Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>

                      <div class="modal-body">
                        <form action="{{ route('orders.filter') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <!--Begin input tanggal pembuatan awal -->
                            <div class="input-group {{ $errors->has('tanggal_awal') ? ' has-danger' : '' }}">
                              <div class="input-group-prepend">
                                <div class="input-group-text">
                                  <i class="now-ui-icons arrows-1_minimal-down"></i>
                                </div>
                              </div>
                              <input class="form-control {{ $errors->has('tanggal_awal') ? ' is-invalid' : '' }}" placeholder="{{ __('Tanggal Awal Pembuatan (yyyy-MM-dd)') }}" type="date" name="tanggal_awal" value="{{ old('tanggal_awal') }}" required autofocus>
                              @if ($errors->has('tanggal_awal'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                  <strong>{{ $errors->first('tanggal_awal') }}</strong>
                                </span>
                              @endif
                            </div>

                            <!--Begin input tanggal pembuatan akhir -->
                            <div class="input-group {{ $errors->has('tanggal_akhir') ? ' has-danger' : '' }}">
                              <div class="input-group-prepend">
                                <div class="input-group-text">
                                  <i class="now-ui-icons arrows-1_minimal-up"></i>
                                </div>
                              </div>
                              <input class="form-control {{ $errors->has('tanggal_akhir') ? ' is-invalid' : '' }}" placeholder="{{ __('Tanggal Akhir Pembuatan (yyyy-MM-dd)') }}" type="date" name="tanggal_akhir" value="{{ old('tanggal_akhir') }}" required autofocus>
                              @if ($errors->has('tanggal_akhir'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                  <strong>{{ $errors->first('tanggal_akhir') }}</strong>
                                </span>
                              @endif
                            </div>

                            <div class="form-group">
                              <label for="exampleFormControlSelect1">Order Status</label>
                              <select name="order_status" class="form-control" id="exampleFormControlSelect1">
                                <option value="all">All</option>
                                <option value="info_received">Info Received</option>
                                <option value="pending">Pending</option>
                                <option value="in_transit">In Transit</option>
                                <option value="completed">Completed</option>
                                <option value="fail_shipper">Fail Shipper</option>
                                <option value="fail_courier">Fail Courier</option>
                                <option value="fail_recipient">Fail Recipient</option>
                                <option value="fail_attempt_1">Faile Attempt</option>
                              </select>
                            </div>

                            <input type="submit" value="check" class="btn btn-primary"/>

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
  function openFilterModal(){
      console.log("==> hello");
      $("#filterModalLabel").modal('show');
  }

  $(document).ready(function(){
            setDatePicker()
            setDateRangePicker(".startdate", ".enddate")
            setMonthPicker()
            setYearPicker()
            setYearRangePicker(".startyear", ".endyear")
  })

  </script>
@endpush
