@extends('layouts.perfil')
<header>
  <div style="clear:both"></div>
  <nav>
    <ul>
      <li style="margin-right: 0;"><a href="/">Inicio</a></li>
      @if (Auth::check())
      <li style="margin-right: 0;"><a href="{{ route('myarticles') }}">Mis Articulos</a></li>
      <li style="margin-left: auto;">
        <div class="dropdown">
          <a id="botonProfile" class="dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            @if($user->image == null)
            <img id="imgProfile"
              src="https://i.postimg.cc/pm9zNSS2/icono-del-usuario-s-mbolo-plano-de-avatar-aislado-en-blanco-el-fondo-simple-extracto-negro-vector-ej.jpg"
              alt="Profile picture" class="profile-pic">
            @else
            <img id="imgProfile" src="{{ asset(Storage::url($user->image)) }}" alt="Profile picture"
              class="profile-pic">
            @endif
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="{{ route('profile') }}">Profile</a>
            @if(Auth::user()->rol_id == 1)
            <a class="dropdown-item" href="{{route('administration')}}">Administration</a>
            @endif
            <a class="dropdown-item" onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">
              {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </div>
        </div>
      </li>
      @else
      <li style="margin-right: 0;"><a href="{{ url('/register') }}">Registrarse</a></li>
      <li style="margin-right: 0;"><a href="{{ url('/login') }}">Iniciar sesión</a></li>
      @endif

      </li>
    </ul>
  </nav>
</header>
<body>
	<div class="container">
		<h1>Perfil de usuario</h1>
		<div class="row">
			<div id="info" class="col-md-6">
                @if($user->image == null)
                <img src="https://i.postimg.cc/pm9zNSS2/icono-del-usuario-s-mbolo-plano-de-avatar-aislado-en-blanco-el-fondo-simple-extracto-negro-vector-ej.jpg" alt="Profile picture" class="profile-pic">
                @else
				<img src="{{ asset(Storage::url($user->image)) }}" alt="Profile picture" class="profile-pic">
                @endif
				<h2>{{ $user->name }}</h2>
				<p>{{ $user->email }}</p>
			</div>
            <div class="col-md-6">
                <form id="update-profile-form" method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
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

