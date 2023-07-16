<?php


// check to see if the have a few hidden tags
if ($count == "") { echo "You need to define 'count' as a hidden tag in your HTML"; exit; }
if ($message == "") { echo "You need to define 'message' as a hidden tag in your HTML"; exit; }
if ($subject == "") { echo "You need to define 'subject' as a hidden tag in your HTML"; exit; }
if ($adminemail == "") { echo "You need to define 'adminemail' as a hidden tag in your HTML. This is where email will all be sent from, e.g. webmaster@yoursite.com"; exit; }

// now search to see if the admins email address is valied
if(!eregi("[0-9a-z]([-_.+]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-z]{2,}$", $adminemail)) { error("The email address you set for 'adminemail' does not seem to be valied. Please try again..."); exit; }

// use a foreach loop...that way they can send as many emails out as they want...
for ($counting= 1; $counting <= $count; $counting++) { 

// do some email format checking..that way we cna see if the email being sent out is valied and not a load of junk..
if ($person[$counting] == "") { error("A name was not specified for person $counting"); exit; }
if(!eregi("[0-9a-z]([-_.+]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-z]{2,}$", $email[$counting])) { error("The email address you submitted, $email[$counting], does not appear to be valied. Please check."); exit; }

echo "Sent to $person[$counting] <BR>";

// now we need to send out that person an email
send_mail($email[$counting],$person[$counting],$subject,$message, $adminemail);

} // end the for

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

// here is where the email is actually sent..and is thern called from above.
function send_mail($email, $name, $subject, $message, $adminemail) {

mail("$email", $subject, $message,
     "From: $adminemail\r\n"
    ."Reply-To: $adminemail\r\n");
											  
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

// error sub...in case something goes wrong!
function error($error) {

 echo "There was an error. It was;<BR><BR>";
 echo $error;

 exit;

} //end the error sub

?>

