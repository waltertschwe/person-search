<?php

App::uses('ConnectionManager', 'Model');
class PersonsComponent extends Component {
    
     public function __construct() {
        $this->Person = ClassRegistry::init('Person');
     }

     public function getPersonsNoAddress($lastName, $address, $gender) {
        $db = ConnectionManager::getDataSource('default');
		
		$lastName = "Smith";
		$gender = "M";
		
		
		$conditions = "WHERE last_name = " . $lastName . " AND address = " . $address . " AND gender = " . $gender;
		
        $query = "SELECT p.person_id, p.first_name, p.last_name, p.gender, 
                         GROUP_CONCAT(DISTINCT(pa.address_id)) AS pa_id, 
                         GROUP_CONCAT(DISTINCT(pra.research_area_id)) AS pra_id
                  FROM person p 
                      LEFT JOIN person_address pa
                      ON p.person_id = pa.person_id
                      LEFT JOIN person_research_area pra
                      ON p.person_id = pra.person_id
                  GROUP BY p.person_id " . 
                  $conditions;
                
				
        $results = $this->Person->query($query);
        return $results;
		
    }
	 
	public function getAddressById($addressId) {
		
	} 
	
	public function getResearchAreaById($researchId) {
		
	}
	 
	 
}
