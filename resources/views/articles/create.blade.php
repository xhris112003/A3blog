<link rel="stylesheet" type="text/css" href="{{ asset('css/styleCreate.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
<div class="container">
    <h1>Crear Artículo</h1>
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
            <input type="file" name="image" id="image">
        </div>
        <button type="submit" class="btn btn-primary">Crear Artículo</button>
    </form>
</div>