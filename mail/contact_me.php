<?php
/*****
Requires an additional config file, address.php, which defines the particular email addresses used in this script. Create address.php in this same directory and define the following variables in it: $to_admin, $from_admin, $replyto_admin, $to_registrant, $from_registrant, $replyto_registrant.

This file is maintained in the repo for version control purposes only -- the live script must be on a php-enabled server, as php is not supported by Github Pages.
*****/

header("Access-Control-Allow-Origin: *");

if (isset($_POST['name']) &&
   (isset($_POST['email']) && filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) &&
   isset($_POST['phone']) &&
   isset($_POST['institution'])) {
   // get form values -- not escaped since no database interaction is involved
   // existence (and validity of email) already checked on client side
   // required fields
   $name = $_POST['name'];
   $email = $_POST['email'];
   $phone = $_POST['phone'];
   $institution = $_POST['institution'];
   // optional field
   if (isset($_POST['special_needs'])) $special_needs = $_POST['special_needs'];

   // EMAIL TO ADMINS
   // create the email and send the registration message to the folks in charge
   // $to_admin, $from_admin, $replyto_admin are set in address.php config file for exclusion from the Github repo
   include ("address.php");
   $email_subject = "CHAS Registration for $name";
   $email_body = "Registration for CHAS 2019\n\nName: $name\nEmail: $email\nPhone: $phone\nInstitution: $institution\nSpecial Needs: ";
   if (!empty($special_needs)) $email_body .= $special_needs;
   else $email_body .= "None";
   $headers = "From: $from_admin\n";
   $headers .= "Reply-To: $replyto_admin";
   mail($to_admin,$email_subject,$email_body,$headers);

   // EMAIL TO REGISTRANTS
   // create the email and send the confirmation email to the registrant
   // $to_registrant, $from_registrant, $replyto_registrant are set in address.php config file for exclusion from the Github repo
   $email_subject = "CHAS Registration for $name";
   $email_body = "Thank you for registering for the Cultural Heritage at Scale conference on May 2-3, 2019. The conference will take place in the Community Room of the Vanderbilt University Library in Nashville, Tennessee. The street address is 419 21st Ave South, Nashville, TN 37203. If you have any questions about the event, please contact Susan Grider (susan.d.grider@vanderbilt.edu). We look forward to seeing you in May!";
   $email_body .= "\n\nName: $name\nEmail: $email\nPhone: $phone\nInstitution: $institution\nSpecial Needs: ";
   if (!empty($special_needs)) $email_body .= $special_needs;
   else $email_body .= "None";
   $headers = "From: $from_registrant\n";
   $headers .= "Reply-To: $replyto_registrant";
   mail($to_registrant,$email_subject,$email_body,$headers);

   return true;
}

else {
   return false;
}

?>
