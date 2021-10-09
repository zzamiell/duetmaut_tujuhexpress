@extends('layouts.app', [
    'namePage' => 'Orders',
    'class' => 'sidebar-mini',
    'activePage' => 'Orders',
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
            <h4 class="card-title"> Add Order </h4>
          </div>
          <div class="card-body">

            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }} </li>

                  @endforeach
                </ul>
              </div>
            @endif

            <form action="{{ route('orders.store')}}" method="POST">
                @csrf

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__(" Ref ID")}}</label>
                        <input type="string" name="ref_id" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                    <div class="form-group">
                        <label>{{__("Account Name")}}</label>
                        <select name="account_name" class="form-control" onchange="acc(this);" id="account">
                            <optgroup label="Pilih account name">
                                <option value=''>Pilih account name</option>
                                @foreach ($account as $kt)
                                    @if(session('user_role_id') == 1)
                                        @if(session('client_account_name') == $kt->account_name)
                                        <option value="{{$kt->id}}">{{$kt->account_name}}</option>
                                        @endif
                                    @else
                                        <option value="{{$kt->id}}">{{$kt->account_name}}</option>
                                    @endif
                                @endforeach
                            </optgroup>
                        </select>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">

                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Service Order")}}</label>
                        <select name="service_order" class="form-control" onchange="order(this);" id="service">
                            {{-- <optgroup label="Pilih service orders">
                                @foreach ($account as $kt)
                                <option value="{{$kt->id}}">{{$kt->account_name}}</option>
                                @endforeach
                            </optgroup> --}}
                        </select>
                        {{-- <input type="string" name="service_order" class=".form-control::-webkit-input-placeholder form-control" placeholder="" > --}}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Service Type")}}</label>
                        <select name="service_type" class="form-control">
                            <optgroup label="Pilih service orders">
                                <option value="">Pilih service type</option>
                                <option value="delivery">Delivery</option>
                                <option value="pickup">Pick up</option>
                            </optgroup>
                        </select>
                        {{-- <input type="string" name="service_type" class=".form-control::-webkit-input-placeholder form-control" placeholder="" > --}}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Shipper Name")}}</label>
                        <input type="string" name="shipper_name" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Shipper Phone")}}</label>
                        <input type="string" name="shipper_phone" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Shipper Address")}}</label>
                        <input type="string" name="shipper_address" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Shipper Zip Code")}}</label>
                        <select name="shipper_postal_code" class="form-control" onchange="shipper_code(this);" id="ship_code">
                            {{-- <optgroup label="Pilih service orders">
                                @foreach ($account as $kt)
                                <option value="{{$kt->id}}">{{$kt->account_name}}</option>
                                @endforeach
                            </optgroup> --}}
                        </select>
                        {{-- <input type="string" name="shipper_postal_code" class=".form-control::-webkit-input-placeholder form-control" placeholder="" > --}}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Shipper Area")}}</label>
                        <input type="string" name="shipper_area" class=".form-control::-webkit-input-placeholder form-control" placeholder="" id="ship_area">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Shipper District")}}</label>
                        <input type="string" name="shipper_district" class=".form-control::-webkit-input-placeholder form-control" placeholder="" id="ship_district">
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("recipient Name")}}</label>
                        <input type="string" name="recipient_name" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("recipient Phone")}}</label>
                        <input type="string" name="recipient_phone" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("recipient Address")}}</label>
                        <input type="string" name="recipient_address" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("recipient Zip Code")}}</label>
                        <select name="recipient_postal_code" class="form-control" onchange="recip_code(this);" id="recipt_code">
                            {{-- <optgroup label="Pilih service orders">
                                @foreach ($account as $kt)
                                <option value="{{$kt->id}}">{{$kt->account_name}}</option>
                                @endforeach
                            </optgroup> --}}
                        </select>
                        {{-- <input type="string" name="recipient_postal_code" class=".form-control::-webkit-input-placeholder form-control" placeholder="" > --}}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("recipient Area")}}</label>
                        <input type="string" name="recipient_area" class=".form-control::-webkit-input-placeholder form-control" placeholder="" id="recipt_area">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("recipient District")}}</label>
                        <input type="string" name="recipient_district" class=".form-control::-webkit-input-placeholder form-control" placeholder="" id="recipt_district">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Weight")}}</label>
                        <input type="string" name="weight" id="berat" onkeyup="deliv(this);" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Value of Goods")}}</label>
                        <input type="string" name="value_of_goods" id="value_of_goods" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <!--<div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Status")}}</label>
                        <input type="string" name="order_status" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>-->

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Insured?")}}</label>
                        <select name="is_insured" id="insured_gak" onchange="insured(this);" class="form-control">
                            {{-- <optgroup label="Apakah ingin menggunakan asuransi ?"> --}}
                                <option value="">Apakah ingin menggunakan asuransi ?</option>
                                <option value="ya">Ya</option>
                                <option value="tidak">Tidak</option>
                            {{-- </optgroup> --}}
                        </select>
                        {{-- <input type="string" name="is_insured" class=".form-control::-webkit-input-placeholder form-control" placeholder="" > --}}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Cod?")}}</label>
                        <select name="is_cod" id="cod_gak" onchange="cod(this);" class="form-control">
                            {{-- <optgroup label="Apakah ingin menggunakan asuransi ?"> --}}
                                <option value="">Apakah ingin cod ?</option>
                                <option value="ya">Ya</option>
                                <option value="tidak">Tidak</option>
                            {{-- </optgroup> --}}
                        </select>
                        {{-- <input type="string" name="is_cod" class=".form-control::-webkit-input-placeholder form-control" placeholder="" > --}}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Delivery Fee")}}</label>
                        <input type="string" name="delivery_fee" id="dfee" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("COD Fee")}}</label>
                        <input type="string" name="cod_fee" id="cod_fee" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Insurance Fee")}}</label>
                        <input type="string" name="insurance_fee" id="insurance_fee" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 pr-1">
                    <div class="form-group">
                        <label>{{__("Total Fee")}}</label>
                        <input type="string" name="total_fee" id="total" class=".form-control::-webkit-input-placeholder form-control" placeholder="" >
                    </div>
                </div>
            </div>

            <input type="hidden" name="" id="id_client">
            <input type="hidden" name="" id="theprice">

                 <div class="right">
                <button type="submit" class="btn btn-primary">Submit</button>

              </div>

          </div>
      </form>


          </div>
        </div>
      </div>

      </div>
    </div>
  </div>
  <script type="text/javascript">
   function acc(item) {
        var id_acc = $("#account").val();
        console.log("account name id : " + id_acc);
        $('#id_client').val(id_acc);
        $.ajax({
            url: "{{url('/serviceByaccount')}}/" + id_acc,
            success: function (data) {
                var json = data,
                obj = JSON.parse(json);
                console.log(obj);
                var _items = '';
                _items = "<option value=''>Pilh service order</option>";
                $.each(obj, function (k, v) {
                    _items += "<option value='" + v.service_order + "'>" + v.service_order + "</option>";
                });
                $('#service').html(_items);
            }
        });
    }

    function order(item){
        var service = $("#service").val();
        console.log("servicenya  : " + service);

        var id_acc = $("#account").val();
        console.log("acc_id : " + id_acc);

        $.ajax({
            url: "{{url('/kode_zip')}}/" + service + "/" + id_acc,
            success: function (data) {
                var json = data,
                obj = JSON.parse(json);
                console.log(obj);
                var _items = '';
                _items = "<option value=''>Pilh postal code</option>";
                $.each(obj, function (k, v) {
                    _items += "<option value='" + v.postal_code +'-'+ v.id+"'>" + v.postal_code + "</option>";
                });
                $('#recipt_code').html(_items);
                $('#ship_code').html(_items);
            }
        });
    }

    function shipper_code(item) {
        var ship_code = $("#ship_code").val();
        var the_code = ship_code.split("-");
        console.log("ship_code  : " + the_code[0]);

        $.ajax({
            url: "{{url('/shipper_detail')}}/" + the_code[0],
            success: function (data) {
                var json = data,
                obj = JSON.parse(json);

                $('#ship_area').val(obj[0].area_name);
                $('#ship_district').val(obj[0].district_name);
            }
        });
    }

    function recip_code(item) {
        var recipt_code = $("#recipt_code").val();
        var the_code = recipt_code.split("-");
        var id_client = $("#id_client").val();
        console.log("recipt_code  : " + the_code[0]);
        console.log("id_pricing  : " + the_code[1]);
        $.ajax({
            url: "{{url('/recipt_detail')}}/" + the_code[0],
            success: function (data) {
                var json = data,
                obj = JSON.parse(json);

                $('#recipt_area').val(obj[0].area_name);
                $('#recipt_district').val(obj[0].district_name);

                // ajak untuk dapatkan pricing
                $.ajax({
                    url: "{{url('/get_pricing')}}/" + the_code[1],
                    success: function (data) {
                        var json = data,
                        obj = JSON.parse(json);
                        $('#theprice').val(obj.pricing);
                    }
                });
                // end ajax
            }
        });
    }

    function cod(item) {
        var is_cod = $("#cod_gak").val();
        var id_client = $("#id_client").val();
        var valueofgood = $("#value_of_goods").val();

        if (is_cod == "ya") {
        $.ajax({
            url: "{{url('/cod_fee')}}/" + id_client,
            success: function (data) {
                var json = data,
                obj = JSON.parse(json);
                var codnya = parseInt(obj.cod_fee);
                var valofgod = parseInt(valueofgood);
                var hasil = valofgod * codnya / 100;

                $('#cod_fee').val(hasil);

                var delivery_fee = $("#dfee").val();
            var cod = $("#cod_fee").val();
            var insurance = $("#insurance_fee").val();

            var res = parseInt(delivery_fee) + parseInt(cod) + parseInt(insurance);
            $('#total').val(res);
            }
        });
        }else{
            $('#cod_fee').val(0);

            var delivery_fee = $("#dfee").val();
            var cod = $("#cod_fee").val();
            var insurance = $("#insurance_fee").val();

            var res = parseInt(delivery_fee) + parseInt(cod) + parseInt(insurance);
            $('#total').val(res);
        }

    }

    function insured(item) {
        var is_insured = $("#insured_gak").val();
        var id_client = $("#id_client").val();
        var valueofgood = $("#value_of_goods").val();

        if (is_insured == "ya") {
        $.ajax({
            url: "{{url('/insured_fee')}}/" + id_client,
            success: function (data) {
                var json = data,
                obj = JSON.parse(json);
                var ins = parseInt(obj.insurance_fee);
                var valofgod = parseInt(valueofgood);
                var hasil = valofgod * ins / 100;

                $('#insurance_fee').val(hasil);
            }
        });
        }else{
            $('#insurance_fee').val(0);
        }

    }

    function deliv(item) {
        var weight = $("#berat").val();
        var berat = Math.ceil(weight);
        var price = $("#theprice").val();

        var res = parseInt(berat) * parseInt(price);
        $('#dfee').val(res);
    }
  </script>
@endsection
