<?php

use Illuminate\Database\Seeder;
use App\Import;
use App\Event;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Utils\SymplaImporterETL;

class EventsDateImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filesBasePath = storage_path('app/files/');
        $imports = [
            //JSDay 2017
            [
                'name' => 'JSDay 2017',
                'date' => '',
                'place' => '',
                'city' => '',
                'about' => 'Importação dos inscritos do JSDay 2017',
                'file_path' => 'Lista de participantes - JSDay_Feira_de_Santana_2017 (140234).csv'              
            ],
            //JSDay 2018
            [
                'name' => 'JSDay 2018',
                'date' => '',
                'place' => '',
                'city' => '',
                'about' => 'Importação dos inscritos do JSDay 2018',
                'file_path' => 'Lista de participantes - JSDay_Feira_de_Santana_2018 (255612).csv'              
            ],
            //DevFest 2018
            [
                'name' => 'DevFest 2018',
                'date' => '',
                'place' => '',
                'city' => '',
                'about' => 'Importação dos inscritos do DevFest 2018',
                'file_path' => 'Lista de participantes - DevFest_Feira_de_Santana_2018 (349642).csv'              
            ],
            //PythonDay 2019
            [
                'name' => 'PythonDay 2019',
                'date' => '',
                'place' => '',
                'city' => '',
                'about' => 'Importação dos inscritos do PythonDay 2019',
                'file_path' => 'Lista de participantes - Python_Day_2019 (480635).csv'              
            ],
            //JSDay 2019
            [
                'name' => 'JSDay 2019',
                'date' => '',
                'place' => '',
                'city' => '',
                'about' => 'Importação dos inscritos do JSDay 2019',
                'file_path' => 'Lista de participantes - JSDay_Feira_de_Santana_2019 (545715).csv'              
            ],
            //DevFest 2019
            [
                'name' => 'DevFest 2019',
                'date' => '',
                'place' => '',
                'city' => '',
                'about' => 'Importação dos inscritos do DevFest 2019',
                'file_path' => 'Lista de participantes - GDG_DevFest_FSA_2019 (614974).csv'              
            ],            
            //JSDay 2020
            [
                'name' => 'JSDay 2020',
                'date' => '',
                'place' => '',
                'city' => '',
                'about' => 'Importação dos inscritos do JSDay 2020',
                'file_path' => 'Lista de participantes - GDG_JSDay_Feira_de_Santana_2020 (887489).csv'              
            ],
        ];

        foreach($imports as $import){
            //Criando Event
            $modelEvent = new Event();
            $event = $modelEvent->create(['name' => $import['name'], 'date' => $import['date'], 'place' => $import['place'], 'city' => $import['city']]);

            //Criando Import
            $modelImport = new Import();
            $file =  new UploadedFile( storage_path().'/app/files/'.$import['file_path'], $import['file_path'] , 'text/csv');
            $import = $modelImport->create(['about' => $import['about']]);

            //Importando Registros
            $importer = new SymplaImporterETL($file, $event->id, $import->id);
            $importer->import();
        }
    }
}
