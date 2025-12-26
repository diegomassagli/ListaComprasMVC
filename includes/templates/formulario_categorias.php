      <fieldset>
        <legend>Nueva Categoria</legend>

        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="categoria[nombre]" placeholder="Nombre" value="<?php echo s($categoria->nombre); ?>">

        <label for="tipoLista">Tipo Lista</label>
        <select name="categoria[tipoLista]" id="tipoLista">
          <option value="">-- Seleccione --</option>
          <?php foreach ($tiposLista as $id => $nombre): ?>
            <option <?php echo $categoria->tipoLista === (string)$id ? 'selected' : '' ?> value="<?php echo $id?>"><?php echo $nombre ?></option>
          <?php endforeach; ?>
        </select>        
      </fieldset>
