<!DOCTYPE html>
<html>
<head>
	<title>Mi Blog - Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-OgVRvuATP1z7JjHLkuOU6Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/styleProfile.css') }}">
    <style type="text/css">

	</style>
</head>
<body>
	<div class="container">
		<h1>Perfil de usuario</h1>
		<div class="row">
			<div id="info" class="col-md-6">
				<img src="{{ asset(Storage::url($user->image)) }}" alt="Profile picture" class="profile-pic">
				<h2>{{ $user->name }}</h2>
				<p>{{ $user->email }}</p>
			</div>
            <div class="col-md-6">
                <form id="update-profile-form" method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @if(Auth::user()->rol_id == 1)
                    <button class="btn btn-outline-info" type="button">Administration</button>
                    <br><br>
                    @endif
                    <div class="form-group">
                        <label for="name">Nombre:</label>
                        <input type="text" name="name" id="name" value="{{ $user->name }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Correo electrónico:</label>
                        <input type="text" name="email" id="email" value="{{ $user->email }}">
                    </div>
                    <div class="form-group">
                        <label for="password">Nueva contraseña:</label>
                        <input type="password" id="password" name="password" value="{{ old('password') }}">
                        @error('password')
                            <div style='color:red;' class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirmar nueva contraseña:</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}">
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" required>
                    </div>
                    <br>
                    <button id="submitButtom" class="btn btn-outline-dark" type="submit">Guardar cambios</button>
                </form>
            </div>
    </div>
</body>

