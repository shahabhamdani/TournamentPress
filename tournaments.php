<?php

/**
 * Created by PhpStorm.
 * User: lcom53-two
 * Date: 2/12/2018
 * Time: 2:25 PM
 */
function tournaments()
{

    global $wpdb;
    global $memberList;
    global  $groupTable;
    global $memberTable;
    static $id;

    global $round16;
    global $quaterFinal;
    global $semiFinal;
    global $final;

    global $round16Table;
    global $quaterFinaleTable;
    global $semiFinalTable;
    global $winner;
    global $finalTable;



    $groupTable = $wpdb->prefix . 'group';
    $memberTable = $wpdb->prefix . 'member';
    $round16Table = $wpdb->prefix . 'round16';
    $quaterFinalTable = $wpdb->prefix . 'quater_final';
    $semiFinalTable = $wpdb->prefix . 'semi_final';
    $finalTable = $wpdb->prefix . 'final';


    function  getName($name)
    {


        if ($name != "0") {

            return $name;
        } else {
            return "none";
        }
    }


    //echo "insert page";
?>


    <!--

    <style>

        
    table {
        border-collapse: collapse;

    }

   td{
    padding: 20px;


   }


    table,
    td {
        border: 1px dotted black;
        padding: 5px;
        text-align: center;
        margin-top: 20px;
        background-color: #f1f1f1;

    }


    input[type=text], select {
  width: 40%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;

}

input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.layout{
    width: 99%;
    font-family: monospace;



}

    </style>

-->


    <style>
        .selectGroup {
            /* min-width: -webkit-fill-available; */
            margin-top: 100px;
            width: 200px;
        }

        .fetchGroup {
            margin-bottom: 50px;
        }

        .layout {
            text-align: center;
        }

        .layout input {
            width: 200px;
        }
    </style>




    </div>


    <div class="layout">

        <form name="fetchGroup" action="#" method="post">


            <div style="width: 100%;">

                <!--style="min-width: -webkit-fill-available;" -->

                <select class="selectGroup" name="groupID" id="teams" required>

                    <option value="">Select Group</option>

                    <?php
                    // A sample product arra
                    $groupList = $wpdb->get_results("SELECT GroupID,GroupName,TournamentStatus from $groupTable");
                    // Iterating through the product array
                    foreach ($groupList as $item) {
                        if ($item->TournamentStatus == 1) {
                            echo "<option value='$item->GroupID'>$item->GroupName</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <input class="fetchGroup" style="margin-top:20px" type="submit" value="Fetch Group" name="fGrp">

        </form>


        <?php
        if (isset($_POST['fGrp'])) {

            $id = $_POST['groupID'];



            $memberList = $wpdb->get_results("SELECT MemberID, MemberName from $memberTable WHERE GroupID='$id'");

            $round16 = $wpdb->get_results("SELECT `Round16ID`, `Member1`, `Member2`, `GroupID` FROM `wp_round16` WHERE GroupID=$id");

            $quaterFinal = $wpdb->get_results("SELECT `Member1`, `Member2` FROM `wp_quater_final` WHERE GroupID=$id");
            $semiFinal = $wpdb->get_results("SELECT `Member1`, `Member2` FROM `wp_semi_final` WHERE GroupID=$id");
            $final = $wpdb->get_results("SELECT `Member1`, `Member2` FROM `wp_final` WHERE GroupID=$id");
            $winner = $wpdb->get_results("SELECT `MemberID`,`MemberName`  FROM `wp_member` WHERE Win=4 AND GroupID=$id");



        ?>

            <form name="bForm" action="" method="post">


                <table id="brakkets" class="display" width="98%" cellspacing="0">
                    <thead>

                        <tr>
                            <th>ROUND 16</th>
                            <th>Quater Final</th>
                            <th>Semi Final</th>
                            <th>Final</th>
                            <th>Winner</th>

                        </tr>
                    </thead>
                    <tbody>





                        <tr>
                            <td>

                                <input hidden name="gID" value=<?= $id ?>></input>
                                <select name="R16_1" id="teams" required>
                                    <option value="<?= $round16[0]->Member1; ?>"> <?= getName($round16[0]->Member1) ?> </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                                VS
                                <select name="R16_2" id="teams" required>
                                    <option value="<?= $round16[0]->Member2; ?>"><?= getName($round16[0]->Member2) ?> </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                            </td>

                            <td rowspan="2">
                                <select name="QF_1" id="teams" required>
                                    <option value="<?= $quaterFinal[0]->Member1; ?>"><?= getName($quaterFinal[0]->Member1) ?>
                                    </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                                VS
                                <select name="QF_2" id="teams" required>
                                    <option value="<?= $quaterFinal[0]->Member2; ?>"><?= getName($quaterFinal[0]->Member2) ?>
                                    </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td rowspan="4"><select name="SF_1" id="teams" required>
                                    <option value="<?= $semiFinal[0]->Member1; ?>"><?= getName($semiFinal[0]->Member1) ?>
                                    </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                                VS
                                <select name="SF_2" id="teams" required>
                                    <option value="<?= $semiFinal[0]->Member2; ?>"><?= getName($semiFinal[0]->Member2) ?>
                                    </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td rowspan="8"><select name="F_1" id="teams" required>
                                    <option value="<?= $final[0]->Member1; ?>"><?= getName($final[0]->Member1) ?> </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                                VS
                                <select name="F_2" id="teams">
                                    <option value="<?= $final[0]->Member2; ?>"><?= getName($final[0]->Member2) ?> </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>


                                </select>
                            </td>
                            <td rowspan="8">
                                <select style="width: 100%!important;" name="W" id="teams">

                                    <?php

                                    if ($winner[0]->MemberID != 0) {
                                        echo '<option value="' . $winner[0]->MemberID . '">' . $winner[0]->MemberName . '</option>';
                                    } else {
                                        echo '<option value="0">None</option>';
                                    }
                                    ?>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberID'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <!--<td><input type="submit" value="Insert" name="ins"></td>-->
                        </tr>
                        <tr>
                            <td>
                                <select name="R16_3" id="teams" required>
                                    <option value="<?= $round16[1]->Member1; ?>"><?= getName($round16[1]->Member1) ?> </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                                VS
                                <select name="R16_4" id="teams" required>
                                    <option value="<?= $round16[1]->Member2; ?>"><?= getName($round16[1]->Member2) ?> </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td> <select name="R16_5" id="teams" required>
                                    <option value="<?= $round16[2]->Member1; ?>"><?= getName($round16[2]->Member1) ?> </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                                VS
                                <select name="R16_6" id="teams" required>
                                    <option value="<?= $round16[2]->Member2; ?>"><?= getName($round16[2]->Member2) ?> </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td rowspan="2"><select name="QF_3" id="teams" required>
                                    <option value="<?= $quaterFinal[1]->Member1; ?>"><?= getName($quaterFinal[1]->Member1) ?>
                                    </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                                VS
                                <select name="QF_4" id="teams" required>
                                    <option value="<?= $quaterFinal[1]->Member2; ?>"><?= getName($quaterFinal[1]->Member2) ?>
                                    </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                            </td>

                        </tr>
                        <tr>
                            <td> <select name="R16_7" id="teams" required>
                                    <option value="<?= $round16[3]->Member1; ?>"><?= getName($round16[3]->Member1) ?> </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                                VS
                                <select name="R16_8" id="teams" required>
                                    <option value="<?= $round16[3]->Member2; ?>"><?= getName($round16[3]->Member2) ?> </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td> <select name="R16_9" id="teams" required>
                                    <option value="<?= $round16[4]->Member1; ?>"><?= getName($round16[4]->Member1) ?> </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                                VS
                                <select name="R16_10" id="teams" required>
                                    <option value="<?= $round16[4]->Member2; ?>"><?= getName($round16[4]->Member2) ?> </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td rowspan="2"><select name="QF_5" id="teams" required>
                                    <option value="<?= $quaterFinal[2]->Member1; ?>"><?= getName($quaterFinal[2]->Member1) ?>
                                    </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                                VS
                                <select name="QF_6" id="teams" required>
                                    <option value="<?= $quaterFinal[2]->Member2; ?>"><?= getName($quaterFinal[2]->Member2) ?>
                                    </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td rowspan="4"><select name="SF_3" id="teams" required>
                                    <option value="<?= $semiFinal[1]->Member1; ?>"><?= getName($semiFinal[1]->Member1) ?>
                                    </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                                VS
                                <select name="SF_4" id="teams" required>
                                    <option value="<?= $semiFinal[1]->Member2; ?>"><?= getName($semiFinal[1]->Member2) ?>
                                    </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                            </td>


                        </tr>
                        <tr>
                            <td> <select name="R16_11" id="teams" required>
                                    <option value="<?= $round16[5]->Member1; ?>"><?= getName($round16[5]->Member1) ?> </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                                VS
                                <select name="R16_12" id="teams" required>
                                    <option value="<?= $round16[5]->Member2; ?>"><?= getName($round16[5]->Member2) ?> </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td> <select name="R16_13" id="teams" required>
                                    <option value="<?= $round16[6]->Member1; ?>"><?= getName($round16[6]->Member1) ?> </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                                VS
                                <select name="R16_14" id="teams" required>
                                    <option value="<?= $round16[6]->Member2; ?>"><?= getName($round16[6]->Member2) ?> </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td rowspan="2"><select name="QF_7" id="teams" required>
                                    <option value="<?= $quaterFinal[3]->Member1; ?>"><?= getName($quaterFinal[3]->Member1) ?>
                                    </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                                VS
                                <select name="QF_8" id="teams" required>
                                    <option value="<?= $quaterFinal[3]->Member2; ?>"><?= getName($quaterFinal[3]->Member2) ?>
                                    </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                            </td>


                        </tr>
                        <tr>
                            <td> <select name="R16_15" id="teams" required>
                                    <option value="<?= $round16[7]->Member1; ?>"><?= getName($round16[7]->Member1) ?> </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                                VS
                                <select name="R16_16" id="teams" required>

                                    <option value="<?= $round16[7]->Member2; ?>"><?= getName($round16[7]->Member2) ?> </option>

                                    <?php
                                    // Iterating through the product array
                                    foreach ($memberList as $item) {
                                        echo "<option value='$item->MemberName'>$item->MemberName</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="5">

                            </td>

                        </tr>
                    </tbody>

                </table>

                <input type="submit" value="Update Tournament" name="createTournament">

            </form>

    </div>



    <?



    ?>





<?php




        }

        if (isset($_POST['createTournament'])) {


            $val = $_POST['gID'];

            $R16_1 = $_POST['R16_1'];
            $R16_2 = $_POST['R16_2'];
            $R16_3 = $_POST['R16_3'];
            $R16_4 = $_POST['R16_4'];
            $R16_5 = $_POST['R16_5'];
            $R16_6 = $_POST['R16_6'];
            $R16_7 = $_POST['R16_7'];
            $R16_8 = $_POST['R16_8'];
            $R16_9 = $_POST['R16_9'];
            $R16_10 = $_POST['R16_10'];
            $R16_11 = $_POST['R16_11'];
            $R16_12 = $_POST['R16_12'];
            $R16_13 = $_POST['R16_13'];
            $R16_14 = $_POST['R16_14'];
            $R16_15 = $_POST['R16_15'];
            $R16_16 = $_POST['R16_16'];
            $QF_1 = $_POST['QF_1'];
            $QF_2 = $_POST['QF_2'];
            $QF_3 = $_POST['QF_3'];
            $QF_4 = $_POST['QF_4'];
            $QF_5 = $_POST['QF_5'];
            $QF_6 = $_POST['QF_6'];
            $QF_7 = $_POST['QF_7'];
            $QF_8 = $_POST['QF_8'];
            $SF_1 = $_POST['SF_1'];
            $SF_2 = $_POST['SF_2'];
            $SF_3 = $_POST['SF_3'];
            $SF_4 = $_POST['SF_4'];
            $F_1 = $_POST['F_1'];
            $F_2 = $_POST['F_2'];

            $win = $_POST['W'];



            $round16Array = array($R16_1, $R16_2, $R16_3, $R16_4, $R16_5, $R16_6, $R16_7, $R16_8, $R16_9, $R16_10, $R16_11, $R16_12, $R16_13, $R16_14, $R16_15, $R16_16);
            $quaterFinalArray = array($QF_1, $QF_2, $QF_3, $QF_4, $QF_5, $QF_6, $QF_7, $QF_8);
            $semiFinalArray = array($SF_1, $SF_2, $SF_3, $SF_4);
            $finalArray = array($F_1, $F_2);

            $mCount = 0;


            /*
        if($val == 1){
            echo '<script>alert("Welcome to Geeks for Geeks")</script>';
        }*/

            $round16 = $wpdb->get_results("SELECT `Round16ID` FROM $round16Table WHERE GroupID= $val");
            $quaterFinal = $wpdb->get_results("SELECT `QuaterFinalID` FROM $quaterFinalTable WHERE GroupID= $val");
            $semiFinal = $wpdb->get_results("SELECT `SemiFinalID` FROM $semiFinalTable WHERE GroupID= $val");
            $final = $wpdb->get_results("SELECT `FinalID` FROM $finalTable WHERE GroupID= $val");




            for ($x = 0; $x < 8; $x++) {


                if ($mCount != 0) {
                    $mCount++;
                }

             

                $wpdb->update(
                    $round16Table,
                    array(
                        'Member1' => $round16Array[$mCount],
                        'Member2' => $round16Array[$mCount + 1]
                    ),
                    array(
                        'Round16ID' => $round16[$x]->Round16ID
                    )
                );

                $mCount++;
            }

            $mCount = 0;

            for ($x = 0; $x < 4; $x++) {


                if ($mCount != 0) {
                    $mCount++;
                }

                for($j=0; $j<2; $j++){

                    if($quaterFinalArray[$mCount] != "0"){
                        $wpdb->update(
                            $memberTable,
                            array(
                                'Win' => 1,
                            ),
                            array(
                                'MemberName' => $quaterFinalArray[$mCount+$j],
                                'GroupID' =>$val,
                            )
                        );
                    }

                }

                $wpdb->update(
                    $quaterFinalTable,
                    array(
                        'Member1' => $quaterFinalArray[$mCount],
                        'Member2' => $quaterFinalArray[$mCount + 1]
                    ),
                    array(
                        'QuaterFinalID' => $quaterFinal[$x]->QuaterFinalID
                    )
                );

                $mCount++;
            }


            $mCount = 0;

            for ($x = 0; $x < 2; $x++) {


                if ($mCount != 0) {
                    $mCount++;
                }



                for($j=0; $j<2; $j++){

                    if($semiFinalArray[$mCount] != "0"){
                        $wpdb->update(
                            $memberTable,
                            array(
                                'Win' => 2,
                            ),
                            array(
                                'MemberName' => $semiFinalArray[$mCount+$j],
                                'GroupID' =>$val,
                            )
                        );
                    }

                }  





                $wpdb->update(
                    $semiFinalTable,
                    array(
                        'Member1' => $semiFinalArray[$mCount],
                        'Member2' => $semiFinalArray[$mCount + 1]
                    ),
                    array(
                        'SemiFinalID' => $semiFinal[$x]->SemiFinalID
                    )
                );

                $mCount++;
            }


            for($j=0; $j<2; $j++){

                if($finalArray[$j] != "0"){
                    $wpdb->update(
                        $memberTable,
                        array(
                            'Win' => 3,
                        ),
                        array(
                            'MemberName' => $finalArray[$j],
                            'GroupID' =>$val,
                        )
                    );
                }

            }

            $wpdb->update(
                $finalTable,
                array(
                    'Member1' => $finalArray[0],
                    'Member2' => $finalArray[1]
                ),
                array(
                    'FinalID' => $final[0]->FinalID
                )
            );

            if ($win != 0) {

                $wpdb->update(
                    $memberTable,
                    array(
                        'Win' => 4,
                    ),
                    array(
                        'MemberID' => $win
                    )
                );
            }
        }
    }

?>