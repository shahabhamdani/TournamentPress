<?php

/**
 *@package TournamentPress
 */
/*
  Plugin Name: TournamentPress
  Plugin URI: http://www.google.com
  Description: Custom Tournamnet Plugin For Group of Teams with Database integration and fronend Blocks
  Version: 1.0.0
  Author: Shahab Hamdani
  Author URI: http://www.fiverr.com/shahabal
  License: GPLv2 or later
  Text Domain: tournament-press
 */


//Creating DATABSE////////////////////////////////////////////////////////////////////

global $jal_db_version;
$jal_db_version = '1.0';

function jal_install()
{
  global $wpdb;
  global $jal_db_version;

  $table_name = $wpdb->prefix . 'employee_list';

  $charset_collate = $wpdb->get_charset_collate();

  $sql = "CREATE TABLE wp_final (
        FinalID int(10) NOT NULL AUTO_INCREMENT, 
        Member1 varchar(255) DEFAULT '0', 
        Member2 varchar(255) DEFAULT '0', 
        GroupID int(10) NOT NULL, 
        PRIMARY KEY (FinalID));

        CREATE TABLE wp_player (
        PlayerID int(10) NOT NULL AUTO_INCREMENT, 
        MemberID int(10) NOT NULL, 
        PlayerName varchar(255), 

        PRIMARY KEY (PlayerID));

      CREATE TABLE wp_semi_final (
        SemiFinalID int(10) NOT NULL AUTO_INCREMENT, 
        Member1     varchar(255) DEFAULT '0', 
        Member2     varchar(255) DEFAULT '0', 
        GroupID     int(10) NOT NULL, 
        PRIMARY KEY (SemiFinalID));
      CREATE TABLE wp_quater_final (
        QuaterFinalID int(10) NOT NULL AUTO_INCREMENT, 
        Member1       varchar(255) DEFAULT '0', 
        Member2       varchar(255) DEFAULT '0', 
        GroupID       int(10) NOT NULL, 
        PRIMARY KEY (QuaterFinalID));
      CREATE TABLE wp_round16 (
        Round16ID int(10) NOT NULL AUTO_INCREMENT, 
        Member1   varchar(255)  DEFAULT '0', 
        Member2   varchar(255)  DEFAULT '0', 
        GroupID   int(10) NOT NULL, 
        PRIMARY KEY (Round16ID));
      CREATE TABLE wp_season (
        SeasonID    int(10) NOT NULL AUTO_INCREMENT, 
        Duration    char(100), 
        Description char(255), 
        Prize       int(10), 
        PRIMARY KEY (SeasonID)) ;
      CREATE TABLE wp_member (
        MemberID   int(10) NOT NULL AUTO_INCREMENT, 
        Win        int(10) DEFAULT 0, 
        GroupID    int(10), 
     

        MemberName char(100), 
        PRIMARY KEY (MemberID), 
        UNIQUE INDEX (MemberID));
      CREATE TABLE `wp_group` (
        GroupID          int(10) NOT NULL AUTO_INCREMENT, 
        GroupName        char(100) UNIQUE, 
        TournamentStatus int(1) DEFAULT 0, 
        Prize        varchar(255), 
        Description        varchar(255), 

        PRIMARY KEY (GroupID), 
        UNIQUE INDEX (GroupID)) ;
      ALTER TABLE wp_final ADD INDEX FKFinal844680 (GroupID), ADD CONSTRAINT FKFinal844680 FOREIGN KEY (GroupID) REFERENCES `wp_group` (GroupID);
      ALTER TABLE wp_semi_final ADD INDEX FKSemiFinal190420 (GroupID), ADD CONSTRAINT FKSemiFinal190420 FOREIGN KEY (GroupID) REFERENCES `wp_group` (GroupID);
      ALTER TABLE wp_quater_final ADD INDEX FKQuarterFin460459 (GroupID), ADD CONSTRAINT FKQuarterFin460459 FOREIGN KEY (GroupID) REFERENCES `wp_group` (GroupID);
      ALTER TABLE wp_round16 ADD INDEX FKRound16576428 (GroupID), ADD CONSTRAINT FKRound16576428 FOREIGN KEY (GroupID) REFERENCES `wp_group` (GroupID);
      ALTER TABLE wp_member ADD INDEX FKMember339092 (GroupID), ADD CONSTRAINT FKMember339092 FOREIGN KEY (GroupID) REFERENCES `wp_group` (GroupID);
      ALTER TABLE wp_player ADD INDEX FKPlayer944681 (MemberID), ADD CONSTRAINT FKPlayer944681 FOREIGN KEY (MemberID) REFERENCES `wp_member` (MemberID);

      INSERT INTO `wp_season` (`SeasonID`, `Duration`, `Description`, `Prize`) VALUES ('1', NULL, NULL, NULL);

	 $charset_collate;";

  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
  dbDelta($sql);

  add_option('jal_db_version', $jal_db_version);
}
register_activation_hook(__FILE__, 'jal_install');


