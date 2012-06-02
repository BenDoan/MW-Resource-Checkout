<?php
extract($_POST);
if (isset($_GET['key'])) {
    if ($_GET['key'] ===  md5($_GET['username'])) {
        $newPass = genPassword(9);
        changeUserPassword(getUserId($_GET['username']), $newPass);
        $message = "
Your new password for MW Checkout is: $newPass
Please change it next time you log in.
            ";
        mail(getUserEmail(getUserId($_GET['username'])), "[MW Checkout] Your new password", $message);
        redirect("./", "Your new password has been emailed to you");
    }
}elseif (isUser($username)) {
    $cur_url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    $key = md5($username);
    $resetLink = "$cur_url&key=$key&username=$username";
    $message = "
You, or somone who thinks they are you, have requested a password reset for the username: <strong>$username</strong>.

If you did not make this request, you may ignore this email.

Visit this link to reset your password:
<a href=\"$resetLink\">$resetLink</a>
    ";
    mail(getUserEmail(getUserId($username)), "[MW Checkout] Reset your password", $message);
    redirect("./", "An email will be sent to your email address shortly");
}
redirect("./", "An error has occured");
