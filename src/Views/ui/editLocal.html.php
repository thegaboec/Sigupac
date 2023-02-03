<div class="content-list">
    <form action="" method="post" class="form-edit" enctype="multipart/form-data">
        <div>        
            <label for="">Editar Nombre del Local Comercial </label>
            <input type="text" name="nombre_local" value="<?= $local->nombre_local;?>">
            <input type="hidden" name="id_local" value="<?= $local->id_local?>" >
        </div>

        <div>
            <label for="">Editar el tipo del Local Comercial </label>
            <input type="text" name="tipo" value="<?= $local->tipo;?>">
        </div>
        <div>
            <label for="">Editar la contabilidad </label>
            <div>
                <label for="">Actualmente: <?=$local->contabilidad;?></label>
            </div>
            <select id="select-comercio" id="">
                <option value="..">Cambiar</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
        </div>
        <div>
            <label for="">Actualizar la imagen Local Comercial </label>
            <img id="preview2" src="<?php 
                $verify = substr($local->imagen,0,22);
                if($verify === 'data:image/png;base64,' || $verify === 'data:image/jpg;base64,'){
                    echo $local->imagen;
                }else{
                    
                    echo 'data:image/png;base64,' . $local->imagen;
                }                
                ?>
            " alt="imagen del local">
            <label title="Selecionar Imagen" class="img-select" for="img-logo"><span class="material-icons">&#xe410;</span></label>
            <input style="display:none;"  type="file" accept="image/*" name="imagen" id="img-logo">
        </div>
        <div class="verify-password">
            <label for="">Editar la cédula del propietario </label>
            <input type="text" name="cedula" id="cedula-verify" value="<?= $local->cedula;?>">
            <span class="error error-sms" id="error-cedula"></span>
            <input type="hidden" name="id_propietario" value="<?=$local->id;?>">
        </div>
        <div>
            <label for="">Editar el nombre del propietario </label>
            <input type="text" name="nombre_propietario" value="<?= $local->nombre_propietario;?>">
        </div>
         <div>
            <label for="">Editar el celular del propietario </label>
            <input type="text" name="celular" value="<?= $local->celular;?>">
        </div>
        
        <div>
            <label for="">Editar el ruc del propietario </label>
            <input type="text" name="ruc" value="<?= $local->ruc;?>">
        </div>
        <button type="submit" id="pasar" class="button-submit">
            Guardar
        </button>
        <a href="/" id="reload-page" class="button-cancel">Cancelar</a>
    </form>
</div>