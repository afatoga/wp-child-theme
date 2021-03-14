<?php
function af_send_password_reset($user_id) {

    if ( !class_exists('WP_Mail') ) require_once ABSPATH . 'wp-content/plugins/af-restapi/app/Services/WP_Mail.php';

    $user = get_user_by('id', $user_id);

    $adt_rp_key = get_password_reset_key($user);
    //$user_login = $user->user_login;
    $siteUrl = get_site_url(null, '', 'https');

    $rp_linkURL =  $siteUrl . "/login?akce=nastaveni-hesla&reset=$adt_rp_key&login=" . rawurlencode($user->user_email);

    //$rp_link = '<a href="' . $rp_linkURL . '">' . $rp_linkURL . '</a>';
        
    $email = WP_Mail::init()
    ->to("mail@mail.com")
    ->from('VIZE 2030 <info@vize2030.cz>')
    ->subject('Registrace povolena')
    ->template(get_stylesheet_directory() . "/email-templates/password-reset.php", [
        "user_email"=>$user->user_email,
        "reset_link_url"=>$rp_linkURL
    ])
    ->send();

}
