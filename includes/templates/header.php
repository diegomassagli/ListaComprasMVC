<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listas de Compras</title>
  <link rel="stylesheet" href="/build/css/app.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>

  <header class="header">
    <div class="barra">
      <h2>Listas de Compras</h2>

      <div class="mobile-menu">
        <img src="/build/img/barras.svg" alt="icono menu responsive">
      </div>

      <div class="derecha">        
        <nav class="navegacion">
          <a href="/listas">Inicio</a>
          <a href="/listas">Listas</a>
          <a href="/categorias">Categorias</a>
          <a href="/articulos">Productos</a>
          <?php if($auth): ?>
            <a href="/logout">Cerrar Sesion</a>
          <?php endif; ?>
        </nav>
      </div><!--.derecha-->     

    </div> <!--.barra-->     
  </header>