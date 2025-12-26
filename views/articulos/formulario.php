        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="articulo[nombre]" autofocus placeholder="Nombre" value="<?php echo s($articulo->nombre); ?>">

        <label for="descripcion">Descripcion</label>
        <textarea name="articulo[descripcion]" id="descripcion"><?php echo s($articulo->descripcion); ?></textarea>

        <label for="categoria">Categoria</label>

        <select name="articulo[categorias_id]" id="categoria">
            <option value="">-- Seleccione --</option>

            <?php foreach ($categorias as $categoria): ?>
                <option 
                    value="<?php echo s($categoria->id); ?>"
                    <?php echo ($articulo->categorias_id === $categoria->id) ? 'selected' : ''; ?>
                >
                    <?php echo s($categoria->nombre); ?>
                </option>
            <?php endforeach; ?>
        </select>

        
        <label for="imagen">Imagen</label>
        <input type="file" id="imagen" name="articulo[imagen]" accept="image/jpeg, image/png">        

        <?php if($articulo->imagen) { ?>
            <img src="/imagenes/<?php echo $articulo->imagen ?>" class="imagen-small">
        <?php } ?>