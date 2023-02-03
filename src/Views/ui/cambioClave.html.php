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

<div class="container-form">
    <h1>Cambiar Contraseña </h1>
    <form action="" method="post">
        <label for="">Ingrese contraseña actual </label>
        <input type="text" name="actual">
        <label for="">Ingrese la nueva contraseña</label>
        <div class="ojo raya">
        <input type="password" name="newpass" id="">
        <span class="material-icons visible" id="eye">&#xe8f4;</span>
        </div>
        <label for="">Repita la nueva contraseña</label>
        <div class="ojo raya">
        <input type="password" name="repitpass" id="">
        <span class="material-icons visible" id="eye">&#xe8f4;</span>
        </div>
        <button type="submit" class="button-submit">Ingresar</button>
    </form>
</div>