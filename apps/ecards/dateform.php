Select a date. If you don't change the date below, the card will be sent immediately.
<BR>

<?PHP      
  
$monthName = array(1=>"January", "February", "March", "April", "May", "June", "July", "August", "September", "October",      "November", "December");  
           
echo "<SELECT NAME='".$inName."month'>\n";  
                
for($CurrentMonth = 1; $CurrentMonth <= 12; $CurrentMonth++)  {  
echo "<OPTION VALUE=\"";
if  (intval($CurrentMonth)<10){
echo "0";
echo intval($CurrentMonth); 
} else {
echo intval($CurrentMonth); 
}
echo "\"";  

if(intval(date("m"))==$CurrentMonth) {  
echo " SELECTED";  
}  
echo ">".$monthName[$CurrentMonth]."\n";  
}  
echo "</SELECT>";  

echo "<SELECT NAME='".$inName."day'>\n";  
                
for($CurrentDay=1; $CurrentDay <= 31; $CurrentDay++) {

if ($CurrentDay<10) {  
echo "<OPTION VALUE=\"0$CurrentDay\""; 
} else {
echo "<OPTION VALUE=\"$CurrentDay\"";
}

if(intval(date("d"))==$CurrentDay) {  
echo " SELECTED";  
}  
echo ">$CurrentDay\n";  
}  
echo "</SELECT>";  
                  
echo "<SELECT NAME=".$inName."year>\n";  
$startYear = date("Y");
  
for($CurrentYear = $startYear - 0; $CurrentYear <= $startYear+4;$CurrentYear++) {  
echo "<OPTION VALUE=\"$CurrentYear\"";  
                        
if(date("Y")==$CurrentYear) {  
echo " SELECTED";  
}  
echo ">$CurrentYear\n";  
}  
echo "</SELECT>";

?>
