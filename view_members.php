<?php
//echo "View Members";
function view_members(){

    if(isset($_GET['id'])){

    ?>

<style>
        table {
            border-collapse: collapse;


        }

        table, td, th {
            border: 1px solid black;
            padding: 20px;
            text-align: center;
        }
    </style>
    <div class="wrap">
        <table >
            <thead>
                <tr>
                    <th>#</th>
                    <th>Player Name</th>
                    <th>Add Players</th>

                </tr>
            </thead>
            <tbody>

            <?php
            global $wpdb;
            $i=$_GET['id'];
            $memberTable = $wpdb->prefix . 'member';
            $result = $wpdb->get_results("SELECT MemberID,MemberName from $memberTable WHERE GroupID ='$i'");
            foreach ($result as $temp) {
                ?>
                <tr>
                    <td><?= $temp->MemberID; ?></td>
                    <td><?= $temp->MemberName; ?></td>
                    <td><a class="update"
                        href="<?php echo admin_url('admin.php?page=Add_Players&id=' . $temp->MemberID); ?>">Add Players</a>                </tr>
            <?php } ?>


            </tbody>
        </table>
    </div>

 
 
 <?php
    }
}
?>