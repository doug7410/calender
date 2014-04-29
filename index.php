<?
//get the date of the birthday to look up
$day = $_GET['day'];
$month = $_GET['month'];
$year = $_GET['year'];

//generate the timestamp for the firsh day of the target month and year
$target_date_timestamp = mktime(00,00,00,$month,1,$year);

//find how many days are in the target month
$days_in_target_month = date("t",$target_date_timestamp);

//create an array for the target month timestamp
$target_month_array = getdate($target_date_timestamp); 

//save the first day of the month
//(sunday = 0,monday = 1, tues = 2, wed = 3, thurs = 4, fri = 5, sat = 6)
$first_day = $target_month_array['wday']; 


//this function gets the number of table cells required to fill up the calender
function round_up_to_nearest_7($int, $n) {
		//this takes the total of days in the month plus the start day, then devides it by seven, 
		//then rounds it up to the nearest whole number
		//then it multiplies that by 7 giving the total number of cells requred for the calender table
        return ceil($int / $n) * $n; 	
    }	
	//this creates a variable for the total number of cells in the calender table
    $total_cells = round_up_to_nearest_7($days_in_target_month + $first_day,7);
?>	
<!DOCKTYPE html>
<html>
<head>
<style>
body{
	background-image:url(images/bg.jpg);
	
	/*background-size: 100% auto;*/
	font-size:12px;
	font-family:Arial, Helvetica, sans-serif;
}
#container{
	background-color:#EAEAEA;
	position:relative;
	margin-left:auto;
	margin-right:auto;
	text-align:center;
	width:663px;
	padding:15px;
	border-radius:10px;
	border:solid 1px #333333;
	box-shadow:5px 5px 5px #888888;
}
#container table{
	background-color:#FFFFFF;
	border: #333333 solid 1px;
	border-collapse:collapse;
}
p{
	font-size:16px;
}
.normal-cell, .red-cell{
	width:70px;
	height:50px;
	text-align:center;
	padding:10px
}
.red-cell{
	background-color:#FF0000;
	color:#FFFFFF;
	font-weight:bold;
}
.red-cell p{
	font-size:14px;
	margin:0px;
	padding:0px;
}
div.codeLink{
	width:350px;
	position:relative;
	margin-left:13px;
	text-align:left;
}
div.codeLink a:link, div.codeLink a:visited{
	color: #0066CC;
	font-size:14px;
	display:inline-block;
	margin-bottom:4px;
}	
div.codeLink a:hover{
	text-decoration:underline;
	color:#CC3333;
}
</style>
<title>Your Birthday Calender</title></head>
<body>
<div id="container">
<form action="lab11objective2.php" method="get">
<p><b>Please enter your birthday year and month below.</b></p>
<div>
    <select name="month" id="month">
		<? for($i=1; $i<12+1; $i++){//this loop makes a list of all the months for the dropdown options
			
			//this make a different month name each time through the loop
			//strtotime() generates a timestamp by using the position in the loop for the month
			//date() uses the "F" parameter to get the name of the month in the timestamp
            $months = date(F,strtotime("10.$i.2000")); 
            echo '<option value="'.$i.'"'; 
            if($month == $i){echo 'selected';} 
            echo '>'.$months.'</option>';
            }
        ?>	
    </select>
    <select name="day" id="day">
		<? for($i=1; $i<31+1; $i++){//this loop makes a list for all the possible days in a month
            echo '<option value="'.$i.'"'; 
            if($day == $i){echo 'selected';} 
            echo '>'.$i.'</option>';
            }
        ?>	
    </select>
    <select name="year" id="year">
		<? 
        //this loop makes a list of years starting at 1950 and goes 10 past the current year
        for($i=1900; $i<=date("Y")+10; $i++)
        if($year == $i)
        echo "<option value='$i' selected>$i</option>";
        else
        echo "<option value='$i'>$i</option>";
        ?>
    </select>
    <input type="submit" value="submit" />
</form>
</div>
<p>You birthday is highlighted in <span style="font-weight:bold; color:red;">red</span>!</p>
<div class="codeLink"><a href="calender_code.txt">Click here to view the code.</a><br>
<strong>update (6/25/2013)</strong>: 
<br />
• I updated the year dropdown to start at 1900. <br />
• I added a link to see the source code. <br /><br />

Thanks for checking out my program. If you have any comments or questions you can find me on facebook at this address <a href="https://www.facebook.com/doug.steinberg.14">www.facebook.com/doug.steinberg.14</a>
</div>
<table border="1" align="center" cellpadding="1" cellspacing="0">
    <tr>
        <td colspan="7">
        <h2 align="center"><? echo $target_month_array['month'] . " " . $target_month_array['year']; //display name of target month and year ?></h2>        </td>
    </tr>
  <tr>
    <th scope="col"><div align="center">Sunday</div></th>
    <th scope="col"><div align="center">Monday</div></th>
    <th scope="col"><div align="center">Tuesday</div></th>
    <th scope="col"><div align="center">Wednesday</div></th>
    <th scope="col"><div align="center">Thursday</div></th>
    <th scope="col"><div align="center">Friday</div></th>
    <th scope="col"><div align="center">Saturday</div></th>
  </tr>
<?	
//run this loop for the total number of cells that will make up the table
for ($i=0; $i<($total_cells); $i++) {
    
	//to make the current date
	//take the current position in the loop, subtract the number of the first day of the month 
	//(sunday = 0,monday = 1, tues = 2, wed = 3, thurs = 4, fri = 5, sat = 6), then add 1 
	$current_date = ($i - $first_day) + 1;
	
	if(($i % 7) == 0 ){ echo "<tr>"; }//if the remander of $i / 7 is zero make a new row
	
	//if $i is less than the first day of the month or more than the last day, make an empty cell
    if($i < $first_day || $i >= $days_in_target_month + $first_day){ echo '<td><div class="normal-cell">&nbsp;</div></td>';
	
	//else print a cell with the current date
    }else{ if($current_date == $day ){
				echo '<td><div class="red-cell"> ' . $current_date . '<p>My Birthday!!!</p></div></td>';
			}else{
				echo '<td><div class="normal-cell"> ' . $current_date . '</div></td>';
			}
	}
    
	//if the remander of $i / 7 is 6 end the row, this ends the rows every 6th time through the loop
	if(($i % 7) == 6 ) echo "</tr>";
}
?>
</table>
</div>

<?php include_once("../js/analyticstracking.php") ?>
</body>
</html>