add_action('admin_menu', 'at_try_menu');

add_action('enqueue_block_editor_assets', 'loadMyBlockFiles');





function get_tournament($atts)
{


  $id = $atts['id'];

  global $wpdb;
  $memberTable = $wpdb->prefix . 'member';
  $r16Table = $wpdb->prefix . 'round16';
  $qFinalTable = $wpdb->prefix . 'quater_final';
  $sFinalTable = $wpdb->prefix . 'semi_final';
  $finalTable = $wpdb->prefix . 'final';


  $round16 = $wpdb->get_results("SELECT `Member1`, `Member2`, `GroupID` FROM `wp_round16` WHERE GroupID=$id");
  $quaterFinal = $wpdb->get_results("SELECT `Member1`, `Member2` FROM `wp_quater_final` WHERE GroupID=$id");
  $semiFinal = $wpdb->get_results("SELECT `Member1`, `Member2` FROM `wp_semi_final` WHERE GroupID=$id");
  $final = $wpdb->get_results("SELECT `Member1`, `Member2` FROM `wp_final` WHERE GroupID=$id");
  $winner = $wpdb->get_results("SELECT `MemberID`,`MemberName`  FROM `wp_member` WHERE Win=4 AND GroupID=$id");
  $groups = $wpdb->get_results("SELECT `Prize`,`Description`,`GroupName` FROM `wp_group` WHERE GroupID=$id");


  $Content = "
  <style>
  
  .myClass {

      text-align: -webkit-center;
      font-size: 12px;


       
  }
   .wrapper {
       display: flex;
       justify-content: center;
       margin:20px;
       background-color:black;

  }
   .item {
       display: flex;
       width: fit-content;
       flex-direction: row-reverse;
  }
   .item p {
       padding: 5px;
       margin: 0;
       background-color: white;
       border-bottom: groove;
       width:150px;
  }
   .item-parent {
       position: relative;
       margin-left: 50px;
       display: flex;
       align-items: center;
  }
   .item-parent:after {
       position: absolute;
       content: '';
       width: 25px;
       height: 2px;
       left: 0;
       top: 50%;
       background-color: #000000;
       transform: translateX(-100%);
  }
   .item-childrens {
       display: flex;
       flex-direction: column;
       justify-content: center;
  }
   .item-child {
       display: flex;
       align-items: flex-start;
       justify-content: flex-end;
       margin-top: 10px;
       margin-bottom: 10px;
       position: relative;
  }
   .item-child:before {
       content: '';
       position: absolute;
       background-color: #000000;
       right: 0;
       top: 50%;
       transform: translateX(100%);
       width: 25px;
       height: 2px;
  }
   .item-child:after {
       content: '';
       position: absolute;
       background-color: #000000;
       right: -25px;
       height: calc(50% + 22px);
       width: 2px;
       top: 50%;
  }
   .item-child:last-child:after {
       transform: translateY(-100%);
  }
   .item-child:only-child:after {
       display: none;
  }
   
  </style";





  $Content .= '
  <div class="wrapper">


  <div style="text-align:center;">
  <h3>Tournament Overview</h3>

  <p><b>Prize:</b> $' . $groups[0]->Prize . '  </p>
  <p><b>Description:</b> ' . $groups[0]->Description . '</p>

  </div>

   
    <div class="myClass">

    

      <div class="groupName">

        <h4>Group ' . $groups[0]->GroupName . '</h4>

      </div>


        <div class="item">
            <div style="margin-left: 20px!important;" class="item-childrens">
    
            <p><b>' . $winner[0]->MemberName . '</b></p>
    
    
            </div>
    
        <div class="item-parent">
    
        <p><b>' . $final[0]->Member1 . '</b> vs <b> ' . $final[0]->Member2 . '</b></p>
            
        </div>
    
        <div class="item-childrens">
            <div class="item-child">
            <div class="item">
    
                <div class="item-parent">
                <p><b>' . $semiFinal[0]->Member1 . '</b> vs <b> ' . $semiFinal[0]->Member2 . '</b></p>
                </div>
    
                <div class="item-childrens">
                <div class="item-child">
                    <div class="item">
                    <div class="item-parent">
                        <p><b>' . $quaterFinal[0]->Member1 . '</b> vs <b> ' . $quaterFinal[0]->Member2 . '</b></p>
                    </div>
                    <div class="item-childrens">
                        <div class="item-child">
                        <p><b>' . $round16[0]->Member1 . ' </b> vs <b> ' . $round16[0]->Member2 . '</b></p>
                        </div>
                        <div class="item-child">
                        <p><b>' . $round16[1]->Member1 . ' </b> vs <b>          ' . $round16[1]->Member2 . '</b></p>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="item-child">
                    
                <div class="item">
                    <div class="item-parent">
                        <p><b>' . $quaterFinal[1]->Member1 . '</b> vs <b> ' . $quaterFinal[1]->Member2 . '</b></p>
                    </div>
                    <div class="item-childrens">
                        <div class="item-child">
                        <p><b>' . $round16[2]->Member1 . ' </b> vs <b>          ' . $round16[2]->Member2 . '</b></p>
                        </div>
                        <div class="item-child">
                        <p><b>' . $round16[3]->Member1 . ' </b> vs <b>          ' . $round16[3]->Member2 . '</b></p>
                        </div>
                    </div>
                    </div></div>
                </div>
            </div>
            </div>
    
            <div class="item-child">
            
            <div class="item">
    
                <div class="item-parent">
                <p><b>' . $semiFinal[1]->Member1 . '</b> vs <b> ' . $semiFinal[1]->Member2 . '</b></p>
                </div>
    
                <div class="item-childrens">
                <div class="item-child">
                    <div class="item">
                    <div class="item-parent">
                        <p><b>' . $quaterFinal[2]->Member1 . '</b> vs <b> ' . $quaterFinal[2]->Member2 . '</b></p>
                    </div>
                    <div class="item-childrens">
                        <div class="item-child">
                        <p><b>' . $round16[4]->Member1 . ' </b> vs <b>          ' . $round16[4]->Member2 . '</b></p>
                        </div>
                        <div class="item-child">
                        <p><b>' . $round16[5]->Member1 . ' </b> vs <b>          ' . $round16[5]->Member2 . '</b></p>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="item-child">
                    
                <div class="item">
                    <div class="item-parent">
                        <p><b>' . $quaterFinal[3]->Member1 . '</b> vs <b> ' . $quaterFinal[3]->Member2 . '</b></p>
                    </div>
                    <div class="item-childrens">
                        <div class="item-child">
                        <p><b>' . $round16[6]->Member1 . ' </b> vs <b>  ' . $round16[6]->Member2 . '</b></p>
                        </div>
                        <div class="item-child">
                        <p><b>' . $round16[7]->Member1 . '</b> vs <b> ' . $round16[7]->Member2 . '</b></p>
                        </div>
                    </div>
                    </div></div>
                </div>
            </div></div>
        </div>
        </div>
        </div>
  </div>';


  return $Content;
}

