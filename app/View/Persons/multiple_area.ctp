<div class="container">
<div class="page-header">
</div>
<div class="well">
<p><strong>Users Studying Multiple Areas</strong></p>
</div>

<?php 
    if(isset($results)) {
?> 
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Address</th>
            <th>Research Areas</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            foreach($results as $result) {  ?>
        <tr class="gradeX">
            <td><?php echo $result['first_name']; ?></td>         
            <td><?php echo $result['last_name']; ?></td>
            <td><?php echo $result['gender']; ?></td>  
            <td>
            	<?php 
            		if(!empty($result['address'])) {
            			$addressCounter = 1;
            			$addressCount = count($result['address']);
            	        foreach($result['address'] as $address) {
            		        echo $address;
            		        if ($addressCounter < $addressCount) {
            		            echo ",<br/>";
							}
						    $addressCounter++;
            		    }
				    }
            	?>
            	
            </td>  
            <td>
            	<?php
            	    if(!empty($result['research'])) {
            	    	$researchCounter = 1;
						$researchCount = count($result['research']);
						foreach($result['research'] as $researchName) {
							echo $researchName;
							if($researchCounter < $researchCount) {
								echo ",<br/>";
							}
							$researchCounter++;
						}
            	    }
            	?>
            </td>                    
         </tr>
         <?php } ?>
        </tbody>
    <tfoot>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Address</th>
            <th>Research Areas</th>
        </tr>
    </tfoot>
</table>
<?php } ?>