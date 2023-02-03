<div class="lis">
<?php if(isset($error)): ?>
        <p class="error">
            <?= $error ?>
        </p>
<?php endif; ?>    
<?php if(isset($success)): ?>
        <p class="success">
            <?= $success ?>
        </p>
<?php endif; ?>
</div>
<div class="content-up">

    <div class="list">
        <h2>Cambio de Logotipo del sistema web</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <label for=""> Selecione la imagen que remplazara el logotipo actual</label>
            <label title="Selecionar Imagen" class="img-select" for="img-logo"><span class="material-icons">&#xe410;</span></label>
            <input style="display:none;"  type="file" accept="image/*" name="imagen" id="img-logo">
            <button type="submit" class="button-submit">Cambiar</button> 
            <a href="/cambio/imagen" class="button-submit"> Cancelar </a>           
        </form>
        <div id="preview">

        </div>
    </div>
</div>