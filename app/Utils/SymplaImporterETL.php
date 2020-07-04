<?php

namespace App\Utils;

class SymplaImporterETL
{
    protected $file;
    protected $event_id;
    protected $rows;
    protected $data;

    public function __construct($file, $event_id) {
        $this->file = $file;
        $this->event_id = $event_id;
    }

    public function import(){
        $this->extract();
        $this->transform();
        $this->load();
        dd($this->data);
        return true;
    }

    public function extract(){
        $path = $this->file->getRealPath();
        $csv_string = file_get_contents($path);
        $rows = str_getcsv($csv_string, "\n");
        $i = 0;
        foreach($rows as $row){
            $this->rows[$i++] = str_getcsv($row, ',');
        }
    }

    public function transform(){
        $i = 0;
        foreach($this->rows as $row){

            if(count($row) <= 14)
                continue;

            if(!is_numeric($row[0]))
                continue;

            $this->data[$i]['ordem_de_inscricao'] = $row[0];
            $this->data[$i]['n_ingresso'] = $row[1];
            $this->data[$i]['nome'] = $row[2];
            $this->data[$i]['sobrenome'] = $row[3];
            $this->data[$i]['tipo_de_ingresso'] = $row[4];
            $this->data[$i]['valor'] = $row[5];
            $this->data[$i]['data_compra'] = $row[6];
            $this->data[$i]['n_pedido'] = $row[7];
            $this->data[$i]['email'] = $row[8];
            $this->data[$i]['estado_do_pagamento'] = $row[9];
            $this->data[$i]['check_in'] = $row[10];
            $this->data[$i]['data_check_in'] = $row[11];
            $this->data[$i]['codigo_desconto'] = $row[12];
            $this->data[$i++]['metodo_pagamento'] = $row[13];
        }
    }

    public function load(){

    }
}
