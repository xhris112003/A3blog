@extends('layouts.adminArticle')
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
            <a id="borrar" onclick="borrarArticulo('{{ $articles->id }}')" class="btn btn-danger btnDelete"><i class="fa fa-trash"></i></a>
            <form id="delete-form-{{ $articles->id }}" action="{{ route('article.destroy', $articles->id) }}"
              method="POST" style="display: none;">
              @csrf
              @method('DELETE')
            </form>
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
      <form id="edit-article-form" action="{{route('article.update', ['id' => $articles->id])}}">
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
@section('adminArticle')
@parent
<script>
  $(document).ready(function () {
      $('#tableUser').DataTable();

  });

  function borrarArticulo(id) {
    Swal.fire({
      title: '¿Estás seguro de que deseas borrar este artículo?',
      text: "¡No podrás revertir esto!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, borrarlo'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('delete-form-' + id).submit();
      }
    })
  }

  $(document).on('click', '.btnEdit', function () {
    var title = $(this).data('title');
    var body = $(this).data('body');
    var articleId = $(this).data('id');

    $('#idArticle').val(articleId);
    $('#title').val(title);
    $('#body').val(body);

  });
  $(document).ready(function () {
    $('#edit-article-form').on('submit', function (e) {
      e.preventDefault();

      var articleId = $('#idArticle').val();

      var data = $(this).serialize();

      $.ajax({
        url: "/article/" + articleId,
        method: "PUT",
        dataType: "json",
        data: data,
        success: function (response) {
          $('#myModal').modal('hide');


        },
      });
      location.reload();
    });
  });
</script>
@endsection