<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>CRUD - Data Barang</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
</head>
<body>
<div class="container mt-2">
<div class="row">
<div class="col-lg-12 margin-tb">
<div class="pull-left">
<h2>Data Barang</h2>
</div>
<div class="pull-right mb-2">
<a class="btn btn-primary" onClick="add()" href="javascript:void(0)"> Add Barang</a>
</div>
</div>
</div>
@if ($message = Session::get('success'))
<div class="alert alert-success">
<p>{{ $message }}</p>
</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="card-body">
<table class="table table-bordered" id="ajax-crud-datatable">
<thead>
<tr>
<th>Id</th>
<th>Foto Barang</th>
<th>Nama Barang</th>
<th>Harga Beli</th>
<th>Harga Jual</th>
<th>Stok</th>
<th>Created at</th>
<th>Action</th>
</tr>
</thead>
</table>
</div>
</div>
<!-- boostrap company model -->
<div class="modal fade" id="company-modal" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="CompanyModal"></h4>
</div>
<div class="modal-body">
<form action="javascript:void(0)" id="CompanyForm" name="CompanyForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
<input type="hidden" name="id" id="id">
<div class="form-group">
<label for="name" class="col-sm-2 control-label">Foto Barang</label>
<div class="col-sm-12">
<input type="file" class="form-control" id="foto" name="foto" required="">
</div>
</div>  
<div class="form-group">
<label for="name" class="col-sm-2 control-label">Nama Barang</label>
<div class="col-sm-12">
<input type="text" class="form-control" id="nama" name="nama" placeholder="Enter Nama Barang" maxlength="50" required="">
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Harga Beli</label>
<div class="col-sm-12">
<input type="number" class="form-control" id="harga_beli" name="harga_beli" placeholder="Enter Harga Beli" required="">
</div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Harga Jual</label>
    <div class="col-sm-12">
    <input type="number" class="form-control" id="harga_jual" name="harga_jual" placeholder="Enter Harga Jual" required="">
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Stok</label>
    <div class="col-sm-12">
    <input type="number" class="form-control" id="stok" name="stok" placeholder="Enter Stok" required="">
    </div>
</div>
<div class="col-sm-offset-2 col-sm-10">
<button type="submit" class="btn btn-primary" id="btn-save">Submit
</button>
</div>
</form>
</div>
<div class="modal-footer">
</div>
</div>
</div>
</div>
<!-- end bootstrap model -->
</body>
<script type="text/javascript">
$(document).ready( function () {
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$('#ajax-crud-datatable').DataTable({
processing: true,
serverSide: true,
ajax: "{{ url('/') }}",
columns: [
{ data: 'id', name: 'id' },
{ data: 'image', name: 'image' },
{ data: 'nama', name: 'nama' },
{ data: 'harga_beli', name: 'harga_beli' },
{ data: 'harga_jual', name: 'harga_jual' },
{ data: 'stok', name: 'stok' },
{ data: 'created_at', name: 'created_at' },
{ data: 'action', name: 'action', orderable: false, searchable: false}
],
order: [[0, 'desc']]
});
});
function add(){
$('#CompanyForm').trigger("reset");
$('#CompanyModal').html("Add Barang");
$('#company-modal').modal('show');
$('#id').val('');
}   
function editFunc(id){
$.ajax({
type:"POST",
url: "{{ url('edit-barang') }}",
data: { id: id },
dataType: 'json',
success: function(res){
$('#CompanyModal').html("Edit Barang");
$('#company-modal').modal('show');
$('#id').val(res.id);
$('#foto').html(res.foto);
$('#nama').val(res.nama);
$('#harga_beli').val(res.harga_beli);
$('#harga_jual').val(res.harga_jual);
$('#stok').val(res.stok);
}
});
}  
function deleteFunc(id){
if (confirm("Delete Barang?") == true) {
var id = id;
// ajax
$.ajax({
type:"POST",
url: "{{ url('delete-barang') }}",
data: { id: id },
dataType: 'json',
success: function(res){
var oTable = $('#ajax-crud-datatable').dataTable();
oTable.fnDraw(false);
}
});
}
}
$('#CompanyForm').submit(function(e) {
e.preventDefault();
var formData = new FormData(this);
$.ajax({
type:'POST',
url: "{{ url('store-barang')}}",
data: formData,
cache:false,
contentType: false,
processData: false,
success: (data) => {
$("#company-modal").modal('hide');
var oTable = $('#ajax-crud-datatable').dataTable();
oTable.fnDraw(false);
$("#btn-save").html('Submit');
$("#btn-save"). attr("disabled", false);
},
error: function(data){
console.log(data);
}
});
});
</script>
</html>