<?php

/*
 * PHP class for working with table data
 * It's need for filtering data with special conditions, like WHERE from SQL
 */

class Table {

    private $table = array();
    private $tempArray = array();

    public function createHeader($arrayHeaderName) {
        foreach ($arrayHeaderName as $item) {
            $this->table[$item] = array();
        }
    }

    public function addCell($headerName, $value) {
        if (isset($this->table[$headerName]))
            $this->table[$headerName][] = $value;
    }

    public function select($keysStr='') {
        
        if($keysStr=='')
            $arrayHeaderName = array_keys($this->table);
        else {
            $arrayHeaderName = explode(",",$keysStr);
        }
     
       
       
        foreach ($arrayHeaderName as $item) {
            $this->tempArray[$item] = $this->table[$item];
        }
        return $this;
    }

    public function where($headerName, $condition, $value) {
        $arrayHeaderName = array_keys($this->tempArray);
        foreach ($this->tempArray[$headerName] as $index => $item) {
            switch ($condition) {
                case '>':
                    if($item <= $value ) {
                        foreach($arrayHeaderName as $header) {
                            unset($this->tempArray[$header][$index]);
                        }
                    }
                    break;
                case '<':
                    if($item >= $value ) {
                        foreach($arrayHeaderName as $header) {
                            unset($this->tempArray[$header][$index]);
                        }
                    }
                    break;
                case '=':
                    if($item != $value ) {
                        foreach($arrayHeaderName as $header) {
                            unset($this->tempArray[$header][$index]);
                        }
                    }
                    break;
                    
                case '!=':
                    if($item == $value ) {
                        foreach($arrayHeaderName as $header) {
                            unset($this->tempArray[$header][$index]);
                        }
                    }
                    break;
            }
        }

        return $this;
    }
    
    public function result() {
        
        $temp = array();
        
        $arrayHeaderName = array_keys($this->tempArray);
        foreach($arrayHeaderName as $headerName) {
            foreach ($this->tempArray[$headerName] as $index => $item) {
                $temp[$index][$headerName] = $item;
            }
        }
        return $temp;
    }

}

// Test
/*
$table = new Table();
$table->createHeader(array('id', 'user_id', 'price', 'date'));
$table->addCell('id', 1);
$table->addCell('user_id', 99);
$table->addCell('price', 199);
$table->addCell('date', 12345678);

$table->addCell('id', 2);
$table->addCell('user_id', 87);
$table->addCell('price', 368);
$table->addCell('date', 52325678);

$res = $table->select()->where('id', '>', 1)->result();


print_r($res);
 * 
 */
