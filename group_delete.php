<?php
//echo "group delete";
function group_delete(){

    
    if(isset($_GET['id'])){
        global $wpdb;
        $grpTable=$wpdb->prefix.'group';
        $membersTable=$wpdb->prefix.'member';
        $round16Table = $wpdb->prefix . 'round16';
        $quaterFinalTable = $wpdb->prefix . 'quater_final';
        $semiFinalTable = $wpdb->prefix . 'semi_final';
        $finalTable = $wpdb->prefix . 'final';
    
        
        $i=$_GET['id'];

        $wpdb->delete(
            $membersTable,
            array('GroupID'=>$i)
        );

    
        $wpdb->delete(
            $round16Table,
            array('GroupID'=>$i)
        );

        $wpdb->delete(
            $quaterFinalTable,
            array('GroupID'=>$i)
        );

        $wpdb->delete(
            $semiFinalTable,
            array('GroupID'=>$i)
        );

        $wpdb->delete(
            $finalTable,
            array('GroupID'=>$i)
        );

        $wpdb->delete(
            $grpTable,
            array('GroupID'=>$i)
        );

      



        echo "deleted";
        



    }
    ?>
    <?php
    //wp_redirect( admin_url('admin.php?page=page=Employee_List'),301 );
    //exit;
    //header("location:http://localhost/wordpressmyplugin/wordpress/wp-admin/admin.php?page=Employee_Listing");
}
?>