add_shortcode('group', 'get_tournament');


add_shortcode('season', 'getSeasonOverview');

function getSeasonOverview($atts)
{


  global $wpdb;
  $memberTable = $wpdb->prefix . 'member';
  $members = $wpdb->get_results("SELECT  MemberID, MemberName, Win from $memberTable");

  $season = $wpdb->get_results("SELECT `Duration`, `Description`, `Prize` FROM `wp_season` WHERE 1");


  $content = "
  


  <style>
  .seasonTable td,
  .seasonTable th {
    border: 1px dotted;
    text-align: center;
    padding: 5px;
  }

  .seasonTable {
    text-align: -webkit-center;
  }


  #foo{

    padding:100px;

  }
 
          
  /* The Modal (background) */
  .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  }
  
  /* Modal Content */
  .modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 30%;
  }
  
  /* The Close Button */
  .close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }
  
  .close:hover,
  .close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
  }


</style>";


$url= get_site_url(null, '/wp-json/wpdb/v1/players/', null);
  $content .= '<div class="seasonTable">
  <div>


  <script id="demo" type="text/javascript">
		function  openMenu(d) {
			// our array of objects for some data to play with
            const url = `'.$url.'${d}`;


            fetch(url)
    .then((response) => {
      return response.json();
    })
    .then((data) => {
      let arr = data;
      var i = 0,
				arrLen = arr.length - 1
				str = "";
			// loop through all elements in the array, building a form for each object
			for (; i <= arrLen; i++ ) {
			str = str 
							+ "<label><b> " + arr[i].PlayerName + "  </b></label>"
						;
			};
			//append the markup to the DOM
			$("#foo").html(str) ;
      
    })
    .catch(function(error) {
      console.log(error);
    });
		}
	</script>


  <script type="text/javascript">


  var myBooks = ' . json_encode($members) . ' 

                 
  var col = [];
  for (var i = 0; i < myBooks.length; i++) {
      for (var key in myBooks[i]) {
          if (col.indexOf(key) === -1) {
              col.push(key);
          }
      }
  }

  // CREATE DYNAMIC TABLE.
  var table = document.createElement("table");

  // CREATE HTML TABLE HEADER ROW USING THE EXTRACTED HEADERS ABOVE.

  var tr = table.insertRow(-1);                   // TABLE ROW.

  var gol = [];
  gol.push("Players");
  gol.push("Groups");
  gol.push("Winnings");


  for (var i = 0; i < gol.length; i++) {
    var th = document.createElement("th");      // TABLE HEADER.
    th.innerHTML = gol[i];
    tr.appendChild(th);
}

  // ADD JSON DATA TO THE TABLE AS ROWS.
  for (var i = 0; i < myBooks.length; i++) {

      tr = table.insertRow(-1);

      for (var j = 0; j < col.length; j++) {
          var tabCell = tr.insertCell(-1);

          if(j!=0){

            tabCell.innerHTML = myBooks[i][col[j]];


          } else{
            tabCell.innerHTML = "<a onclick = "+`fechMembers("${myBooks[i][col[j]]}")`+" />"+ "View" +"</a>";

          }
      }
  }

  // FINALLY ADD THE NEWLY CREATED TABLE WITH JSON DATA TO A CONTAINER.
  var divContainer = document.getElementById("showData");
  divContainer.innerHTML = "";
  divContainer.appendChild(table);



