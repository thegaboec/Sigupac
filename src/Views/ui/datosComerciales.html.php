<div class="content-list">
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
        <form class="busqueda" action="" method="get">
            <select name="option" id="">
                <option value="cedula">Cédula</option>
                <option value="ruc">Ruc</option>
                <option value="contabilidad">Contabilidad</option>
            </select>
            <div class="input-search">
                <input type="search" name="query" id="">
                <button type="submit">Buscar</button>
            </div>
        </form>
        <table class="list table-overflow">
            <thead>
                <tr>
                    <th>IDENTIFICADOR</th>
                    <th>NOMBRE DEL LOCAL</th>
                    <th>TIPO</th>
                    <th>CONTABILIDAD</th>
                    <th>IMAGEN DEL LOCAL</th>
                    <th>CÉDULA</th>
                    <th>NOMBRE DEL PROPIETARIO</th>
                    <th>CELULAR</th>
                    <th>RUC</th>
                    <th>EDITAR</th>
                </tr>
            </thead>
            <tbody>
                <?php  foreach($locales as $local): ?>

                    <tr>
                        <td><?= $local->id_local  ?? 'sin datos' ?></td>
                        <td><?= $local->nombre_local  ?? 'sin datos' ?></td>
                        <td><?= $local->tipo  ?? 'sin datos' ?></td>
                        <td><?= $local->contabilidad  ?? 'sin datos' ?></td>
                        <td> <img src="<?php 
                                $verify = substr($local->imagen,0,22);
                                if($verify === 'data:image/png;base64,' || $verify === 'data:image/jpg;base64,'){
                                    echo $local->imagen;
                                }else{
                                    
                                    echo 'data:image/png;base64,' . $local->imagen;
                                }                
                ?>" alt="imagen del local"></td>
                        <td><?= $local->cedula  ?? 'sin datos'; ?></td>
                        <td><?= $local->nombre_propietario  ?? 'sin datos'; ?></td>
                        <td><?= $local->celular ?? 'sin datos' ?></td>
                        <td><?= $local->ruc  ?? 'sin datos'; ?></td>
                        <td><a class="button-submit" href="/editar/locales?id=<?= $local->id_local ?>">EDITAR</a></td>
                    </tr>

                <?php endforeach;?>
            </tbody>
        </table>
</div>