<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>
<body>
    <h2 class="m-2 text-center">Item</h2>

    <div class="container" id="items-list">
        <div class="row">
            <div class="w-100 d-flex justify-content-end">
                <button class="btn btn-primary btn-add" data-toggle="modal" data-target="#modalAdd">add</button>
            </div>
        </div>
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Item</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <!-- modal delete -->
    <div class="modal fade" id="modalDel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <h6>Apakah anda ingin menghapus data ini?</h6>
                        <input type="hidden" id="data_id" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger btn-delete">Delete</button>
            </div>
            </div>
        </div>
    </div>
    <!--  -->

    <!-- modal Add -->
    <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Nama Item</label>
                        <input type="text" id="name" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-simpan-add">Save changes</button>
            </div>
            </div>
        </div>
    </div>
    <!--  -->

    <!-- modal edit -->
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Nama Item</label>
                        <input type="text" id="name" class="form-control">
                        <input type="hidden" id="data_id" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-simpan-edit">Save changes</button>
            </div>
            </div>
        </div>
    </div>
    <!--  -->

    <script>
        function getItems() {
            $.ajax({
                url: '/api/items',
                method: 'GET',
                success: function(response) {
                    $('tbody').html('');
                    let no=0;
                    $.each(response,function(i,v){
                        console.log(no);
                        no++
                        $('tbody').append(' <tr>\
                            <th scope="row">'+no+'</th>\
                            <td>'+v.name+'</td>\
                            <td> <button class="btn btn-secondary btn-edit" data-nama="'+v.name+'" data-id="'+v.id+'" data-toggle="modal" data-target="#modalEdit">Edit</button>  <button class="btn btn-danger btn-delete" data-id="'+v.id+'" data-toggle="modal" data-target="#modalDel">delete</button> </td>\
                        </tr>');
                    })
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
        
        
        //edit
            $('tbody').on('click','.btn-edit',function(){
                let nama_item=$(this).data('nama');
                let data_id=$(this).data('id');

                $('#modalEdit').find('#name').val(nama_item);
                $('#modalEdit').find('#data_id').val(data_id);
            });

            $('.btn-simpan-edit').on('click', function () {
                let nama=$('#modalEdit').find('#name').val();
                let id=$('#modalEdit').find('#data_id').val();

                $.ajax({
                url: 'api/items/'+id, 
                type: 'PATCH', 
                data: { name: nama }, 
                success: function (response) {
                    console.log('Update berhasil:', response);
                    getItems();
                    $('#modalEdit').modal('hide');
                },
                error: function (error) {
                    console.error('Gagal melakukan update:', error);
                }
                });
            });

            $('#modalEdit').on('hidden.bs.modal', function () {
                $('#modalEdit').find('#name').val('');
                $('#modalEdit').find('#data_id').val('');
            });
        //

        //delete
            $('tbody').on('click','.btn-delete',function(){
                let data_id=$(this).data('id');
                $('#modalDel').find('#data_id').val(data_id);
            });

            $('.btn-delete').on('click', function () {
                let nama=$('#modalDel').find('#name').val();
                let id=$('#modalDel').find('#data_id').val();

                $.ajax({
                url: 'api/items/'+id, 
                type: 'DELETE', 
                success: function (response) {
                    console.log('Delete berhasil:', response);
                    getItems();
                    $('#modalDel').modal('hide');
                },
                error: function (error) {
                    console.error('Gagal melakukan Delete:', error);
                }
                });
            });

            $('#modalDel').on('hidden.bs.modal', function () {
                $('#modalDel').find('#data_id').val('');
            });
        //

        //create
            $('.btn-simpan-add').on('click', function () {
                let nama=$('#modalAdd').find('#name').val();

                $.ajax({
                url: 'api/items', 
                type: 'POST', 
                data: { name: nama }, 
                success: function (response) {
                    console.log('Add berhasil:', response);
                    getItems();
                    $('#modalAdd').modal('hide');
                },
                error: function (error) {
                    console.error('Gagal melakukan Add:', error);
                }
                });
            });

            $('#modalAdd').on('hidden.bs.modal', function () {
                $('#modalAdd').find('#name').val('');
            });
        //

        $(document).ready(function() {
            getItems();

        });
    </script>
</body>
</html>