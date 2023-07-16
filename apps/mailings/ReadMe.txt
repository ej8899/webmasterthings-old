		############################################
		##                                        ##
		##        MULTILIST MANAGER v 1.6.1       ##
		##          by Daniel Williams            ##
		##                                        ##
		##      http://www.webscriptworld.com     ##
		##                                        ##
		############################################
					
Copyright 2000 Web Drive Limited. All Rights Reserved.

This program may be used and modified free of charge by anyone, so long as this
copyright notice and the header above remain intact.  By using this program you agree
to indemnify Web Drive Limited from any liability.

Selling the code for this program without prior written consent is expressly forbidden.
Obtain permission before redistributing this program over the Internet or in any other
medium.  In all cases copyright and header must remain intact.

Send support requests, bug reports, suggestions and feedback to daniel@webdrive.co.nz

########################################################################################

ABOUT THE MULTILIST MANAGER

This script was written because we found there was a lack of powerful, reliable and easy
to use free mailing list scripts available on the Web. We needed a script secure enough
and reliable enough to manage our lists of over 200,000 subscribers, that wasn't
complicated to set up and manage.

The script is written in PHP, with the mailing function handled by PERL/CGI so that the
script returns instantly without timing out.

The notes below describe the features of the MultiList Manager, as well as support notes.
Please read the following notes before setting up your MultiList Manager.

QUICK FEATURES

* Tested on more than 100,000 addresses
* Opt-in & Opt-out options
* Web-based administration interface
* Messages sent via CGI script
* No process time outs
* HTML formatted emails
* Fully secured and protected lists
* Manage multiple lists
* Full email validation checks
* Import/Export Lists
* Simple and Advanced modes
* Archive messages
* Back up and restore data

Descriptions below...

########################################################################################

ABOUT SECURITY

The protection and security of lists have a major focus in the MultiList Manager.
Following are some of the security features included:

* Max 3 Login attempts allowed. Upon 3 incorrect attempts the Password file is locked
  and an email message sent to the administrator informing of the breach.
* The directories where sensitive information is held are protected from other FTP users
  by denying access to any FTP user attempting to view files or open directories.
* Lists are virtually impossible to read via the web.

Note: While every attempt has been made to secure the contents of the lists from outside
users another user on the server has the ability to write a PHP script to view the 
contents of a directory and to then view the subscriber files. A user would then have 
permission to delete files created by the script.

If they could actually get this far then they would still need to go through the 
lengthly process of determining where the lists are held, and how to identify them by 
their unique ID. Because the lists are stored on a server there is no way to secure 
them 100%, but for most it would more trouble than it's worth.

This can be prevented by changing your PHP.INI file to only allow scripts to run inside
their directory path. Your server administrator will need to do this for you.

########################################################################################

ABOUT SUBSCRIBING & UNSUBSCRIBING

The MultiList manager includes the files for adding and removing addresses from the 
lists. When adding a list you will be provided with the HTML code for users to add their 
email address.

Lists are protected from being completely cleared by locking the list files when they 
are being processed. 

The subscribe process has enough email validation checking that your average AOL user 
will end up entering a valid address.

Addresses are also checked that they are not already on the list.

########################################################################################

SETTING UP THE MULTILIST MANAGER FOR ADVANCED USERS

1. Create a directory called "mlm" or something similar
2. Chmod this directory to 707
3. Check the path to Perl in mail.cgi
4. Upload the five files to this directory
5. Access index.phtml from your browser
6. Set up the MLM from your web-based admin
7. Upload existing lists to the "imports" directory (chmod import files to 666)

########################################################################################

SETTING UP THE MULTILIST MANAGER FOR BEGINNERS

First you need to create a directory where you will store the MultiList Manager.
"mlm" is a good name to use. Now change the permissions of this directory (chmod) to 707.
You can do this in most FTP clients by selecting the directory and choosing the option
"Change File Attributes".

