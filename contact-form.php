<?php
if(!defined('MODX_BASE_PATH')) {die("For god's sake man, what are you doing? Get the hell out of here!");}
/**
 * ContactForm
 *
 * PHP/HTML contact form with some anti-hacks, e.g. Cross-site scripting (XSS) vulnerability protection. Also uses reCaptcha to prevent form spamming.
 *
 * @category    snippet
 * @version 	1.1.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal    @properties &mail_to=Mail Submitted Contact Form To;string;
 * @internal    @modx_category Contact Form
 * @internal    @installset base
 * @documentation None
 * @author      Jason Edelbrock
 * @link        https://github.com/intelacy/snippet-contact-form.git
 * @lastupdate  11/09/2017
 */
$name=$email=$subject=$message=null;
$submitted=false;
if ($_SERVER["REQUEST_METHOD"]=="POST") {
  if (!isset($_POST['name'])) {  }
  $name=parse_input($_POST["name"]);
  $email=parse_input($_POST["email"]);
  $subject=parse_input($_POST["subject"]);
  $message=parse_input($_POST["message"]);
  if (do_submission($name, $email, $subject, $message)) { exit; } else { setError(0, ""); getError(); dumpError(); }
}
function parse_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
function do_submission($name, $email, $subject, $message) {
  global $modx;
  //$to='itdept@intelacyber.com';
  $to="{$modx->config['mail_to']}";
  $esubject='Contact Form Submission Recieved';
  $from=$email;
  $headers='MIME-Version: 1.0' . "\r\n";
  $headers.='Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $headers.='From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: Intelacyber-PHP/'.phpversion();
  $emessage='<html><body>';
  $emessage.='<p style="color:#3887D6;font-size:18px;">Name: '.$name.'</p>';
  $emessage.='<p style="color:#3887D6;font-size:18px;">Email: '.$email.'</p>';
  $emessage.='<p style="color:#3887D6;font-size:18px;">Subject: '.$subject.'</p>';
  $emessage.='<p style="color:#3887D6;font-size:18px;">Message: '.$message.'</p>';
  $emessage.='</body></html>';
  if (mail($to, $esubject, $emessage, $headers)) { return true; } else { return false; }
}
?>
<h1>Intelacyber Contact Form</h1>
<form class="form-horizontal" role="form" method="post" action="[~[*id*]~]" id="ContactForm" name="ContactForm">
<div class="form-group">
  <label for="cfName" class="col-sm-2 control-label">Name:</label>
  <div class="col-sm-10">
    <input name="name" placeholder="Your Name" id="cfName" class="form-control" type="text" eform="Your Name::1:" /></div>
</div>
<div class="form-group">
  <label for="cfEmail" class="col-sm-2 control-label">Email:</label>
  <div class="col-sm-10">
    <input name="email" placeholder="Your email address for reply" id="cfEmail" class="form-control"  type="text" eform="Email Address:email:1" /></div>
</div>
<div class="form-group">
  <label for="cfRegarding" class="col-sm-2 control-label">Subject:</label>
  <div class="col-sm-10">
    <input name="subject" placeholder="The Subject of this email"  id="cfRegarding" class="form-control" type="text"></div>
</div>
<div class="form-group">
  <label for="cfMessage" class="col-sm-2 control-label">Message:</label>
  <div class="col-sm-10">
    <textarea class="form-control" placeholder="Your message or questions" name="message" id="cfMessage" rows="4" cols="20" eform="Message:textarea:1"></textarea>
  </div>
  <div style="padding: 16px; padding-left: 142px;" class="col-sm-10">
    <div class="g-recaptcha" data-sitekey="6Lek2jcUAAAAABbbFNtXhnjc-FjRZYKV5VIEJsN1"></div>
  </div>
  <div style="padding-left: 142px;" class="col-sm-10">
    <input type="submit" style="width: 164px;" name="SubmitButton" id="cfContact" class="btn btn-success" value="Submit Form" />
  </div>
</div>
</form>
