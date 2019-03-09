<?php $link = HOMEURL."index.php" ?>
<div class="container">

  <div class="row" style="height: 200px;"></div>   <!-- Extra space on top-->
  <form action="<?php echo $link?>" method="post">
    <div class="row justify-content-md-center">
      <div class="col-md-2 ml-5">
        <h1>Login</h1>
      </div>
      <div class="w-100"></div>
      <div class="col-md-2 mt-1">
        <input type="text" name="username" value="" placeholder="Username">
      </div>
      <div class="w-100"></div>
      <!-- mt-1 sets the margin top to 1pt; -->
      <div class="col-md-2 mt-1">
          <input type="password" name="password" value="" placeholder="Password">
      </div>
      <div class="w-100"></div>
      <div class="col-md-2 mt-1">
        <div class="d-flex justify-content-center">
           <button type="submit" class="btn btn-outline-dark rad" name="Submit">Submit</button>
        </div>
      </div>
    </div>
  </form>
</div>
