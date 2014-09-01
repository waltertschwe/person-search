<div class="container">
<div class="page-header">
</div>
<div class="well">
<p> <strong>Persons Search</strong></p>
<form method="POST" action="/nyu/persons/">
<div class="row">
    <div class="col-xs-4">
        <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            <input name="last_name" type="text" class="form-control" placeholder="Last Name" required="required">
        </div>
    </div>
    <div class="col-xs-4">
       <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-home"></span></span>
            <input name="address" type="text" class="form-control" placeholder="Address">
        </div>
    </div>
    <div class="col-xs-2">
        <div class="input-group">
             <select class="form-control" id="gender" name="gender">
                 <option value="M">Male</option>
                 <option value="F">Female</option>
            </select>          
        </div>
    </div>
    <div class="col-xs-2">
    <div class="input-group">
        <div class="col-sm-offset-2 col-sm-10">
             <button name="submit" type="submit" class="btn btn-success">Search</button>
        </div>
    </div>
</div>
</form>
</div>
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
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            foreach($results as $result) {  ?>
        <tr class="gradeC">
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
            <td>
            	<a href="/nyu/persons/json/<?php echo $result['person_id']; ?>"><?php echo $this->Html->image('json'); ?></a>
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
            <th>Actions</th>
        </tr>
    </tfoot>
</table>
<?php } ?>