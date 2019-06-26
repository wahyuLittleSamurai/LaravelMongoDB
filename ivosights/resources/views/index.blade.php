<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Index Page</title>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>       
        <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>       
        <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>       
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}"> 
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>

        <style>
            .modal {
                z-index: 10000;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h3 align="center">Database Recruitment</h3>
            <br />
            <div align="left">
            <button type="button" name="add" id="add_data" class="btn btn-success btn-sm">Add</button>
        </div>
        <br />
        <table class="table" id="tableUser">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
        <div id="studentModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" id="student_form">
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <span id="form_output"></span>
                            <div class="form-group">
                                <label>Enter First Name</label>
                                <input type="text" name="firstName" id="firstName" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>Enter Last Name</label>
                                <input type="text" name="lastName" id="lastName" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" id="email" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="address" id="address" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>Contact</label>
                                <input type="text" name="contact" id="contact" class="form-control" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id" id="id" value="" />
                            <input type="hidden" name="button_action" id="button_action" value="insert" />
                            <input type="submit" name="submit" id="action" value="Add" class="btn btn-info" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $(function() {
                var oTable = $('#tableUser').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                    url: '{{ url("dataUser") }}'
                },
                columns: [
                    {data: '_id', name: '_id'},
                    {data: 'firstName', name: 'firstName'},
                    {data: 'lastName', name: 'lastName'},
                    {data: 'email', name: 'email'},
                    {data: 'address', name: 'address'},
                    {data: 'contact', name: 'contact'},
                    {data: 'action', orderable:false, searchable: false},
                ],
            })
        });
        $(document).on('click', '.edit', function(){
            var id = $(this).attr("id");
            $('#form_output').html('');
            $.ajax({
                url:"{{ route('ajaxdata.fetchdata') }}",
                method:'GET',
                data:{id:id},
                dataType:'json',
                success:function(data)
                {
                    $('#id').val(data.id);
                    $('#firstName').val(data.firstName);
                    $('#lastName').val(data.lastName);
                    $('#email').val(data.email);
                    $('#address').val(data.address);
                    $('#contact').val(data.contact);
                    $('#userId').val(id);
                    $('#studentModal').modal('show');
                    $('#action').val('Edit');
                    $('.modal-title').text('Edit Data');
                    $('#button_action').val('update');
                }
            });
        });
        $(document).on('click', '.delete', function(){
            var id = $(this).attr("id");
            if(confirm("Are you sure you want to Delete this data?"))
            {
                $.ajax({
                    url:"{{route('ajaxdata.removedata')}}",
                    mehtod:'GET',
                    data:{ id:id },
                    success:function(data)
                    {
                        alert(data);
                        $('#tableUser').DataTable().ajax.reload();
                    }
                })
            }
            else
            {
                return false;
            }
        });

        $('#add_data').click(function(){
            $('#studentModal').modal('show');
            $('#student_form')[0].reset();
            $('#form_output').html('');
            $('#button_action').val('insert');
            $('#action').val('Add');
            $('.modal-title').text('Add Data');
        });

        $('#student_form').on('submit', function(event){
            event.preventDefault();
            var form_data = $(this).serialize();
            $.ajax({
                url:"{{ route('ajaxdata.postdata') }}",
                method:'POST',
                data:form_data,
                dataType:"json",
                success:function(data)
                {
                    if(data.error.length > 0)
                    {
                        var error_html = '';
                        for(var count = 0; count < data.error.length; count++)
                        {
                            error_html += '<div class="alert alert-danger">'+data.error[count]+'</div>';
                        }
                        $('#form_output').html(error_html);
                    }
                    else
                    {
                        $('#form_output').html(data.success);
                        $('#student_form')[0].reset();
                        $('#action').val('Add');
                        $('.modal-title').text('Add Data');
                        $('#button_action').val('insert');
                        $('#tableUser').DataTable().ajax.reload();
                    }
                }
                });
            });
        });
    </script>
    </body>
</html>