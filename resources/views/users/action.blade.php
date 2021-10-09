@section('scripts')
<script src="{{ asset('sweetalert/sweetalert.min.js') }}"></script>

<script type="text/javascript">

    // adding client choice 
    function addingClientChoice(){
        
        var user_role_id = $('#user_role_id').val();
        

        // showing the client choice when the user choose user_role as customer
        if(user_role_id == 1) {
            $("#clients_id").show('slow');
        } else {
            $("#clients_id").hide('slow');
        }
        
    }

    // delete 
    function deleteUser(id) {
        
        swal({
            title: "Apa Anda Yakin?",
            text: "User yang dihapus akan hilang ",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if(willDelete) {
                // alert("are you sure delete "+id);
                
                //

                $.ajax({
                        url: "{{url('/delete_user?id=')}}" + id,
                        type: "post",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (data) {
                            console.log(data);
                            swal({
                                title: "Success",
                                text: "User berhasil dihapus",
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
                            swal('Users gagal di hapus', 'error');
                        }
                    });
                //

            }
        });
    }

    // add user 
    function addUser() {
        $('#userCreateModalLabel').text("Register User");
        $('#button-user').text("Register User");
        // obtain
        $('#userid').val("");
        $('#user_form').attr('action', "{{ route('insert_user') }}");
        $('#name').val("");
        $('#email').val("");
        $("#password").show();
        $("#password-confirm").show();
        $('#button-user-update').attr('id', 'button-user');
    }

    // view
    function editUser(
        id
    ){
        $('#userCreateModalLabel').text("User Edit");
        $('#button-user').text("Submit");

        // check data
        $.ajax({
            url: "{{url('users/checked_user?id=')}}" + id,
            type: "GET",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function (data) {

                if(data.statusCode == 200) {
                    console.log("==> this is data : ");
                    console.log(data.data);
                    let reponseData = data.data;

                    // obtain
                    $('#userid').val(id);
                    $('#name').val(reponseData.name);
                    $('#email').val(reponseData.email);
                    $("#user_role_id").val(reponseData.user_role_id).change();
                    $("#client_id").val(reponseData.clients_id).change();
                    $("#password").hide();
                    $("#password-confirm").hide();   
                    $('#button-user').attr('id', 'button-user-update');                 
                                    

                } else {
                    swal(data.message, 'error');
                }
                
            },
            error: function () {
                swal('User fetch failed, please check backend connection', 'error');
            }
        });
    }


    // $('#button-user-update').on('click', function(event){
    //     $('#user_form').attr('action', `${base_url}/update_user?id=${id}`).submit();
    // });

    $(document).on('click','#button-user-update',function(e){
        var base_url = window.location.origin;
        // var userid = $('#userid').val();
        console.log("===>>> ");
        console.log($('#userid').val());
        e.preventDefault();

        var newUrl = base_url+"/update_user?id="+$('#userid').val();
        var objData = new FormData();
        objData.append('name', $('#name').val());
        objData.append('email', $('#email').val());
        objData.append('user_role_id', $('#user_role_id').val());
        objData.append('clients_id', $('#client_id').val());
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
            
        $.ajax({
            url: newUrl,
            type: "post",
            data: objData,
            processData: false,
            contentType: false,
            success: function (data) {
                console.log(data);
                swal({
                    title: "Success",
                    text: "User berhasil diupdate",
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
                swal('Users gagal di update', 'error');
            }
        });
    }); 
</script>

@stop