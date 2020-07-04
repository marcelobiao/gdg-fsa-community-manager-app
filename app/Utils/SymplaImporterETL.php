<?php

namespace App\Utils;
use App\People;
use App\People_event;

class SymplaImporterETL
{
    protected $file;
    protected $event_id;
    protected $import_id;
    protected $rows;
    protected $data;

    public function __construct($file, $event_id, $import_id) {
        $this->file = $file;
        $this->event_id = $event_id;
        $this->import_id = $import_id;
    }

    public function import(){
        $this->extract();
        $this->transform();
        //dd($this->data);
        $this->load();

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
            $this->data[$i]['nome'] = trim($row[2]);
            $this->data[$i]['sobrenome'] = trim($row[3]);
            $this->data[$i]['tipo_de_ingresso'] = $row[4];

            preg_match('/R\$ ([0-9]{1,},[0-9]{2})/', $row[5], $output_array);
            $this->data[$i]['valor'] = $output_array[1];
            $this->data[$i]['data_compra'] = $row[6];
            $this->data[$i]['n_pedido'] = $row[7];
            $this->data[$i]['email'] = $row[8];
            $this->data[$i]['estado_do_pagamento'] = $row[9];
            $this->data[$i]['check_in'] = $row[10] == 'Sim' ? true : false;
            $this->data[$i]['data_check_in'] = empty($row[11]) ? null : $row[11];
            $this->data[$i]['codigo_desconto'] = empty($row[12]) ? null : $row[12];
            $this->data[$i++]['metodo_pagamento'] = $row[13];
        }
    }

    public function load(){
        foreach($this->data as $row){
            $people = People::where('email', $row['email'])->first();

            if(!$people){
                $people = People::create([
                    'email' => $row['email'],
                    'name' => $row['nome'].' '.$row['sobrenome'],
                    'about' => 'default',
                    'import_id' => $this->import_id
                ]);
            }

            $people_event = People_event::create([
                'event_id' => $this->event_id,
                'people_id' => $people->id,
                'import_id' => $this->import_id,
                'registration_order' => $row['ordem_de_inscricao'],
                'ticket_hash' => $row['n_ingresso'],
                'ticket_type' => $row['tipo_de_ingresso'],
                'ticket_value' => $row['valor'],
                'purchase_date' => $row['data_compra'],
                'order_hash' => $row['n_pedido'],
                'payment_status' => $row['estado_do_pagamento'],
                'check_in' => $row['check_in'],
                'check_in_date' => $row['data_check_in'],
                'discount_code' => $row['codigo_desconto'],
                'payment_method' => $row['metodo_pagamento'],
            ]);
        }
    }
}
