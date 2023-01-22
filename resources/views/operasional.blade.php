@extends('template')

@section('konten')
    <h4>Halo admin <b>{{Auth::user()->username}},</b> Role anda : <b>{{Auth::user()->role}}</b></h4>

    <br><br>
    <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-primary card-outline">
                            <div class="card-body">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add"> Tambahkan User </button>

                            <br><br>
                            @csrf
                            <table class="table table-bordered datatables">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="add">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title">Tambah User</label>
                </div>

                <div class="modal-body">
                    <form id="upload" method="POST" enctype="multipart/form-data">
                        <ul id="updateForm_errList"></ul>
                        <input type="hidden" id="id">

                        <div class="form-group">
                            <label for="username">username </label>
                            <input type="text" class="form-control" name="username" id="username" placeholder="Masukkan username">
                        </div>
                        <div class="form-group">
                            <label for="email">email </label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Masukkan email">
                        </div>
                        <div class="form-group">
                            <label class="mb-1"> Foto Profil</label>
                            <input type="file" class="form-control" name="image" placeholder="Choose image" id="image">
                        </div>
                        <div class="form-group">
                            <label for="password">Password </label>
                            <input type="text" class="form-control" name="password" id="password" placeholder="Masukkan password">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary reset">Reset</button>
                    <button type="button" class="btn btn-primary create">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="updateUser">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <label class="modal-title">Update User</label>
                </div>
                <form id="updateForm" action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <ul id="updateForm_errList"></ul>
                        <input type="hidden" id="id">

                        <div class="form-group">
                            <label for="username">Username </label>
                            <input type="text" class="form-control" name="username" id="username">
                        </div>
                        <div class="form-group">
                            <label for="email">email </label>
                            <input type="text" class="form-control" name="email" id="email">
                        </div>
                        <div class="form-group">
                            <label class="mb-1"> Foto Profil</label>
                            <input type="file" class="form-control" name="image" placeholder="Choose image" id="image">
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary update">Update</button>
                    <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function() {
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('.datatables').DataTable({
                autoWidth: false,
                processing: true,
                serverSide: true,
                ajax: "{{ route('operasional.index') }}",
                method: 'GET',
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', width: '5%'},
                    {data: 'username', name: 'title'},
                    {data: 'email', name: 'email'},
                    {data: 'role', name: 'role'},
                    {data: 'action', name: 'action'},
                ],
                order: [
                    [0, 'desc'],
                ],
            });
        });

        function readImage(input){
            if(input.files && input.files[0]){
                var reader = new FileReader();

                reader.onload = function (e){
                    $('#preview-image').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $('#image').change(function () {
            readImage(this);
        });

        $(document).ready(function () {
            $(".reset").click( function(){
                $('#username').val("");
                $('#email').val("");
                $('#password').val("");
            });

            $(document).on('click', '.create', function (e) {
                e.preventDefault();

                let formData = new FormData($('#upload')[0]);

                $(this).removeData();

                $.ajax({
                    type: "POST",
                    url: "{{ route('operasional.store') }}",
                    data: formData,
                    dataType: "json",
                    success: function(response){
                        if(response.status == 400){
                            $('#saveForm_errList').html("");
                            $('#saveForm_errList').addClass('alert alert-danger');
                            $.each(response.errors, function(key, err_values) {
                                $('#saveForm_errList').append('<li>'+err_values+'</li>');
                            });
                        }else if(response.status == 200)
                        {
                            $('#saveForm_errList').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.messages);
                            $('#add').modal('hide');
                            // $('#addCompany').modal('show');
                            $('#add').find("input").val("");
                            $('.modal-backdrop').remove();
                            var table = $('.datatables').DataTable();
                            table.ajax.reload();
                        }
                    }
                });
            });
        });

        //edit
        $(document).on('click', '.updateUser', function (e){

            e.preventDefault();

            var id = $(this).data('id');

            $('#updateUser').modal('show');

            $.ajax({
                type: "GET",
                url: "{{ route('operasional.index') }}" + '/' + id + '/edit',
                success: function(response){
                    if (response.status == 404) {
                        $('#updateForm_errList').addClass('alert alert-success');
                        $('#updateForm_errList').text(response.message);
                        $('.updateUser').modal('hide');
                    }
                    else
                    {
                        $('#btnDelete').html(response.html)
                        $(".reset-update").click( function(){
                            $('#updateForm').find('#title').val("");
                            $('#updateForm').find('#notes').val("");
                        });
                        $("#id").val(id);
                        $('#updateUser').find("#username").val(response.operasional.username);
                        $('#updateUser').find("#email").val(response.operasional.email);
                    }
                }
            })
        });

        $(document).on('click', '.update', function(e) {
            e.preventDefault();

            $(this).text('Memperbaharui...');

            var id = $('#id').val();
            console.log(id)

            let formData = new FormData($('#updateForm')[0]);
            console.log(formData)

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "/operasional/" + id,
                method: 'POST',
                data:
                formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(response){
                    if(response.status == 400)
                    {
                        $('#updateForm_errList').html("");
                        $('#updateForm_errList').addClass('alert alert-danger');
                        $.each(response.errors, function (key, err_value) {
                            $('#updateForm_errList').append('<li>'+err_value+'</li>');
                        });
                        $('.update').text('update');
                    }
                    else
                    {
                        $('#updateForm_errList').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.messages);
                        $('#updateDiary').find('input').val('');
                        $('.update').text('update');
                        $('#updateDiary').modal('hide');
                        $('.modal-backdrop').remove();
                        var table = $('.datatables').DataTable();
                        table.ajax.reload();
                        location.reload(); //untuk auto refresh halaman
                    }
                }
            })
        })

        
    </script>
@endsection