#!/usr/bin/perl


read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
@pairs = split(/&/, $buffer);
foreach $pair (@pairs) {
	($name, $value) = split(/=/, $pair);
	$value =~ tr/+/ /;
	$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	if ($INPUT{$name}) { $INPUT{$name} = $INPUT{$name}.",".$value; }
	else { $INPUT{$name} = $value; }
}

$pid = fork();
print "Content-type: text/html \n\n fork failed: $!" unless defined $pid;

if ($pid) {

	print "Content-type: text/html \n\n";

	print "<html><head><title>List Administration</title></head><body>
	<br><br><br><center>
	<table width=280><tr><td width=280 valign=top>
	<table width=\"280\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\" bordercolor=\"#808080\" bordercolorlight=\"black\" bordercolordark=\"white\">
	<tr><td bgcolor=\"#0000A0\">
	<font face=\"arial\" size=\"2\" color=\"white\"><b>Send Status</b>
	</td></tr><tr><td bgcolor=\"#C0C0C0\"><font face=\"arial\" size=\"2\">
	<br><center>Success!<BR>The message was sent.
	<P><FORM><INPUT TYPE=BUTTON VALUE=\"Return to MLM\" onClick=\"history.go(-1)\"></form>
	</td></tr></table></td></tr></table>
	</center></body></html>";
	exit(0);
}
else {

	close (STDOUT);
	open(LIST,"$INPUT{'address_file'}");
	@addresses=<LIST>;
	close(LIST);
	
	foreach $line(@addresses) {
		chomp($line);

		open(MAIL, "|$INPUT{'mail_prog'} -t") || &error("Could not send out emails");
		print MAIL "To: $line \n";
		print MAIL "From: $INPUT{'listname'} <$INPUT{'from'}>\n";
		print MAIL "Subject: $INPUT{'subject'}\n";
		if ($INPUT{'html'}) {
		print MAIL "MIME-Version: 1.0\n"; 
		print MAIL "Content-Type: text/html;\n"; 
		print MAIL "Content-Transfer-Encoding: 7bit\n\n"; 
		}
		print MAIL "$INPUT{'body'}";
		if ($INPUT{'html'}) {
			print MAIL "<p>";
		} else {
			print MAIL "\n\n";
		}
		if ($INPUT{'unsubchk'}) {
			print MAIL "===========================================================\n";
			print MAIL "You have received this email because you subscribed to the $INPUT{'listname'} Mailing Service. ";
			if ($INPUT{'html'}) {
				print MAIL "To unsubscribe <a href=\"$INPUT{'url'}/unsub.phtml?list=$INPUT{'list'}&email=$line\">click here</a>\n";
			} else {
				print MAIL "To unsubscribe simply visit the link below.\n";
				print MAIL "$INPUT{'url'}/unsub.phtml?list=$INPUT{'list'}&email=$line\n";
			}
		}
		print MAIL "\n\n";
		close (MAIL);
	}
}	
