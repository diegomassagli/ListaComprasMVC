        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="lista[nombre]" placeholder="Nombre" value="<?php echo $lista->nombre; ?>">

        <label for="tipoLista">Tipo Lista</label>
        <select name="lista[tipoLista]" id="tipoLista">
          <option value="">-- Seleccione --</option>
          <?php foreach ($tiposLista as $id => $nombre): ?>
            <option <?php echo $lista->tipoLista === (string)$id ? 'selected' : '' ?> value="<?php echo $id?>"><?php echo $nombre ?></option>
          <?php endforeach; ?>
        </select>
        
        <label for="descripcion">Descripcion</label>
        <textarea name="lista[descripcion]" id="descripcion"><?php echo $lista->descripcion; ?></textarea>
        
        <label for="imagen">Imagen</label>
        <input type="file" id="imagen" name="lista[imagen]" accept="image/jpeg, image/png">        
      </fieldset>