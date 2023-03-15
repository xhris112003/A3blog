<!DOCTYPE html>
<html lang="en">
<head>
<title>Users list!</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
  <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
  <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
</head>
<body>
<div class="container"><br/><br/>
    <div class="row">
        <div class="col-lg-10">
            <h2>Article list!</h2>
        </div>
        <div class="col-lg-2">
            <a type="button" href="{{route('administration')}}"class="btn btn-outline-dark">
              Return
            </a>
        </div>
        
    </div>
    <br>
    <table class="table" id="tableUser">
        <thead>
            <tr>
                <th>id</th>
                <th>Title</th>
                <th>Body</th>  
                <th>Image</th>
                <th>Created_at</th>
                <th width="280px">Action</th>
            </tr>
        </thead>  
        <tbody>
       @foreach($article as $articles)
        <tr>
          <td>{{ $articles->id }}</td>
          <td>{{ $articles->title }}</td>
          <td>{{ $articles->body }}</td>
          <td><img id="image" style="width: 50px; heigth: 50px;" src="{{ asset(Storage::url($articles->image)) }}" alt=""></td>
          <td>{{ $articles->created_at }}</td>
          <td>
            <a data-bs-toggle="modal" data-bs-target="#myModal" data-id="{{ $articles->id }}" data-title="{{ $articles->title }}" data-body="{{ $articles->body }}"
            class="btn btn-warning btnEdit"><i class="fa fa-pencil-square-o"></i></a>
            <a id="borrar" data-id="" class="btn btn-danger btnDelete"><i class="fa fa-trash"></i></a>
          </td>
        </tr>
        @endforeach
        </tbody>
    </table>


</div>
</body>
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Article</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addUser" name="addUser" action="{{route('addAdmin')}}" method="post">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="idArticle">Id:</label>
            <input type="text" class="form-control" id="idArticle" name="idArticle" readonly>
          </div>
          <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" placeholder="Enter Title" name="title">
          </div>
          <div class="form-group">
            <label for="body">Body:</label>
            <textarea class="form-control" id="body" placeholder="Enter Body" name="body"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  $(document).ready(function () {
      $('#tableUser').DataTable();

  });

  $(document).on('click', '.btnEdit', function () {
    var title = $(this).data('title');
    var body = $(this).data('body');
    var articleId = $(this).data('id');

    $('#idArticle').val(articleId);
    $('#title').val(title);
    $('#body').val(body);

  });
</script>