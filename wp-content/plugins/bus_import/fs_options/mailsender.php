<?php
if (isset($_POST['toemail']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message']))
{
	$to      = $_POST['toemail'];
	$subject = 'Contact form - ' . $_POST['blogname'];
	$message = '<b>Name:</b> ' . $_POST['name'] . '<br />'
			 . '<b>E-mail:</b> ' . $_POST['email'] . '<br />' 
			 . '<b>Message:</b><br />' . $_POST['message'];
			 
	$head = array(
				  'to' 		=>     	array($_POST['toemail'] => 'Admin'),
				  'from' 	=>		array($_POST['email'] => $_POST['name'])
			  );

	$headers = 'From: ' . $_POST['email'] . "\r\n" .
		'Reply-To: '. $_POST['toemail'] . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
	
	if(mail($to, $subject, $message, $headers))
		echo "mailsentok";
	else 
		echo "mailsendfail";
}
else
	echo "mailsendfail";
