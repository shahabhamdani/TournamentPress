<?php
//echo "group delete";
function register_tournament(){

    global $i;
    
    if(isset($_GET['id'])){
        global $wpdb;
        $i=$_GET['id'];


        ?>


<form  action="#" method="post">

<br>
<br>
        <input type="text" name="prize" placeholder="Prize">
        <br>

        <br>
        <textarea  name="desc" placeholder="Description" rows="4" cols="23"></textarea>
        <br>

        <input type="submit" name="tform" >
        <br>
        <br>


        </form>

        <?php


    }

    if(isset($_POST['tform'])){


        $grpTable=$wpdb->prefix.'group';
        
        $prize = $_POST['prize'];
        $desc = $_POST['desc'];
        
        $wpdb->update(
            $grpTable,
            array(
                'Prize' => $prize,
                'Description' => $desc,
                'TournamentStatus' => 1,
        
            ),
            array(
                'GroupID' => $i,
            )
        );
        
        if($wpdb){
            echo "Tournament Registered! Please Go to Tournament Details";
        }
        else{
            echo "Not Registered Database error";

        }

        
        }       
        
    ?>
    <?php
    exit;
    //header("location:http://localhost/wordpressmyplugin/wordpress/wp-admin/admin.php?page=Employee_Listing");
}
?>