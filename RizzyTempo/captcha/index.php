<html>  
<head>  
    <title>Login Form</title>  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
</head>
<style>
 .box
 {
  width:100%;
  max-width:600px;
  background-color:#f9f9f9;
  border:1px solid #ccc;
  border-radius:5px;
  padding:16px;
  margin:0 auto;
 }
 .captcha
{
  width: 50%;
  background: yellow;
  text-align: center;
  font-size: 24px;
  font-weight: 700;
} 
</style>
<?php
include('connection.php');
$rand = rand(9999,1000);
if(isset($_REQUEST['login']))
{
  $email = $_REQUEST['email'];
  $pwd = md5($_REQUEST['pwd']);
  $captcha = $_REQUEST['captcha'];
  $captcharandom = $_REQUEST['captcha-rand'];

  if($captcha!=$captcharandom)
  {?>
    <script type="text/javascript">
      alert("Invalid captcha value");
    </script>
<?php
  }
  else
  {
     $select_query = mysqli_query($connection, "select * from tbl_student where email='$email' and password='$pwd'");
     $result = mysqli_num_rows($select_query);
     if($result>0)
     {?>
      <script type="text/javascript">
        alert("Login success");
      </script>
     <?php }
     else
     {?>
      <script type="text/javascript">
        alert("Invalid email or password");
      </script>
    <?php }
  }
}
?>
<body>  
    <div class="container">  
    <div class="table-responsive">  
    <h3 align="center">Login Form</h3><br/>
     <div class="box">
     <form id="validate_form" method="post" >
     <div class="form-group">
       <label for="email">Email</label>
       <input type="text" name="email" id="email" placeholder="Enter Email" required class="form-control"/>
     </div> 
     <div class="form-group">
       <label for="password">Password</label>
       <input type="password" name="pwd" id="pwd" placeholder="Enter Password" required class="form-control"/>
     </div> 
     <div class="col-md-6 form-group">
       <label for="captcha">Captcha</label>
       <input type="text" name="captcha" id="captcha" placeholder="Enter Captcha" required class="form-control"/>
       <input type="hidden" name="captcha-rand" value="<?php echo $rand; ?>">
     </div>
     <div class="col-md-6 form-group">
       <label for="captcha-code">Captcha Code</label>
       <div class="captcha"><?php echo $rand; ?></div>
     </div>
      <div class="form-group">
       <input type="submit" id="login" name="login" value="LogIn" class="btn btn-success"/>
      </div>
     </form>
     </div>
   </div>  
  </div>
 </body>  
</html>