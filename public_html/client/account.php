<?php require('../../private-client/initialize.php'); ?>
<?php if(isset($_POST['btn'])): //if user changes something and submits?>
<?php
        checkLog(); //Check user login credentials
        require(P.'credentials.php');
        //validate input
        $Fname = validateInput($_POST['First']);
        $Lname = validateInput($_POST['Last']);
        $Mini = validateInput($_POST['Middle']);
        $Phone = validateInput($_POST['Phone']);
        $Email= validateInput($_POST['Email']);

        //update function
        $pk[0] = 'Username'; //pk of PERSON
        $pk[1] = $_SESSION['valid_user'];

        //RECORDS TO UPDATE
        $records['Fname'] = $Fname;
        $records['Lname'] = $Lname;
        $records['Mini'] = $Mini;
        $records['Phone'] = $Phone;

        if(Update($db, 'PERSON', $records, $pk)){
            $pk[0] = 'Cid';
            if(Update($db, 'CLIENT', ['Email'=>$Email], $pk)){
                $_SESSION['account_change'] = 'true';
                header("Location: ".HOMEURL.'client/account.php');
            }
        }
    ?>
<?php else: 
    $page_title = 'My Account';
    require (CLIENT.'head.php');
    checkLog(); //Check user login credentials
    makeNav($page_title);
    require(P.'credentials.php');
?>
    <div class="container">
      <?php
        if(isset($_SESSION['account_change'])){
            //if there was a change...
            echo centerRow(h('Updated succesfully', 20, 'light'));
            unset($_SESSION['account_change']);
            $selector = '$(".font-weight-light")';
            $css = 'css({"background":"green", "color":"white"})';
            $jquery = "$selector.$css;";
            echo "<script> $jquery </script>";
        }else {
            //else just put a blank space
            ediv(50);
        }
        $name = "Fname AS First, Mini AS Middle, Lname AS Last";
        $cond =  "WHERE Username='{$_SESSION['valid_user']}' AND Username=Cid";
        $query = "SELECT $name, Phone, Email  FROM PERSON, CLIENT $cond";
    //    Retreiving columns:
        //First, Middle, Last, Phone, Email
        $result = mysqli_query($db, $query);
        $record = mysqli_fetch_assoc($result);
        $style = 'style="padding-right: 20px;"'
       ?>
        <div class="row justify-content-center">
            <?php echo h('Your information:', 80, 'light')?>
        </div>
        <form action="account.php" method="post">
        <div class="row justify-content-center">
            <div class="col-4">
                <table>
                    <tr>
                        <td <?php echo $style;?>>First Name:</td>
                        <td>
                            <input type="text" name="First"
                            value="<?php  echo $record['First'] ;?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Middle:</td>
                        <td>
                            <input type="text" name="Middle"
                            value="<?php  echo $record['Middle'] ;?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Last:</td>
                        <td>
                            <input type="text" name="Last"
                            value="<?php  echo $record['Last'] ;?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <td>
                            <input type="text" name="Phone"
                            value="<?php  echo $record['Phone'] ;?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td>
                            <input type="text" name="Email"
                            value="<?php  echo $record['Email'] ;?>">
                        </td>
                    </tr>
                </table>
                <input type="submit" class="btn btn-outline-dark" name="btn" value="Submit changes">
            </div>
        </div>
        </form>
    </div>
<?php endif; ?>
<script>
    $("table").css('border', "none");
</script>
  <?php require_once(CLIENT . 'tidy-up.php'); ?>