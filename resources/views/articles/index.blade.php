<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="{{ asset('css/styleIndex.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/styleCreate.css') }}">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>Mi Blog</title>
</head>
<body>
  <header>
    <nav>
      <ul>
        <li><a href="/">Inicio</a></li>
        @if (Auth::check())
        <li><a href="{{ route('profile') }}">Perfil</a></li>
          <li>
            <a onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
            </form>
          </li>
        @else
          <li><a href="{{ url('/register') }}">Registrarse</a></li>
          <li><a href="{{ url('/login') }}">Iniciar sesión</a></li>
        @endif
        
        </li>
      </ul>
    </nav>
  </header>
  <main>
    <h1>Bienvenido a Mi Blog</h1>
    <section>
    <div class="container">
    @if (Auth::check())
    <form action="/" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Título</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>
        <div class="form-group">
            <label for="body">Contenido</label>
            <textarea class="form-control" id="body" name="body" rows="5"></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear Artículo</button>
    </form>
    @else
      <p style="text-align: center">Debe <a href="{{ url('/login') }}">iniciar sesión</a> para poder crear un artículo.</p>
    @endif
    </div>
      <h2>Últimos Artículos</h2>
      <ul>
        @foreach ($articles as $article)
          <li>
            <h3>{{ $article->title }}</h3>
            <p>{{ $article->body }}</p>
            <img src="{{ asset(Storage::url($article->image)) }}" alt="">
            <p>Autor: {{ $article->user->name }}</p>
          </li>
          <button class="btn btn-secondary btn-sm" type="button" data-toggle="collapse" data-target="#comments_{{ $article->id }}" aria-expanded="false" aria-controls="comments_{{ $article->id }}">
            Comentarios
          </button>
          <div class="collapse mt-3" id="comments_{{ $article->id }}">
            <div class="card card-body">
              @foreach($article->comments as $comment)
                <p>{{ $comment->body }}</p>
              @endforeach
              <form action="{{ route('comments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="article_id" value="{{ $article->id }}">
                <div class="form-group">
                  <textarea class="form-control" name="body" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Añadir comentario</button>
              </form>
            </div>
          </div>
          @if (Auth::check() && Auth::user()->id === $article->user_id)
          <a style="color:black;" href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $article->id }}').submit();">Borrar</a>
          <form id="delete-form-{{ $article->id }}" action="{{ route('article.destroy', $article) }}" method="POST" style="display: none;">
            @csrf
            @method('delete')
          </form>
          @endif
        @endforeach
      </ul>
    </section>
  </main>
  <footer>
    <p>Copyright &copy; 2022 Mi Blog</p>
  </footer>
</body>
</html>
