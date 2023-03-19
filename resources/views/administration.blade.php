@extends('layouts.admin')

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
            <a data-bs-toggle="modal" data-bs-target="#myModal" data-rol_id="{{ $users->rol_id}}" data-id="{{ $users->id }}"
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
            <label for="rol_id">RolId:</label>
            <input type="text" class="form-control" id="RolUser" name="rol_id">
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



@section('admin')
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
    var name = $(this).data('name');
    var email = $(this).data('email');
    var userId = $(this).data('id');
    var rolId = $(this).data('rol_id');

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
@endsection