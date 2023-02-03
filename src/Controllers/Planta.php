<?php

namespace App\Controllers;

use App\Models\Locales;
use App\Models\Propietarios;
use App\Models\Usuarios;
use PhpOffice\PhpSpreadsheet\{Spreadsheet,IOFactory};

class Planta{
    private $usuarios;
    private $locales;
    private $propietarios;

    public function __construct(
        Usuarios $usuarios,
        Locales $locales,
        Propietarios $propietarios
    )
    {
        $this->usuarios = $usuarios;
        $this->locales = $locales;
        $this->propietarios= $propietarios;
    }

    public function view($variables = []){
        

        if(isset($_GET['option']) && isset($_GET['query']) && !empty($_GET['query']))
        {
            if ($_GET['option'] == "contabilidad"){
               
                 $local = $this->locales->getAllLocalsContabilidad(trim($_GET['option']),trim($_GET['query']));
                  $variables = [
                'locales' => $local
            ];
            } else {
            $local = $this->locales->selectLocal(trim($_GET['option']),trim($_GET['query']));
            $variables = [
                'locales' => $local
            ];
            }
        }
        if(empty($variables)){
            $locales = $this->locales->getAllInformation();
            $variables = [
                'locales' => $locales
            ];
        }
      
        return [
            'title' => 'Datos locales comerciales',
            'template' => 'ui/datosComerciales.html.php',
            'variables' => $variables
        ];

    }


    public function edit(){
        if(!isset($_GET['id'])){
            header('location: /list/locales-comerciales');
            exit();
        }

        $local = $this->locales->getLocalInformation($_GET['id']);
        return [
            'title' => 'Editar Local Comercial',
            'template' => 'ui/editLocal.html.php',
            'variables' => [
                'local' => $local
            ]
        ];
    }

    public function saveEdit(){
        $dataLocal = [
            'nombre' => $_POST['nombre_local'],
            'tipo' => $_POST['tipo'],
        ];
        if(isset($_POST['contabilidad'])){
            $dataLocal['contabilidad'] = $_POST['contabilidad'];
        }
        $dataPropietario = [
            'cedula' => $_POST['cedula'],
            'nombre' => $_POST['nombre_propietario'],
            'ruc' => $_POST['ruc'],
            'celular' => $_POST['celular'],
            'id' => $_POST['id_propietario']
        ];
        $propietarioIdent =  $this->propietarios->selectFromColumn('id',$_POST['id_propietario'])[0];  
        if($propietarioIdent->cedula !== trim($_POST['cedula'])){
            $propietarioUpdate = $this->propietarios->selectFromColumn('cedula',trim($_POST['cedula']));
            if($propietarioUpdate){
                $dataLocal['id_propietario'] = $propietarioUpdate[0]->id;

            }else{
                $dataPropietarioInsert  = [
                    'cedula' => trim($_POST['cedula']),
                    'nombre' => $_POST['nombre_propietario'],
                    'celular' => $_POST['celular'],
                    'ruc' => $_POST['ruc'],
                    'anonimo' => 0
                ];
                try{
                    $modelPropietario = $this->propietarios->insertUltimate($dataPropietarioInsert); 
                    $dataLocal['id_propietario'] = $modelPropietario->id;
                }catch(\PDOException $e){
                    $locales = $this->locales->getAllInformation();
                    $variables = [
                        'locales' => $locales,
                        'error' => 'Error: ' .$e->getMessage()
                    ];
                    return $this->view($variables);
                }
            }
        }
        if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
            $imagen =$_FILES['imagen'];
            $file = base64_encode(file_get_contents($imagen['tmp_name']));
            $dataLocal['imagen']= $file; 
        }
        $dataLocal['id'] = $_POST['id_local'];

        try{
            
           $this->locales->update($dataLocal);
        }catch(\PDOException $e){
            $locales = $this->locales->getAllInformation();
            $variables = [
                'locales' => $locales,
                'error' => 'Error: ' .$e->getMessage()
            ];
            return $this->view($variables);
        }

        
        try{
            
            $this->propietarios->update($dataPropietario);
            $locales = $this->locales->getAllInformation();
             $variables = [
                 'locales' => $locales,
                 'success' => 'Se actualizo correctamente los datos'
             ];
             return $this->view($variables);

         }catch(\PDOException $e){
             $locales = $this->locales->getAllInformation();
             $variables = [
                 'locales' => $locales,
                 'error' => 'Error: ' .$e->getMessage()
             ];
             return $this->view($variables);
         }
        
    }

    public function descargaExel(){

       $locales = $this->locales->getAllLocalsContabilidad('contabilidad','SI');
        $exel = new Spreadsheet;
        $reporte = $exel->getActiveSheet();

        $reporte->setTitle('Reporte Locales Comerciales');
        $reporte->getColumnDimension('D')->setWidth(40);
        $reporte->setCellValue('D2','Reporte Locales Comerciales con Contabilidad');
        $reporte->getColumnDimension('A')->setWidth(20);
        $reporte->setCellValue('A4','IDENTIFICADOR');
        $reporte->getColumnDimension('B')->setWidth(20);
        $reporte->setCellValue('B4','NOMBRE DEL LOCAL');
        $reporte->getColumnDimension('C')->setWidth(20);
        $reporte->setCellValue('C4','TIPO');
        $reporte->getColumnDimension('D')->setWidth(30);
        $reporte->setCellValue('D4','CÉDULA DEL PROPIETARIO');
        $reporte->getColumnDimension('E')->setWidth(40);
        $reporte->setCellValue('E4','NOMBRE DEL PROPIETARIO');
        $reporte->getColumnDimension('F')->setWidth(20);
        $reporte->setCellValue('F4','RUC');
        $reporte->getColumnDimension('G')->setWidth(10);
        $reporte->setCellValue('G4','CONTABILIDAD');

        $columNum = 5;
        foreach($locales as $local){
            $reporte->setCellValue('A'. $columNum,$local->id_local);
            $reporte->setCellValue('B'. $columNum,$local->nombre_local);
            $reporte->setCellValue('C'. $columNum,$local->tipo);
            $reporte->setCellValue('D'. $columNum,$local->cedula);
            $reporte->setCellValue('E'. $columNum,$local->nombre_propietario);
            $reporte->setCellValue('F'. $columNum,$local->ruc);
            $reporte->setCellValue('G'. $columNum,$local->contabilidad);
            $columNum ++;

        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="reporte_locales.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($exel, 'Xlsx');

        $writer->save('php://output');

        exit();



    }


    
}