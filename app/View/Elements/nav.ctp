<!-- Fixed navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">NYU Medical Center</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="/nyu/persons/">Dashboard</a></li>
            <li><a href="/nyu/persons/multiple_area">Multiple Area</a></li>
            <li><a href="/nyu/persons/report_non_intersection">Report Non Intersection</a></li> 
            <li><a href="/nyu/persons/upload">Upload</a></li>
          </ul>
           <ul class="nav pull-right">
             <li><?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout')); ?></li>
         </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>