Open the mail.cgi file. Check the path to Perl for your system. 
/usr/bin/perl is the most common path but your may be different. 
To find out the exact location type the following command into your Telnet client (without 
the quotes)

"whereis perl"

Upload these files to the directory you just created.
- index.phtml
- admin.phtml
- mail.cgi
- subscribe.phtml
- unsub.phtml

Chmod the file "mail.cgi" to 755.

Now via the Web go to the directory you just created. 
You will be prompted to enter a password. You can choose anything you like, but ensure
you remember the password as you'll need to enter it every time you access the MultiList
Manager.

Note: For added security it is a good idea to change the name of the index.phtml file 
to something else. This will make it even harder for hackers and crackers to find your
login page. A blank html file is created by the script to remove the directory listing
in the browser.

You can change the password at any time by selecting "Change Password" on the menu.

Once you have logged in for the first time you'll need to enter some information about 
your site and server.

The first is the "Path to Sendmail". We have included the general path for Linux, but 
this may be different for your server. To find out the exact location type the following
command into your Telnet client (without the quotes)

"whereis sendmail"

The second is the "URL to PHP MultiList". This is the URL where your MultiList Manager 
is on the Web. Your Domain and the directory will already be in the field.

The third is the Server Path to your mlm directory. This field should already be completed.

The fourth is the path to "mail.cgi." If you can run CGIs from any directory leave the
field as "mail.cgi." Your provider may require that you store this file in the server's 
cgi-bin so you may need to enter a URL such as http://yourdomain.com/cgi-bin/mail.cgi

The fifth is your email address. This is the address that security messages will be 
sent if there is any suspected breaches of security, i.e., when an unauthorized person 
is trying to access your MultiList Manager and is locked out.

Last is the option to view server messages. This will show a box with messages from 
our server to inform you of news and updates to the script. We'll also let you know about
support, bugs and future scripts.

You can change any of this information at any time by selecting "Set Up" from the menu.

########################################################################################

USING THE MULTILIST MANAGER

Now that you've gone through the initial set up process you'll be ready to start using the 
MultiList Manager.

###########################################
* Simple and Advanced Mode *
###########################################

On the menu on the left you'll see the option "To Simple Mode". The default setting is 
Advanced Mode, but if you want to set the list up for clients who will be easily confused
by all the options you can switch to Simple Mode, which contains only the most common 
options.

###########################################
* Adding a List *
###########################################

To add a list select "Add List" from the menu. Then proceed to complete the following 
fields:

List Name
 - The name of your list
Short Name
 - A short ID name for your list. Do not include spaces in your list name
From Address
 - The "sender" address for outgoing messages
Generic Subject
 - This field will appear as the default subject line when sending messages

Importing a List

You can easily import an existing list to the MultiList Manager. Simply upload your 
existing subscriber file to the "import" directory and chmod the file to 666. When 
adding a list select the file you uploaded from the "Import List" option. This file 
will then be moved to the new location and associated with your MLM list.

The "Include direct unsubscribe link" option if checked will include instructions for 
unsubscribing from the list.

If you will be sending your emails in HTML format regularly check the option "Always
send email as HTML". If you are only going to send HTML formats occassionally leave the
box unchecked.

Opt-In & Opt-out

If these options are checked the subscriber will be sent a message with a link they 
must follow to confirm their address. This prevents invalid emails or someone elses
address being added or removed.

The "Mail Template" field is where you can place text that will be common for every 
message.

