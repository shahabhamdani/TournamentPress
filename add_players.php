<?php
function add_players()
{

    global $i;
    if (isset($_GET['id'])) {

        $i = $_GET['id'];
    }
?>

    <style>
        .playersLayout {
            margin: 20px;
        }

        .btn {
            margin-top: 10px;
        }
    </style>

    <div class="playersLayout">


    <form name="countForm" action="#" method="post">


        <h3>Players Count</h3> <input type="text" name="playerCount" /><br>
        <input class="btn" type="submit" value="Enter" name="count" />

        <br>
        <hr>
        <br>
    </form>
    </div>

    <form name="countForm" action="#" method="post">

<?php

if (isset($_POST['count'])) {

    $count = $_POST['playerCount'];


    for($x=0; $x<$count; $x++) {
?>
        <input style="margin: 10px;" placeholder="Player<?= $x?> Name" name="<?=$x?>"/>

 <?php
    } ?>

<input hidden value="<?= $count ?>" name="pCount"> 
<br>
<input class="btn" type="submit" value="Add Players" name="addPlayers" />

    </form>

<?php
}



if (isset($_POST['addPlayers'])) {

    $pCount = $_POST['pCount'];

    global $wpdb;
    $playerTable = $wpdb->prefix . 'player';


    for($j=0; $j<$pCount; $j++) {
    $temp = $_POST[''.$j.''];

    $check = $wpdb->insert(
        $playerTable,
        array(
            'PlayerName' => $temp,
            'MemberID' => $i
        )
    );

    if($check){
        echo "Inserted! Please Go Back";
    }
    

    }
}
}
?>