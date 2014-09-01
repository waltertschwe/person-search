
<?php echo '<div class="flash-buffer">' . $this->Session->flash('auth') . '</div>'; ?>
<div class="top-buffer"></div>
<div class="container">
      <?php echo $this->Form->create('User', array('class' => 'form-signin')); ?>
        <h2 class="form-signin-heading">Please sign in</h2>
        <?php echo $this->Form->input('username');
        echo $this->Form->input('password');
    ?>
<div class="submit"> <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button></div>
</div> <!-- /container -->
