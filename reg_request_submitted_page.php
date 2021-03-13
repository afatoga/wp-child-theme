<?php /* Template Name: reg_request_submitted */

$email = filter_var($_GET["email"], FILTER_VALIDATE_EMAIL);
if (!$email || empty($email)) wp_redirect(site_url());

$allowedToEntry = (strpos($email, "@uhkt.cz"));

get_header();


if ($allowedToEntry) : ?>

    <p>Děkujeme za registraci, můžete se přihlásit do portálu: <a href="<?php echo site_url('/vstup'); ?>">odkaz</a></p>

<?php else : ?>

    <p>Žádost o registraci odeslána, správce Vám během několika dní odešle potvrzovací email na adresu: <strong><?php echo $email; ?></strong></p>

<?php endif; ?>


<?php get_footer(); ?>