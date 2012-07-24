<?php
extract($_POST);

$salt = "9cd6ce28a6092be779a682f7ce38357c";

$from = "noreply@westwildcats.org";
if (isset($_GET['key'])) {
    if ($_GET['key'] ===  md5($salt . $_GET['username'])) {
        $newPass = genPassword(9);
        changeUserPassword(getUserId($_GET['username']), $newPass);
        $message = "
<p>Your new password for MW Checkout is: $newPass</p>
<p>Please change it next time you log in.</p>
            ";
        $headers  = "From: $from\r\n";
        $headers .= "Content-type: text/html\r\n";
        mail(getUserEmail(getUserId($_GET['username'])), "[MW Checkout] Your new password", $message, $headers);
        redirect("./?p=login", "Your new password has been emailed to you");
    }
}elseif (isUser($username)) {
    $key = md5($salt . $username);
    $resetLink = getUrl() . "&key=$key&username=$username";
    $message = "
<html>
<p>You, or somone who thinks they are you, have requested a password reset for the username: <strong>$username</strong>.</p>
<p>If you did not make this request, you may ignore this email.</p>
<p>Visit this link to reset your password:</p>
<p><a href=\"$resetLink\">$resetLink</a></p>
</html>
    ";
    $headers  = "From: $from\r\n";
    $headers .= "Content-type: text/html\r\n";
    mail(getUserEmail(getUserId($username)), "[MW Checkout] Reset your password", $message, $headers);
    redirect("./?p=login", "A confirmation email will be sent to your email address shortly");
}else{
    redirect("./?p=login", "The user: $username does not exist");
}