</script>



    <h3>Season Overview Table</h3>
    <div>
      <p><b>Prize:</b> $' . $season[0]->Prize . '  </p>
      <p><b>Duration:</b> ' . $season[0]->Duration . ' Months</p>
      <p>'. $season[0]->Description. '</p>

      <div id="showData"></div>

      <div id="showPlayers" ></div>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <p>Players</p>
    <div id="foo"></div>
</div>

</div>


      <script>

      function fechMembers(theObject) {
        openMenu(`${theObject}`);
        modal.style.display = "block";
      }



      // Get the modal
      var modal = document.getElementById("myModal");
      
      // Get the button that opens the modal
      
      // Get the <span> element that closes the modal
      var span = document.getElementsByClassName("close")[0];
      
    
      // When the user clicks on <script> (x), close the modal
      span.onclick = function() {
        modal.style.display = "none";
      }
      
      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function(event) {
        if (event.target == modal) {
          modal.style.display = "none";
        }
      }
      </script>


    </div>
  </div>
</div>';


  return $content;
}




add_action('init', 'use_jquery_from_google');

function use_jquery_from_google () {
	if (is_admin()) {
		return;
	}

	global $wp_scripts;
	if (isset($wp_scripts->registered['jquery']->ver)) {
		$ver = $wp_scripts->registered['jquery']->ver;
                $ver = str_replace("-wp", "", $ver);
	} else {
		$ver = '1.4.2';
	}

	wp_deregister_script('jquery');
	wp_register_script('jquery', "//ajax.googleapis.com/ajax/libs/jquery/$ver/jquery.min.js", false, $ver);
}



//http://localhost/wordpress/wp-json/wpdb/v1/groups/
//get all groups with iD and Name
add_action('rest_api_init', function () {

  register_rest_route('wpdb/v1', '/groups', array(
    'methods' => 'GET',
    'callback' => 'get_groups',
  ));

  register_rest_route('wpdb/v1', '/round16/(?P<id>\d+)', array(
    'methods' => 'GET',
    'callback' => 'get_round16',
  ));



  register_rest_route('wpdb/v1', '/quater_final/(?P<id>\d+)', array(
    'methods' => 'GET',
    'callback' => 'get_quater_final',
  ));


  register_rest_route('wpdb/v1', '/semi_final/(?P<id>\d+)', array(
    'methods' => 'GET',
    'callback' => 'get_semi_final',
  ));


  register_rest_route('wpdb/v1', '/final/(?P<id>\d+)', array(
    'methods' => 'GET',
    'callback' => 'get_final',
  ));


  register_rest_route('wpdb/v1', '/winner/(?P<id>\d+)', array(
    'methods' => 'GET',
    'callback' => 'get_winner',
  ));

  register_rest_route('wpdb/v1', '/season', array(
    'methods' => 'GET',
    'callback' => 'get_season',
  ));

  
  register_rest_route('wpdb/v1', '/players/(?P<id>\d+)', array(
    'methods' => 'GET',
    'callback' => 'get_players',
  ));
  
});


