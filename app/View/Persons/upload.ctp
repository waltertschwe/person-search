<div class="container">	
<div class="page-header">
<?php echo $this->Session->flash(); ?>
</div>
<div class="well">
<p> <strong>Upload Person Data</strong></p>
<form method="POST" action="/nyu/persons/upload" enctype="multipart/form-data">
	
<div class="row">
<div class="col-xs-4">
    <div class="input-group">
        <div class="col-sm-offset-2 col-sm-10">	
            <input name="file1" id="input-1" type="file" class="file" required="required">
        </div>
    </div>
</div>
<div class="col-xs-2">
    <div class="input-group">
        <div class="col-sm-offset-2 col-sm-10">
             <button name="submit" type="submit" class="btn btn-success">Upload</button>
        </div>
    </div>
   </div>
</div>
</div>
</form>