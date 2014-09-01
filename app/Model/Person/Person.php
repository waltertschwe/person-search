
<?php

App::uses('AppModel', 'Model');
//App::uses('ConnectionManager', 'Model'); 

class Person extends AppModel {
    
    public $name = 'Person';    
    public $useTable = 'person';

    public function getPersons($lastName, $address, $gender) {
        //$db = ConnectionManager::getDataSource('default');
        //$results = $db->rawQuery('SELECT last_name FROM Person');
        $results = array("1" => "hello");
        
        return $results;
    }
    
    public function test() {
        $x = array("foo" => "bar");
        return $x;
    }
  
}
    