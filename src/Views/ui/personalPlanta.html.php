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
    <h1>Ingresar Personal de Planta</h1>
    <form action="" method="post">
        <!--TODO: Para verificar una cedula debe contener esta esta estructura  -->
        <div class="verify-password">
            <label for="">Ingrese el Número de Cédula</label>
            <input type="text" name="cedula" id="cedula-verify">
            <span class="error error-sms" id="error-cedula"></span>
        </div>
        <!-- END -->
        <label for="">Ingrese el Nombre del Usuario</label>
        <input type="text" name="nombre">
        <label for="">Ingrese una Contraseña para el Usuario</label>
        <div class="ojo raya">
        <input type="password" name="password" id="">
        <span class="material-icons visible" id="eye">&#xe8f4;</span>
        </div>
        <button type="submit" class="button-submit">Registrar</button>
    </form>
</div>