function get_players($data)
{

  global $wpdb;

  $table = $wpdb->prefix . 'player';

  $name = $data['id'];
  $result = $wpdb->get_results("SELECT PlayerName from $table WHERE MemberID = $name");

  return $result;
}


function get_season($data)
{

  global $wpdb;

  $table = $wpdb->prefix . 'season';

  $id = $data['id'];

  $result = $wpdb->get_results("SELECT Duration, Description, Prize from $table");


  return $result;
}

function get_winner($data)
{

  global $wpdb;

  $table = $wpdb->prefix . 'member';

  $id = $data['id'];

  $result = $wpdb->get_results("SELECT MemberName from $table WHERE Win=4");


  return $result;
}


function get_final($data)
{

  global $wpdb;

  $table = $wpdb->prefix . 'final';

  $id = $data['id'];

  $result = $wpdb->get_results("SELECT Member1, Member2 from $table WHERE GroupID='$id'");


  return $result;
}


function get_quater_final($data)
{

  global $wpdb;

  $table = $wpdb->prefix . 'quater_final';

  $id = $data['id'];

  $result = $wpdb->get_results("SELECT Member1, Member2 from $table WHERE GroupID='$id'");


  return $result;
}

function get_semi_final($data)
{

  global $wpdb;

  $table = $wpdb->prefix . 'semi_final';

  $id = $data['id'];

  $result = $wpdb->get_results("SELECT Member1, Member2 from $table WHERE GroupID='$id'");


  return $result;
}


function get_round16($data)
{

  global $wpdb;

  $round16Table = $wpdb->prefix . 'round16';

  $id = $data['id'];

  $round16 = $wpdb->get_results("SELECT Member1, Member2 from $round16Table WHERE GroupID='$id'");


  return $round16;
}



function get_groups($data)
{

  global $wpdb;
  $groupTable = $wpdb->prefix . 'group';
  $groups = $wpdb->get_results("SELECT GroupID, GroupName from $groupTable");
  return $groups;
}


//add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position )


function at_try_menu()
{
  //adding plugin in menu
  add_menu_page(
    'groups', //page title
    'TournamentPress', //menu title
    'manage_options', //capabilities
    'Groups', //menu slug
    'groups', //function
    'dashicons-chart-area' //icon
  );
  //adding submenu to a menu
  add_submenu_page(
    'Groups', //parent page slug
    'tournaments', //page title
    'Tournament Details', //menu titel
    'manage_options', //manage optios
    'Tournaments', //slug
    'tournaments' //function
  );

  add_submenu_page(
    null, //parent page slug
    'group_delete', //$page_title
    'Group Delete', // $menu_title
    'manage_options', // $capability
    'Group_Delete', // $menu_slug,
    'group_delete' // $function
  );

  add_submenu_page(
    null, //parent page slug
    'view_members', //$page_title
    'View Members', // $menu_title
    'manage_options', // $capability
    'View_Members', // $menu_slug,
    'view_members' // $function
  );


  add_submenu_page(
    null, //parent page slug
    'add_players', //$page_title
    'Add Players', // $menu_title
    'manage_options', // $capability
    'Add_Players', // $menu_slug,
    'add_players' // $function
  );

  add_submenu_page(
    null, //parent page slug
    'register_tournament', //$page_title
    'Register tournament', // $menu_title
    'manage_options', // $capability
    'Register_Tournament', // $menu_slug,
    'register_tournament' // $function
  );
}


// returns the root directory path of particular plugin
define('ROOTDIR', plugin_dir_path(__FILE__));
require_once(ROOTDIR . 'groups.php');
require_once(ROOTDIR . 'tournaments.php');
require_once(ROOTDIR . 'group_delete.php');
require_once(ROOTDIR . 'view_members.php');
require_once(ROOTDIR . 'add_players.php');
require_once(ROOTDIR . 'register_tournament.php');