The "Include Header" and "Include Footer" files are what will be placed at the top and 
bottom of your Subscribe and Unsubscribe pages. This is so you can customize the look 
of the pages to match your site. You can only use phtml files, so simply rename your 
header and footer files from "htm" or "html" to "phtml" (if they aren't already).

Once you have added a list the script will generate the HTML code for you to copy and 
paste into your pages for users to subscribe.

###########################################
* Editing and Deleting Lists *
###########################################

To edit or delete a list select "Edit List" from the menu. Select a list and choose 
"Edit List" or "Delete List".

If you are editing a list you can change any of the fields you completed when adding a 
list.

###########################################
* Importing and Exporting Lists *
###########################################

You can export lists to edit them locally and then upload them back to the server.
To export a list select "Import/Export" form the menu.

Select the list to export and click "Export." This will then copy the file to the "export"
directory. You can then FTP into the directory and download it.

Once you have made changes, or you are importing a new list upload the file to the 
"import" directory. Be sure to set the file permissions to 666 and ensure the file has
the same name as the file you exported.

Click "Import." The file will then be moved from the import directory to the current list 
location.

###########################################
* Generating HTML Forms *
###########################################

Use this option if you need to generate the HTML code for users to subscribe to your 
lists.

###########################################
* Viewing Subscribers *
###########################################

Use this option to view and edit the subscribers on your lists. You'll be presented with 
a list of your lists to edit. Here you can also view the number of subscribers on every 
list.

Upon selecting a list to view you'll be presented with a text box that contains all the 
subscribers on your list. The addresses are listed alphabetically. Here you can add and 
remove subscribers and save them.

Note: Large lists become very big files. A list of 10,000 addresses is roughly 
200KB. If viewing lists and saving changes remember that this may take a long time or 
time out in your browser if the lists are too big.

###########################################
* Sending Mail *
###########################################

To send a message to a list select "Send Mail" from the menu. Select the list to send to 
and check whether to include the "Mail Header" and "Mail Footer" in the message (this is
what you may have added when you added a list).

You will then be able to enter your message and change any of the default settings you 
saved when you added the list.

To send the message select "Send Mail".

Once the message has been sent you can return to the MultiList Manager to archive the 
message. To archive your message select "Archive Message".

NOTE: If you are sending your email in HTML format DON'T FORGET to use <p> and <br> tags
otherwise your text will just be sent as one line. You must code the message exactly as 
you would a web page.

###########################################
* Viewing Archived Messages *
###########################################

To view a message that has been sent to a list select "View Archives" from the menu. 
You'll then see each list name and the messages that have been sent to that list. Select 
the message from the drop down list to view. You can also choose to delete a message.

###########################################
* Backing Up and Restoring Your Lists *
###########################################

It is important to back up your lists frequently. Losing a mailing list of contacts can 
have adverse effects on your business and web site. Do not simply rely on server 
administrators to  back up your site.

Select "Back Up" from the menu. This will zip up all the files in your MultiList Manager
directory. You'll then be able to download the file, which is in the "TAR" format. This 
can be opened in WinZip (www.winzip.com) under Windows. Once you have downloaded the file 
it is important to click the "Delete Back Up" button as this will remove the file from 
the server, and will ensure that others cannot access your list files.

Should you ever need to restore your lists you cannot simply upload the individual files 
to the server via FTP as the files will lose all their permissions information.

If you totally lose all your files due to a server crash or other incident you will need 
to go through the Set Up process again. Login and go to the "Back Up" section.
Using the "Browse" button, select the file where you last saved it on your hard drive. 
Then click "Restore Back Up". This will upload the file to the server and restore all 
your files from when you last backed up.

BE WARNED! Restoring from a backup will overwrite all the files in your MultiList Manager
directory.

###########################################
* Uninstalling the MultiList Manager *
###########################################

Since the files created by the MLM are owned by the user "nobody" you'll need to run 
the uninstall to remove all the files created by the script.

To uninstall select "Set Up" from the menu. In the bottom right corner is a button labelled
"Uninstall." Click this, but be warned, ALL files will be removed from the directory!

###########################################
* Support *
###########################################

This script is provided "as is". If you need help with this script please post a message on the Support Forum at http://www.webscriptworld.com

########################################################################################

Copyright 2000 Web Drive Limited
