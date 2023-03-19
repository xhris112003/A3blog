@extends('layouts.head')

<header>
  <div style="clear:both"></div>
  <nav>
    <ul>
      <li style="margin-right: 0;"><a href="/">Inicio</a></li>
      @if (Auth::check())
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
<h2 class="title m-3">Mis Articulos</h2>

<div class="card-body">
  <ul class="articles">
    @foreach ($articles as $article)
    @if(Auth::user()->name === $article->user->name)
      <li class="article card mb-3 m-3 col-lg-3">
        <img class="card-img-top article-image" src="{{ asset(Storage::url($article->image)) }}" alt="">
        <div class="card-body border border-dark">
        <div class="d-flex align-items-center justify-content-between">
            <h4>{{ $article->title }} <h6 class="fw-light">Posted {{$article->created_at->diffForHumans()}}</h6></h4>
          </div>
          <p class="card-text article-body">{{ $article->body }}</p>
          <button class="btn btn-secondary btn-sm collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#comments_{{ $article->id }}" aria-expanded="false" aria-controls="comments_{{ $article->id }}">
            Comentarios
          </button>
          @if (Auth::check() && Auth::user()->id === $article->user_id)
            <a class="btn btn-danger btn-sm" id="borrar" onclick="borrarArticulo('{{ $article->id }}')">Borrar</a>
            <form id="delete-form-{{ $article->id }}" action="{{ route('article.destroy', $article->id) }}" method="POST"
              style="display: none;">
              @csrf
              @method('DELETE')
            </form>
          @endif
          <div class="collapse mt-3" id="comments_{{ $article->id }}">
            <div class="card card-body">
              @foreach($comments as $comment)
                @if ($comment->article_id == $article->id)
                  @if ($comment->user && $comment->user->name == $article->user->name)
                    <div class="comment author-comment">
                      <p class="comment-body">{{ $comment->body }}</p>
                      <p class="comment-info">(Autor)</p>
                    </div>
                  @else
                    <div class="comment">
                      <p class="comment-body">{{ $comment->body }}</p>
                      <p class="comment-info">({{ $comment->user ? ($comment->user->name) : 'Anónimo' }})</p>
                    </div>
                  @endif
                  <b class="comment-date">{{ $comment->created_at }}</b>
                @endif
              @endforeach
            </div>
          </div>
        </div>
      </li>
      @endif
    @endforeach
  </ul>
</div>

<script>
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
</script>
