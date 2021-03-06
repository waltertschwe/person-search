<?php

App::uses('PersonsComponent', 'Controller/Component');
class PersonsController extends AppController {
    
    public $name = "Persons";
    public $uses = array('Person');
    public $components = array('Persons');
    
    public function index() {
    	
        $this->layout = 'datatables';
        $this->Person->useTable = 'person';
        
        if ($this->request->is('post')) {
           $data = $this->request->data;
           $lastName = $data['last_name'];
           $address  = $data['address'];
           $gender   = $data['gender'];
           $usersData = array();
		   
		   ## Search for User based on Last Name and Gender
		   if(empty($address)) {
               $results = $this->Persons->getPersonsNoAddress($lastName, $gender);
		   } else {   
			   $results = $this->Persons->getPersonWithAddress($lastName, $address, $gender);
		   }
			   
		   $userCounter = 0;
		   foreach($results as $result) {
		   	   $usersData[$userCounter]['person_id'] = $result['p']['person_id'];
		   	   $usersData[$userCounter]['last_name'] = $result['p']['last_name'];
			   $usersData[$userCounter]['first_name'] = $result['p']['first_name'];
			   $usersData[$userCounter]['gender'] = $result['p']['gender'];
		   	  
			   if(empty($address)) {
			       if(isset($result[0]['pa_id'])) {
		               $paIds = explode(",", $result[0]['pa_id']);
			       }
				   
				   if(!empty($paIds)) {
					   $addressCounter = 0;
				       foreach($paIds as $paId) {
					       if(!empty($paId)) {
						      $addressData = $this->Persons->getAddressById($paId);  
		                      $usersData[$userCounter]['address'][$addressCounter] = $addressData;					  
						      $addressCounter++;
					       }
			           }
				   }
			   } else {
			 	   if(isset($result['a'])) {
				   	   $addressData = $result['a']['street'] . " " .  $result['a']['city'] . " " . 
				   	                  $result['a']['state'] . " " . $result['a']['zip'];
									  
				       $usersData[$userCounter]['address'][] = $addressData;
				   }
			   }
			   
			    if(isset($result[0]['pra_id'])) {
			       $raIds = explode(",", $result[0]['pra_id']);
				   $researchCounter = 0;
			   	   foreach($raIds as $raId) {
				       if(!empty($raId)) {
				       	   $researchData = $this->Persons->getResearchAreaById($raId);
						   $usersData[$userCounter]['research'][$researchCounter] = $researchData;
						   $researchCounter++; 
				        }
	                }
			   }
			   
			  
			  		   
		       $userCounter++; 
            }

		    $this->set('results', $usersData); 
        } 
    }   
    
	public function multiple_area() {
		$this->layout = 'datatables';
        $this->Person->useTable = 'person';
		$usersData = array();
		
		$idsData = $this->Persons->getPersonIdsMultipleAreas(); 
		$userCounter = 0; 
		
		## key = person_ids, values = research_area_ids
		foreach($idsData as $key => $values) {
			
			## Model Calls to get data
			$personData = $this->Persons->getPersonDataById($key);
			$addressIds = $this->Persons->getPersonAddressIds($key);
			
			## Person Data
			$usersData[$userCounter]['last_name'] = $personData[0]['p']['last_name'];
		    $usersData[$userCounter]['first_name'] = $personData[0]['p']['first_name'];
			$usersData[$userCounter]['gender'] = $personData[0]['p']['gender'];
			
			## Address Data
			$addressCounter = 0;
			if(!empty($addressIds)) {
			    foreach($addressIds as $addressData) {
					$addressId = $addressData['pa']['address_id'];
				    $addressData = $this->Persons->getAddressById($addressId);
					 $usersData[$userCounter]['address'][$addressCounter] = $addressData;					  
					 $addressCounter++;
		   	    }
			}

			## Research Data
			$researchCounter = 0;
			foreach($values as $researchId) {
		        if(!empty($researchId)) {
		       	   $researchData = $this->Persons->getResearchAreaById($researchId);
				   $usersData[$userCounter]['research'][$researchCounter] = $researchData;
				   $researchCounter++; 
		        }
			}
			
			$userCounter++;
		}
		
		  $this->set('results', $usersData);
	}
	
	public function report_non_intersection() {
		
		$this->layout = 'datatables';
        $this->Person->useTable = 'person';
		$usersData = array();
		$compSciId = $this->Persons->getResearchAreaId('Computer Science');
		$bioId = $this->Persons->getResearchAreaId('Bioengineering');
		
		$personIds = $this->Persons->getPersonCompSciIds($compSciId, $bioId); 
		$userCounter = 0;
		foreach($personIds as $personId) {
			$id = $personId['pra']['person_id'];
			$researchId = $personId['pra']['research_area_id'];
			$personData = $this->Persons->getPersonDataById($id);
			$addressIds = $this->Persons->getPersonAddressIds($id);
			$researchName = $this->Persons->getResearchNameById($researchId);
			
			## Person Data
			$usersData[$userCounter]['last_name'] = $personData[0]['p']['last_name'];
		    $usersData[$userCounter]['first_name'] = $personData[0]['p']['first_name'];
			$usersData[$userCounter]['gender'] = $personData[0]['p']['gender'];
			
			## Address Data
			$addressCounter = 0;
			if(!empty($addressIds)) {
			    foreach($addressIds as $addressData) {
					$addressId = $addressData['pa']['address_id'];
				    $addressData = $this->Persons->getAddressById($addressId);
					 $usersData[$userCounter]['address'][$addressCounter] = $addressData;					  
					 $addressCounter++;
		   	    }
			}
            
			## Research Area
			$usersData[$userCounter]['researchArea'] = $researchName;
 			
			
			$userCounter++;
		}
		$this->set('results', $usersData);
	}
	
	public function json($personId) {
		$this->autoRender = false;
		$this->Person->useTable = 'person';
		$userData = array();
		$userData = $this->Persons->getPersonDataById($personId);
		$results = json_encode($userData);
		
		echo $results;
	}
	
	public function upload() {
		$this->layout = 'datatables';
		$this->Person->useTable = 'person';
		
		if ($this->request->is('post')) {
		    
			$tmpFileName = $_FILES['file1']['tmp_name'];
			move_uploaded_file($tmpFileName, "/tmp/temp.xml");
			chmod("/tmp/temp.xml", 0777);
			
			$dom = new DOMDocument();
			$dom->load("/tmp/temp.xml");
			$isValid = $dom->schemaValidate("http://ec2-50-19-187-57.compute-1.amazonaws.com/nyu/xsd/persons.xsd");
			
			if($isValid) {
				$xml =  simplexml_load_file("/tmp/temp.xml");
				$persons = array();
				foreach($xml->xpath('//persons/person') as $person) { 
				    $firstName = (string) $person->first_name;
					$lastName = (string) $person->last_name;
					$gender = (string) $person->gender;
				    $this->Persons->insertPersonRecord($firstName, $lastName, $gender);
				}
				
				$this->Session->setFlash('custom message', 'flash_good');
			} else {
				$this->Session->setFlash('custom message', 'flash_bad');
			}
			
		}
	}
    
}
