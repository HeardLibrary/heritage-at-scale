<?php
/*****
Requires an additional config file, address.php, which defines the particular email addresses used in this script. Create address.php in this same directory and define the following variables in it: $to, $from, $replyto.

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

   // create the email and send the registration message to the folks in charge
   // $to, $from, $replyto are set in address.php config file for exclusion from the Github repo
   include ("address.php");
   $email_subject = "CHAS Registration for $name";
   $email_body = "Registration for Cultural Heritage at Scale: Crowdsourcing with a Human Face, June 2, 2017\n\nName: $name\nEmail: $email\nPhone: $phone\nInstitution: $institution\nSpecial Needs: ";
   if (!empty($special_needs)) $email_body .= $special_needs;
   else $email_body .= "None";
   $headers = "From: $from\n";
   $headers .= "Reply-To: $replyto";
   mail($to,$email_subject,$email_body,$headers);
   return true;
}

else {
   return false;
}

?>
