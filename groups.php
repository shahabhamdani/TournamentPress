<?php

function groups()
{


    global $wpdb;
    global $seasonDetails;
    $seasonDetails = $wpdb->get_results("SELECT `Duration`, `Description`, `Prize`  FROM `wp_season` WHERE SeasonID= 1");
    
            

    function registerGroup($id)
    {

        global $wpdb;
        $groupTable = $wpdb->prefix . 'group';
        $r16Table = $wpdb->prefix . 'round16';
        $qFinalTable = $wpdb->prefix . 'quater_final';
        $sFinalTable = $wpdb->prefix . 'semi_final';
        $finalTable = $wpdb->prefix . 'final';

        $tournamentStatus = $wpdb->get_results("SELECT `TournamentStatus` FROM $groupTable WHERE GroupID= $id");


        if ($tournamentStatus[0]->TournamentStatus == 0) {

            $wpdb->update(
                $groupTable,
                array(
                    'TournamentStatus' => 1,
                ),
                array(
                    'GroupID' => $id
                )
            );

            for ($x = 0; $x < 8; $x++) {

                if ($x < 1) {
                    $wpdb->insert(
                        $finalTable,
                        array(
                            'GroupID' => $id
                        )
                    );
                }

                if ($x < 4) {

                    $wpdb->insert(
                        $qFinalTable,
                        array(
                            'GroupID' => $id
                        )
                    );
                }

                if ($x < 2) {

                    $wpdb->insert(
                        $sFinalTable,
                        array(
                            'GroupID' => $id
                        )
                    );
                }

                $wpdb->insert(
                    $r16Table,
                    array(
                        'GroupID' => $id
                    )
                );
            }
        } else {
            echo '<script>alert("Tournament Already Created")</script>';
        }
    }

?>
<!--
<style>
table {
    border-collapse: collapse;
}


.groupName {
    margin-bottom: 20px;
    font-size: 15px;
    font-weight: 600;
    margin-top: 70px;
}




 input[type=text] {
  width: 100%;
  padding: 5px 10px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

.wrap{
    font-family: monospace;

}

input[type=submit] {
  width: 100%;
  background-color: #377dff;
  color: white;
  padding: 14px 20px;
  margin: 5px 0;
  border: none;
  border-radius: 4px;

  cursor: pointer;
}


.update{
    width: 100%;
  background-color: #ef8b00db;
  color: white;
  padding: 5px 10px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}


.delete{
    width: 100%;
  background-color: #e70000c4;
  color: white;
  padding: 5px 10px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}




.groupTable td,
.groupTable th {
    border: 1px solid black;
    text-align: center;
}

.groupTable{
    margin-top: 35px;
}
</style>
-->

<style>
.teamTable {
    margin-top: 50px;
    text-align: left;

}

.seasonLayout input {
    width: 175px;
    margin-bottom: 5px;
}

.groupTable td,
.groupTable th {
    border: 1px dotted;
    text-align: center;
    padding: 5px;
}

.groupTable {
    margin-top: 35px;
}
</style>


<br>
<hr>
<h1 style="font-size: 30px;">TournamentPress</h1>
<hr>


<div class="wrap">

    <!--META BOXES FOR STYLING MORE
<div id="normal-sortables" class="meta-box-sortables ui-sortable">
    <div id="e-dashboard-overview" class="postbox ">

    <div class="postbox-header"><h2 class="hndle ui-sortable-handle">Elementor Overview</h2>

    <div class="handle-actions hide-if-no-js"><button type="button" class="handle-order-higher" aria-disabled="true" aria-describedby="e-dashboard-overview-handle-order-higher-description"><span class="screen-reader-text">Move up</span><span class="order-higher-indicator" aria-hidden="true"></span></button><span class="hidden" id="e-dashboard-overview-handle-order-higher-description">Move Elementor Overview box up</span><button type="button" class="handle-order-lower" aria-disabled="false" aria-describedby="e-dashboard-overview-handle-order-lower-description"><span class="screen-reader-text">Move down</span><span class="order-lower-indicator" aria-hidden="true"></span></button><span class="hidden" id="e-dashboard-overview-handle-order-lower-description">Move Elementor Overview box down</span><button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text">Toggle panel: Elementor Overview</span><span class="toggle-indicator" aria-hidden="true"></span></button></div></div><div class="inside">
		
		</div>


    </div>

    <div id="dashboard_site_health" class="postbox ">

    
<div class="postbox-header"><h2 class="hndle ui-sortable-handle">Site Health Status</h2>

    <div class="handle-actions hide-if-no-js"><button type="button" class="handle-order-higher" aria-disabled="false" aria-describedby="dashboard_site_health-handle-order-higher-description"><span class="screen-reader-text">Move up</span><span class="order-higher-indicator" aria-hidden="true"></span></button><span class="hidden" id="dashboard_site_health-handle-order-higher-description">Move Site Health Status box up</span><button type="button" class="handle-order-lower" aria-disabled="false" aria-describedby="dashboard_site_health-handle-order-lower-description"><span class="screen-reader-text">Move down</span><span class="order-lower-indicator" aria-hidden="true"></span></button><span class="hidden" id="dashboard_site_health-handle-order-lower-description">Move Site Health Status box down</span><button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text">Toggle panel: Site Health Status</span><span class="toggle-indicator" aria-hidden="true"></span></button></div></div><div class="inside">
	

	</div>
</div>

-->


    <!-- Season Layout-->
    <div class="seasonLayout">
        <form name="seasonForm" action="#" method="post">
            <br>

            <h1><b>Season</b></h1>
            <hr>
            <h3>Season Duration</h3>

            <input name="season_duration" type="range" min="1" max="12" value="<?=$seasonDetails[0]->Duration ?>"
                class="slider" id="myRange">
            <p><span id="demo"></span> <b> Months</b></p>


            <input placeholder="Prize" type="text" name="prize" value="<?=$seasonDetails[0]->Prize ?>" /><br>
            <textarea placeholder="Description" rows="4" cols="23"
                name="season_description"><?=$seasonDetails[0]->Description ?></textarea>



            <script>
            var slider = document.getElementById("myRange");
            var output = document.getElementById("demo");
            output.innerHTML = slider.value;

            slider.oninput = function() {
                output.innerHTML = this.value;
            }
            </script>


            <br>
            <input type="submit" value="Update Season" name="seasonSubmit">

        </form>

    </div>


    <br>
    <br>

    <h1><b>Create Group</b></h1>
    <hr>

    <table class="teamTable" width="100%" cellspacing="0">

        <form name="GroupForm" action="#" method="post">

            <thead>
                <tr>

                    <div class="groupName">

                        <input style="width:30%!important; margin-top: 20px;" placeholder="Group Name" type="text"
                            required name="grpName" />

                    </div>
                </tr>
            </thead>

            <thead>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        Team Name
                    </th>

                    <th>

                    </th>

                    <th>
                        #
                    </th>

                    <th>Team Name</th>
                    <th>

                    </th>

                    <th>
                        #
                    </th>

                    <th>Team Name</th>
                    <th>

                    </th>

                    <th>
                        #
                    </th>

                    <th>Team Name</th>

                </tr>

            </thead>

            <tbody>

                <tr>
                    <td>
                        1
                    </td>
                    <td>
                        <input type="text" required value="Team1" name="m1" required />
                    </td>

                    <td>
                    <td>
                        2
                    </td>
                    <td>
                        <input type="text" required value="Team2" name="m2" required />
                    </td>

                    <td>
                    <td>
                        3
                    </td>
                    <td>
                        <input type="text" required value="Team3" name="m3" required />
                    </td>
                    <td>
                    <td>
                        4
                    </td>
                    <td>
                        <input type="text" required value="Team4" name="m4" />
                    </td>
                    </td>
                </tr>

                <tr>
                    <td>
                        5
                    </td>
                    <td>
                        <input type="text" required value="Team5" name="m5" />
                    </td>

                    <td>
                    <td>
                        6
                    </td>
                    <td>
                        <input type="text" required value="Team6" name="m6" />
                    </td>

                    <td>
                    <td>
                        7
                    </td>
                    <td>
                        <input type="text" required value="Team7" name="m7" />
                    </td>
                    <td>
                    <td>
                        8
                    </td>
                    <td>
                        <input type="text" required value="Team8" name="m8" />
                    </td>
                    </td>
                </tr>
                <tr>
                    <td>
                        9
                    </td>
                    <td>
                        <input type="text" required value="Team9" name="m9" />
                    </td>

                    <td>
                    <td>
                        10
                    </td>
                    <td>
                        <input type="text" required value="Team10" name="m10" />
                    </td>

                    <td>
                    <td>
                        11
                    </td>
                    <td>
                        <input type="text" required value="Team11" name="m11" />
                    </td>
                    <td>
                    <td>
                        12
                    </td>
                    <td>
                        <input type="text" required value="Team12" name="m12" />
                    </td>
                    </td>
                </tr>
                <tr>
                    <td>
                        13
                    </td>
                    <td>
                        <input type="text" required value="Team13" name="m13" />
                    </td>

                    <td>
                    <td>
                        14
                    </td>
                    <td>
                        <input type="text" required value="Team14" name="m14" />
                    </td>

                    <td>
                    <td>
                        15
                    </td>
                    <td>
                        <input type="text" required value="Team15" name="m15" />
                    </td>
                    <td>
                    <td>
                        16
                    </td>
                    <td>
                        <input type="text" required value="Team16" name="m16" />
                    </td>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="11"><input style=" margin-top:10px;" type="submit" value="Create Group" name="grp">
                    </td>
                </tr>


            </tbody>

        </form>

    </table>
    <br>
    <br>
    <h1><b>Groups</b></h1>
    <hr>

    <table class="groupTable" id="groupTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Short Code</th>
                <th>Group Name</th>
                <th>Teams</th>
                <th>Delete</th>
                <th>Register Tournament</th>

            </tr>
        </thead>
        <tbody>
            <?php
                global $wpdb;
                $grp = $wpdb->prefix . 'group';
                $tempGroups = $wpdb->get_results("SELECT GroupID,GroupName from $grp");
                foreach ($tempGroups as $temp) {
                ?>
            <tr>
                <td> [group id="<?= $temp->GroupID; ?>"] </td>
                <td><?= $temp->GroupName; ?></td>
                <td><a class="update"
                        href="<?php echo admin_url('admin.php?page=View_Members&id=' . $temp->GroupID); ?>">View</a>
                </td>
                <td><a class="delete"
                        href="<?php echo admin_url('admin.php?page=Group_Delete&id=' . $temp->GroupID); ?>">
                        Delete</a></td>

                        <td><a class="reg"
                        href="<?php echo admin_url('admin.php?page=Register_Tournament&id=' . $temp->GroupID); ?>">
                        Register</a></td>

           





            </tr>
            <?php } ?>
        </tbody>
    </table>


    <?php



            
if (isset($_POST['seasonSubmit'])) {

    echo("<meta http-equiv='refresh' content='0'>");



    $duration = $_POST['season_duration'];
    $prize = $_POST['prize'];
    $description = $_POST['season_description'];    

    global $wpdb;
    
    $seasonTable = $wpdb->prefix . 'season';
    
        $wpdb->update(
            $seasonTable,
            array(
                'Description' => $description,
                'Prize' => $prize ,
                'Duration' => $duration
            ),
            array(
                'SeasonID' => 1
            )
        );        
        
    }


        if (isset($_POST['insert'])) {
            $tempID = $_POST['grpID'];

            registerGroup($tempID);
        }

        if (isset($_POST['grp'])) {

            $m1 = $_POST['m1'];
            $m2 = $_POST['m2'];
            $m3 = $_POST['m3'];
            $m4 = $_POST['m4'];
            $m5 = $_POST['m5'];
            $m6 = $_POST['m6'];
            $m7 = $_POST['m7'];
            $m8 = $_POST['m8'];
            $m9 = $_POST['m9'];
            $m10 = $_POST['m10'];
            $m11 = $_POST['m11'];
            $m12 = $_POST['m12'];
            $m13 = $_POST['m13'];
            $m14 = $_POST['m14'];
            $m15 = $_POST['m15'];
            $m16 = $_POST['m16'];
            $grpName = $_POST['grpName'];

            $grpTable = $wpdb->prefix . 'group';
            $memberTable = $wpdb->prefix . 'member';



            $a = array($m1, $m2, $m3, $m4, $m5, $m6, $m7, $m8, $m9, $m10, $m11, $m12, $m13, $m14, $m15, $m16);

            global $i;

            $i = $wpdb->insert(

                $grpTable,
                array(
                    'GroupName' => $grpName
                )
            );




            if ($i) {


                $grpID = $wpdb->get_results("SELECT GroupID from $grpTable where GroupName='$grpName'");


                $round16Table = $wpdb->prefix . 'round16';
                $quaterFinalTable = $wpdb->prefix . 'quater_final';
                $semiFinalTable = $wpdb->prefix . 'semi_final';
                $finalTable = $wpdb->prefix . 'final';
                
                foreach ($a as $item) {


                    $wpdb->insert(
                        $memberTable,
                        array(
                            'MemberName' => $item,
                            'Win' => 0,
                            'GroupID' => $grpID[0]->GroupID

                        )
                    );
                }


                for($x=0; $x<16; $x++){

                if($x < 8){
                    $wpdb->insert(
                        $quaterFinalTable,
                        array(
                            'GroupID' => $grpID[0]->GroupID
                        )
                    ); 
                }

                if($x < 4){
                    $wpdb->insert(
                        $semiFinalTable,
                        array(
                            'GroupID' => $grpID[0]->GroupID
                        )
                    ); 
                }

                if($x < 2){
                    $wpdb->insert(
                        $finalTable,
                        array(
                            'GroupID' => $grpID[0]->GroupID
                        )
                    ); 
                }

                    $wpdb->insert(
                        $round16Table,
                        array(
                            'GroupID' => $grpID[0]->GroupID
                        )
                    );
                }

            



                echo "inserted";
            } else {
                echo '<script>alert("Sorry! Group Name Already Exist")</script>';
            }

            // wp_redirect( admin_url('admin.php?page=page=Employee_List'),301 );

            //header("location:http://localhost/wordpressmyplugin/wordpress/wp-admin/admin.php?page=Employee_Listing");
            //  header("http://google.com");


        ?>

</div>

<meta http-equiv="refresh" content="1; url=#" />

<?php


        }
    }
?>