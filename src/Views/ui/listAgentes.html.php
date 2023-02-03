<div class="content-documentation">
    
    <table class="list">
        <caption>Lista de Agentes Municipales</caption>
        <thead>
            <tr>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Fecha de Ingreso</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($agentes as $agente): ?>
                <tr>
                    <td><?= $agente->id ?? 'desconocido';?> </td>
                    <td><?= $agente->nombre ?? 'desconocido';?> </td>
                    <td><?= $agente->estado ?? 'desconocido';?> </td>
                    <td><?= $agente->fecha ?? 'deconocido';?> </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>