<?php

App::uses('ConnectionManager', 'Model');
class PersonsComponent extends Component {
    
     public function __construct() {
     	$db = ConnectionManager::getDataSource('default');
        $this->Person = ClassRegistry::init('Person');
     }
	 
	 public function getPersonWithAddress($lastName, $address, $gender) {
	 
		$conditions = "WHERE p.last_name = " . "\"".$lastName."\" 
		               AND p.gender = " . "\"".$gender."\"
		               ";
		
        $query = "SELECT p.person_id, p.first_name, p.last_name, p.gender, 
                         a.street, a.city, a.state, a.zip,  
                         GROUP_CONCAT(DISTINCT(pra.research_area_id)) AS pra_id
                  FROM person p
                      INNER JOIN address a
                      ON a.street = "."\"".$address."\"
                      LEFT JOIN person_research_area pra
                      ON p.person_id = pra.person_id
                  " . $conditions . "
                  GROUP BY p.person_id
                 ";
				
        $results = $this->Person->query($query);
		
        return $results;
		
     }
	 	

     # 
     #  Searches for users based off only a last name and gender.
     #  User did not enter an address
	 #
     public function getPersonsNoAddress($lastName, $gender) {
       	
		$conditions = "WHERE p.last_name = " . "\"".$lastName."\"
					   AND p.gender = " . "\"".$gender."\"
					  ";
		
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
 
    public function getPersonIdsMultipleAreas() {
    	
		## first part of the query counts person_id that are greater than one
		## second part of the query returns the person_id and research_area_id's that met condition
		$tableData = $this->Person->query("
		    SELECT p.person_id, p.research_area_id
		    FROM person_research_area p
		    INNER JOIN (
		        SELECT person_id, COUNT(*)
		        FROM person_research_area
		        GROUP BY person_id
		        HAVING COUNT(*) > 1) temp
		        ON temp.person_id = p.person_id
		        ORDER BY person_id
		");
		
		## key for array will be the person_id
		## values of the array will be the research area ids
		$userData = array();
		foreach($tableData as $result) {
			$personId = $result['p']['person_id'];
			$researchId = $result['p']['research_area_id'];
			$userData[$personId][] = $researchId;
		}
		
		return $userData;
		
    }
	
		 
	public function getPersonDataById($personId) {
	 	
		$conditions = "WHERE p.person_id = " . $personId;
		
		$query =  "SELECT p.first_name, p.last_name, p.gender
		          FROM person p " . 
		          $conditions;
		$results = $this->Person->query($query); 
		
		return $results;     
	 
	 }
	 
	 public function getPersonAddressIds($personId) {
	 	
	 	$conditions = " WHERE person_id = " . $personId;
		
		$query =  "SELECT pa.address_id
				  FROM person_address pa" . 
				  $conditions;
				  
		$results = $this->Person->query($query);

		return $results;
				
	 }
	 
	 public function getResearchAreaId($name) {
	 	
		$conditions = "WHERE name = "  . "\"".$name."\"";
		
		$query = "SELECT research_area_id 
				  FROM research_area " . 
				  $conditions;
		
		$results = $this->Person->query($query);
		$researchAreaId = $results[0]['research_area']['research_area_id'];
       
	    return $researchAreaId;
				  
	 }
	 
	 
	public function getPersonCompSciIds($compSciId, $bioId) {
	 	
		$query = "SELECT pra.person_id
				  FROM person_research_area pra
				  WHERE (pra.research_area_id <> 2 and
				  pra.research_area_id = 1 and pra.research_area_id <>  3)
				 
				  
				  ";
				  
	    $results = $this->Person->query($query);
		var_dump($results);
		exit();
		return $results;
		
	}
	
	
	## Inserts Record Into ORM exmample commented out
	public function insertPersonRecord($firstName, $lastName, $gender) {

	    $query = "INSERT INTO person (first_name, last_name, gender)
	              VALUES (" . "\"".$firstName."\","
	                           . "\"".$lastName."\","
	               			   . "\"".$gender."\"
	              )"; 
				  
	    $results = $this->Person->query($query);      
		
		 /*
		  NOT USING ORM
	    $personArray = array();	
		$personArray['Person']['first_name'] = $firstName;
		$personArray['Person']['last_name'] = $lastName;
		$personArray['Person']['gender'] = $gender;
		$this->Person->save($personArray);
		*/    
	}
	 
	


	 
}
