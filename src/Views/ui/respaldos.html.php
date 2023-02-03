<div class="list">
    <div class="">
        <h2>
            Apartado para generar un respaldo de la base de datos
        </h2>
        <p>
            Hoy en la fecha <?php date_default_timezone_set('America/Guayaquil'); 
            $date = new \DateTime(); echo $date->format('d m Y'); ?> se procedera a realizar
            un respaldo de la base de datos por el ING. <?= $user->nombre;?>
        </p>
        <form action="" method="post">
            <button class="button-submit" type="submit"> Generar</button>
        </form>
    </div>
</div>