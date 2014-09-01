<!doctype html>
<html lang="en">
<head>
<title>Programming Test</title>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/blitzer/jquery-ui.css" type="text/css" />
<?php echo $this->Html->css('demo_page'); ?>
<?php echo $this->Html->css('demo_table'); ?>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>

<?php echo $this->Html->script('jquery.easy-confirm-dialog.min'); ?>
<?php echo $this->Html->script('jquery.dataTables.min'); ?>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $('#example').dataTable( {
         "sDom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
        });
      
        $('.link').tooltip()
       
        $(".delbtn").easyconfirm();
            $("#alert").click(function() {
                alert("You approved the action");
            });
        });
        
        
</script>

</head>
<body>
    <?php echo $this->element('nav'); ?>
    <?php echo $this->fetch('content'); ?>
</body>
</html>