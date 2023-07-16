/////////////////////////////////////////////////////////
//ledformmail.php - v1.0
//By: Jon Coulter - ledjon@ledscripts.com
//http://www.ledscripts.com
//
//This script is freeware. I accept no responsibility 
// for damage it may cause (which should be none).
//
//This script can be freely modify, as long as this 
// copyright is included.
//
//Copyright 2000 Jon Coulter - ledjon@ledscripts.com
//
//Bugs: bugs@ledscripts.com
//Support: support@ledscripts.com
/////////////////////////////////////////////////////////

Installation:

NONE!

If you want to enable referring hosts security features, read one. Otherwise just skip to the 'Usage' Section below.

Referring host security.
The $refcheck variable should be set to 1 if you want to block all referring hosts except the ones you list in the $referrers array.

Usage:

Create a form using basic html <form> tags. Here are some simple examples:

A simple feedback form:
---------------------------------------------------
<form action="ledformmail.php" method=POST>
Name: <input type=text name="realname"><br>
E-mail: <input type=text name="email"><br>
<input type=hidden name=to value="you@yourdomain.com">
<input type=hidden name=redirect value="http://www.redirecturl.com">
<input type=submit value="Send Your Info">
</form>
---------------------------------------------------

Notice that you can use hidden fields to set extra data that you don't want the user to enter.

If you include a "redirect" field, the user will be redirected to that url.
If you include a "to" field the e-mail will be send TO that e-mail address.
-If you don't include a "to" field, the e-mail will be sent to the $adminmail address set at the top of the script.
-If you don't include an "email" field, the e-mail will show up as from the $adminmail address set at the top of the script.
If you include a "subject" field, that will be the subject of the e-mail.

That's is. Just upload the script and point your form to it!
 Note: You can use either GET or POST methods (or don't define it and it will be automatically set to GET).

http://www.ledscripts.com
support@ledscripts.com