<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="{{ asset('css/styleIndex.css') }}">
  <title>Mi Blog</title>
</head>
<body>
  <header>
    <nav>
      <ul>
        <li><a href="#">Inicio</a></li>
        <li><a  href="{{ route('articles.create') }}">Crear Artículo</a></li>
        <li><a href="#">Iniciar Sesión</a></li>
        <li><a href="#">Registrarse</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <h1>Bienvenido a Mi Blog</h1>
    <section>
      <h2>Últimos Artículos</h2>
      <ul>
        @foreach ($articles as $article)
          <li>
            <h3>{{ $article->title }}</h3>
            <p>{{ $article->body }}</p>
            <img src="{{ asset(Storage::url($article->image)) }}" alt="">
          </li>
        @endforeach
      </ul>
    </section>
  </main>
  <footer>
    <p>Copyright &copy; 2022 Mi Blog</p>
  </footer>
</body>
</html>