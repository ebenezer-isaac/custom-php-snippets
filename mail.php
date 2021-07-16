<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if($_POST['button']){
{
    //Server Variables
	$server_name = "Your Name";
	$server_mail = "your_mail@domain.com";

	//Name Attributes of HTML FORM
	$sender_email = "sender_email";
	$sender_name = "sender_name";
	$contact = "contactnumber";
	$mail_subject = "subject";
	$input_file = "attachment";
	$message = "description";

	//Fetching HTML Values
	$sender_name = $_POST[$sender_name];
	$sender_mail = $_POST[$sender_email];
	$message = $_POST[$message];
	$contact= $_POST[$contact];
	$mail_subject = $_POST[$mail_subject];

	//Checking if File is uploaded
	if(isset($_FILES[$input_file])) 
	{ 
		//Main Content
		$main_subject = "Subject seen on server's mail";
		$main_body = "Hello $server_name,<br><br> 
		$sender_name ,contacted you through your website and the details are as below: <br><br> 
		Name : $sender_name <br> 
		Contact Number : $contact <br> 
		Email : $sender_mail <br> 
		Subject : $mail_subject <br> 
		Message : $message";

		//Reply Content
		$reply_subject = "Subject seen on sender's mail";
		$reply_body = "Hello $sender_name,<br> 
		\t Thank you for filling the contact form. We will revert back to you shortly.<br><br>
		This is an auto generated mail sent from our Mail Server.<br>
		Please do not reply to this mail.<br>
		Regards<br>
		$server_name";

//#############################DO NOT CHANGE ANYTHING BELOW THIS LINE#############################
		$filename= $_FILES[$input_file]['name'];
		$file = chunk_split(base64_encode(file_get_contents($_FILES[$input_file]['tmp_name'])));
		$uid = md5(uniqid(time()));
		//Sending mail to Server
		$retval = mail($server_mail, $main_subject, "--$uid\r\nContent-type:text/html; charset=iso-8859-1\r\nContent-Transfer-Encoding: 7bit\r\n\r\n $main_body \r\n\r\n--$uid\r\nContent-Type: application/octet-stream; name=\"$filename\"\r\nContent-Transfer-Encoding: base64\r\nContent-Disposition: attachment; filename=\"$filename\"\r\n\r\n$file\r\n\r\n--$uid--", "From: $sender_name <$sender_mail>\r\nReply-To: $sender_mail\r\nMIME-Version: 1.0\r\nContent-Type: multipart/mixed; boundary=\"$uid\"\r\n\r\n");
		//Sending mail to Sender
		$retval = mail($sender_mail, $reply_subject, $reply_body , "From: $server_name<$server_mail>\r\nMIME-Version: 1.0\r\nContent-type: text/html\r\n");
//#############################DO NOT CHANGE ANYTHING ABOVE THIS LINE#############################

		//Output
		if ($retval == true) {
		    echo "Message sent successfully...";
			echo "<script>window.location.replace('index.html');</script>";
		} else {
			echo "Error<br>";
		    echo "Message could not be sent...Try again later";
		    echo "<script>window.location.replace('index.html');</script>";
		}
	}else{
		echo "Error<br>";
		echo "File Not Found";
	}
}else{
	echo "Error<br>";
	echo "Unauthorised Access";
}