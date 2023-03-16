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
  <div class="container"><br /><br />
    <div class="row">
      <div class="col-lg-10">
        <h2>Users list!</h2>
      </div>
      <div class="col-lg-2">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addModal">
          Add New Admin
        </button>
        <br /><br />
        <a type="button" href="/" class="btn btn-outline-dark">
          Return
        </a>
      </div>
      <div class="col-lg-2">
        <a type="button" href="{{route('AdminArticles')}}" class="btn btn-outline-success">
          Article list
        </a>
      </div>

    </div>
    <br>
    <table class="table" id="tableUser">
      <thead>
        <tr>
          <th>id</th>
          <th>Name</th>
          <th>Email</th>
          <th>Password</th>
          <th>Type_role</th>
          <th>Created_at</th>
          <th width="280px">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($user as $users)
        <tr>
          <td>{{ $users->id }}</td>
          <td>{{ $users->name }}</td>
          <td>{{ $users->email }}</td>
          <td>{{ $users->password }}</td>
          <td>{{ $users->rol_id }}</td>
          <td>{{ $users->created_at }}</td>
          <td>
            <a data-bs-toggle="modal" data-bs-target="#myModal" data-rol="{{ $users->rol_id}}" data-id="{{ $users->id }}"
              data-name="{{ $users->name }}" data-email="{{ $users->email }}" class="btn btn-warning btnEdit">
              <i class="fa fa-pencil-square-o"></i>
            </a>
            <a id="borrar" data-id="{{ $users->id }}" class="btn btn-danger btnDelete" onclick="borrarArticulo('{{ $users->id }}')"><i class="fa fa-trash"></i></a>
            <form id="delete-form-{{ $users->id }}" action="{{ route('users.destroy', $users) }}" method="POST" style="display: none;">
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
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add AdminUser</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addUser" name="addUser" action="{{route('addAdmin')}}" method="post">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="name">Username:</label>
            <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name">
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="email" placeholder="Enter Email" name="email">
          </div>
          <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" placeholder="Enter Password" name="password">
            @error('password')
            <div style='color:red;' class="text-red-500">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group">
            <label for="password_confirmation">Confirm password:</label>
            <input type="password" class="form-control" id="password_confirmation" placeholder="Confirm Password"
              name="password_confirmation">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="edit-user-form">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="idUser">Id:</label>
            <input type="text" class="form-control" id="idUser" name="idUser" readonly>
          </div>
          <div class="form-group">
            <label for="RolUser">RolId:</label>
            <input type="text" class="form-control" id="RolUser" name="RolUser">
          </div>
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="nameUser" placeholder="Enter Name" name="name">
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="emailUser" placeholder="Enter Email" name="email">
          </div>
          <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" placeholder="Enter Password" name="password"
              required>
            @error('password')
            <div style='color:red;' class="text-red-500">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group">
            <label for="password_confirmation">Confirm password:</label>
            <input type="password" class="form-control" id="password_confirmation" placeholder="Confirm Password"
              name="password_confirmation" required>
          </div>
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

  if (window.jQuery) {  
   console.log("jQuery está disponible en la página.");
} else {
   console.log("jQuery no está disponible en la página.");
}


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
    var name = $(this).data('name');
    var email = $(this).data('email');
    var userId = $(this).data('id');
    var rolId = $(this).data('rol');

    $('#idUser').val(userId);
    $('#nameUser').val(name);
    $('#emailUser').val(email);
    $('#RolUser').val(rolId);

  });

  $(document).ready(function () {
    $('#edit-user-form').on('submit', function (e) {
      e.preventDefault();

      var userId = $('#idUser').val();

      var data = $(this).serialize();

      $.ajax({
        url: "/users/" + userId,
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