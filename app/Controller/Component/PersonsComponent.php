<?php

App::uses('ConnectionManager', 'Model');
class PersonsComponent extends Component {
    
     public function __construct() {
     	$db = ConnectionManager::getDataSource('default');
        $this->Person = ClassRegistry::init('Person');
     }

     # 
     #  Searches for users based off only a last name and gender.
     #  User did not enter an address
	 #
     public function getPersonsNoAddress($lastName, $gender) {
       
		
		$lastName = "Smith";
		$gender = "M";
		
		$conditions = "WHERE p.last_name = " . "\"".$lastName."\"";
		
        $query = "SELECT p.person_id, p.first_name, p.last_name, p.gender, 
                         GROUP_CONCAT(DISTINCT(pa.address_id)) AS pa_id, 
                         GROUP_CONCAT(DISTINCT(pra.research_area_id)) AS pra_id
                  FROM person p 
                      LEFT JOIN person_address pa
                      ON p.person_id = pa.person_id
                      LEFT JOIN person_research_area pra
                      ON p.person_id = pra.person_id
                  " . $conditions . "
                  GROUP BY p.person_id
                 ";
				
        $results = $this->Person->query($query);
        return $results;
		
    }
	
	public function getAddressById($addressId) {
	
	    $conditions = "WHERE address_id = " . $addressId;		
		$query = "SELECT street, city, state, zip
		          FROM address " . 
		          $conditions;
		
	    $results = $this->Person->query($query);		
		$addressData = $results[0]['address']['street'] . " " .
					   $results[0]['address']['city'] . " " .
					   $results[0]['address']['state'] . " " .
					   $results[0]['address']['zip'];
					   
		return $addressData;
		   
	} 
	
	public function getResearchAreaById($researchId) {
		
		$conditions = "WHERE research_area_id = " . $researchId;
		$query = "SELECT name
		          FROM research_area " . 
		          $conditions;
		
	    $results = $this->Person->query($query);
	    $researchArea = $results[0]['research_area']['name'];
	    			   
		return $researchArea;
	
	}
	
	public function getPersonId($lastName) {
		
		$lastName = "Smith";
		$conditions = "WHERE p.last_name = " . "\"".$lastName."\"";
		$query = "SELECT p.person_id 
		          FROM person p " 
		          . $conditions;
		
		$results = $this->Person->query($query);
	
	}  
	 
}
