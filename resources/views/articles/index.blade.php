@extends('layouts.head')

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
<main>
  <h1>Bienvenido a Mi Blog</h1>
  <input type="text" name="query" id="search" placeholder="Buscar por tags">
  <div id="searchResult"></div>
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
      <p style="text-align: center">Debe <a href="{{ url('/login') }}">iniciar sesión</a> para poder crear un
        artículo.</p>
      @endif
    </div>
    <h2>Últimos Artículos</h2>
    <ul class="list-unstyled">
      @foreach ($articles as $article)
      <li class="p-3" id="article-{{ $article->id }}">
        <div class="card">
          <div class="d-flex card-header align-items-center justify-content-between">
            <h3>{{ $article->title }} <h6 class="fw-light">Posted {{$article->created_at->diffForHumans()}}</h6></h3>
          </div>
          <div class="mx-auto card-body">
            <p>{{ $article->body }}</p>
            <img src="{{ asset(Storage::url($article->image)) }}" alt="">
            <p>Autor: {{ $article->user->name }}</p>
          </div>
          <div class="container">
            <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3">
              @foreach ($article->tags as $tag)
              <div class="col card-body">
                <div class=" border rounded-pill text-center tag">#{{ $tag->name }}</div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
        </div>
        @if (Auth::check() && Auth::user()->id === $article->user_id)
        <button data-bs-toggle="modal" data-id="{{ $article->id}}" data-bs-target="#TagModal"
          class="btn btn-primary btn-sm collapsed btnTag" type="button" data-bs-toggle="collapse">
          + Tag
        </button>
        @endif
        <button class="btn btn-secondary btn-sm collapsed" type="button" data-bs-toggle="collapse"
          data-bs-target="#comments_{{ $article->id }}" aria-expanded="false"
          aria-controls="comments_{{ $article->id }}">
          Comentarios
        </button>
        <div class="collapse mt-3" id="comments_{{ $article->id }}">
          <div class="card card-body">
            @foreach($comments as $comment)
            @if ($comment->article_id == $article->id)
            @if ($comment->user && $comment->user->name == $article->user->name)
            <div style="display:flex;">
              <p style="font-size:20px;">{{ $comment->body }}</p>
              <p style="margin-left: 1em;font-size:13px;">(Autor)</p>
            </div>
            @else
            <div style="display:flex;">
              <p style="font-size:20px;">{{ $comment->body }}</p>
              <p style="margin-left: 1em;font-size:13px;">({{ $comment->user ? ($comment->user->name) : 'Anónimo'
                }})
              </p>
            </div>
            @endif
            <b>
              <p style="font-size:10px;">{{ $comment->created_at }}</p>
            </b>
            @endif
            @endforeach
            <form action="{{ route('comments.store') }}" method="POST">
              @csrf
              @if (Auth::check())
              <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
              @endif
              <input type="hidden" name="article_id" value="{{ $article->id }}">
              <div class="form-group">
                <textarea class="form-control" name="body" rows="3"></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Añadir comentario</button>
            </form>
          </div>
        </div>
        @if (Auth::check() && Auth::user()->id === $article->user_id)
        <a class="btn btn-danger btn-sm" id="borrar" onclick="borrarArticulo('{{ $article->id }}')">Borrar</a>
        <form id="delete-form-{{ $article->id }}" action="{{ route('article.destroy', $article->id) }}" method="POST"
          style="display: none;">
          @csrf
          @method('DELETE')
        </form>
        @endif
      </li>
      @endforeach
    </ul>
    </div>
  </section>
</main>
<footer>
  <p>Copyright &copy; 2022 Mi Blog</p>
</footer>
</body>

<div class="modal fade" id="TagModal" tabindex="-1" aria-labelledby="TagModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        @if (isset($article))
        <form action="{{ route('article.addTag',['article' => $article->id]) }}" method="POST">
          @csrf
          <input type="hidden" name="article_id" id="articleId">
          <div class="form-group">
            <label for="newTag">Nuevo tag:</label>
            <input type="text" class="form-control" name="newTag" id="newTag"
              placeholder="Ingrese el nombre del nuevo tag">
          </div>
          <button type="submit" class="btn btn-primary">Agregar tag</button>
        </form>
        @endif
      </div>
    </div>
  </div>
</div>

</html>

@section('head')
@parent
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

  $(document).on('click', '.btnTag', function () {
    var articleId = $(this).data('id');

    $('#articleId').val(articleId);

  });

  $('#search').on('keyup', function () {
    var query = $(this).val();
    if (query != '') {
      var resultsHtml = '';
      resultsHtml += '<div class="col-lg-2">'
      $.get('{{ route('article.searchByTag') }}', { query: query }, function (data) {

        $.each(data, function (index, article) {
          resultsHtml += '<button data-id="' + article.id + '" class="border-0 card-header article">' + article.title + '</button>';

          $.each(article.tags, function (index, tag) {
            resultsHtml += '<div class="border rounded-pill text-center tag m-3">#' + tag.name + '</div>';
          });

        });
        resultsHtml += '</div>'
        $('#searchResult').html(resultsHtml);
      });
    } else {
      $.get('{{ route('article.searchByTag') }}', { query: query }, function (data) {
        var resultsHtml = '';
        $.each(data, function (index, article) {
          resultsHtml += '';
        });
        $('#searchResult').html(resultsHtml);
      });
    }
  });

  $('#searchResult').on('click', '.article', function () {
    var IdArticles = $(this).data('id');
    console.log(IdArticles)
    $.get('{{ route('article.show', '') }}/' + IdArticles, function (data) {
      var targetElement = $('#article-' + IdArticles);
      $('html, body').animate({
        scrollTop: targetElement.offset().top
      }, 'slow');
    });
  });

</script>
@endsection