<div class="content-documentation">
    <table class="list">
        <caption>Lista de Respaldos de la base de datos</caption>
        <thead>
            <tr>
                <th>Nº</th>
                <th>Fecha de Creación</th>
                <th>Respaldo</th>
                <th>Descargar</th>
            </tr>
        </thead>
        <tbody>
            <?php
                date_default_timezone_set('America/Guayaquil');
                $path = './src/backups';
                $directory = opendir($path);
                $num = 1;
                while (($file = readdir($directory)) !== false): 
                    $ruta_completa = $path . "/" . $file;
                    if($file !== '.' && $file !== '..'):
                        $timespam = preg_split('/-/',$file);
                ?>
                <tr>
                    <td><?= $num; ?></td>
                    <td><?= date('Y-m-d',intval($timespam[0])); ?></td>
                    <td><?= $file?> </td>
                    <td><a href="/src/backups/<?=$file;?>"><span class="material-icons">&#xe2c4;</span></a></td>
                </tr>
                        
                    
        
                    <!-- // Se muestran todos los files y carpetas excepto "." y ".."
                    if ($file != "." && $file != "..") {
                        // Si es un directorio se recorre recursivamente
                        if (is_dir($ruta_completa)) {
                            echo "<li>" . $file . "</li>";
                           $this->list($ruta_completa);
                        } else {
                            echo "<li>" . $file . "</li>";
                        }
                    } -->
                
                <?php 
                        endif;
                    endwhile;
                    ?>
        </tbody>
    </table>
</div>