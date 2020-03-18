<?php

require_once __DIR__ . '/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')) {

    $transport = (new Swift_SmtpTransport('smtp.jino.ru', 587))
        ->setUsername('test@polcher.ru')
        ->setPassword('1111')
        ->setEncryption('tls');

    $mailer = new Swift_Mailer($transport);

    $to = ['test@polcher.ru' => 'ADMIN'];

    $from = 'test@polcher.ru';

    $name  = filter_var(trim($_POST['nsp']),  FILTER_SANITIZE_STRING);
    $company  = filter_var(trim($_POST['company']),  FILTER_SANITIZE_STRING);
    $tel   = filter_var(trim($_POST['phone']),   FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $prod  = filter_var(trim($_POST['prod']),  FILTER_SANITIZE_STRING);

    if (empty($name) || empty($company) || empty($email) || empty($prod)) {
        echo 'Произошла ошибка при отправке сообщения. Пожалуйста, попробуйте позже.';
        die;
    }

    $tel = $tel ?: '-';

    $adminText = <<<MESS
<b>Продукт</b>: {$prod}<br>
<b>Имя клиента</b>: {$name}<br>
<b>Компания</b>: {$company}<br>
<b>Телефон</b>: {$tel}<br>
<b>E-mail</b>: {$email}<br>
MESS;

    $clientText = <<<MESS
Dear <b>{$name}</b>,<br><br>
Thank You for contacting to our company. Quotation for full production line for cereal mass led by forming machine for cereal mass <b>MMC-200</b> please find enclosed. Forming machine {$prod} have working width 200 mm and capacity up to 5 400 bars/h. Also quotation have additional equipment for installing full complete producing line. Also we produce forming machine MMC with working width 200, 400, 600 mm. Diferent working width — different capacity. You can choose any equipment from quotation as single machine or as full line.<br><br>
If You will need more information or You will have any questions, please let me know, I will help You.
<br><br>
Best regards,<br><br>
Sweets Technologies team<br>
<img src="https://sweetstech.com/mmc-200/assets/img/logo_mail.png" alt=""> <br><br><br>
We offer more details about the machines of our production:<br><br>
Forming machine for cereals bars MMC-400 <br>
<a href="https://youtu.be/wnyeSNFc4PA">https://youtu.be/wnyeSNFc4PA</a> <br><br>
Molding machine for plastics masses RFM-200 <br>
<a href="https://youtu.be/XwlpGS1u4LE">https://youtu.be/XwlpGS1u4LE</a> <br>
MESS;

    $messageToAdmin = (new Swift_Message("Заказ на обратный звонок"))
        ->setFrom([$from => $from])
        ->setTo($to)
        ->setBody($adminText, 'text/html')
    ;

    $messageToClient = (new Swift_Message("Forming machine for cereal mass MMC."))
        ->setFrom([$from => $from])
        ->setTo([$email => $name])
        ->setBody($clientText, 'text/html')
        ->attach(Swift_Attachment::fromPath(__DIR__ . '/assets/Quotation Cereal mass 200.pdf'))
    ;

    $result = $mailer->send($messageToAdmin);

    $mailer->send($messageToClient);

    if($result === 1) { // если всё хорошо и письмо было отправлено
        echo 'Thanks! Your application has been sent successfully! Expect feedback on the provided contact details.';
    }
    else { // если произошла ошибка и письмо не было отправлено
        echo 'Error has occurred. Please check the data you entered.';
    }
    die;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>AUTOMATIC FORMING MACHINE MMC-400 | Sweets Technologies Ltd.</title>
    <link rel="stylesheet" href="/mmc-200/css/bootstrap.min.css">    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha256-UhQQ4fxEeABh4JrcmAJ1+16id/1dnlOEVCFOxDef9Lw=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha256-kksNxjDRxd/5+jGurZUJd1sdR2v+ClrCl3svESBaJqw=" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="/mmc-200/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="/mmc-200/css/landings.css">
</head>
<body>
    <header class="header js-header">
        <div class="header-wrapper js-header-wrapper">
            <div class="logo">
                <a href="/" class="logo-link">
                    <img src="/mmc-200/assets/img/logo.png" alt="sweets technologies logo" class="logo-img">
                </a>
            </div>
            <nav class="main_nav js-main_nav">
                <ul class="main_nav-list js-main_nav-list">
                    <li class="main_nav-item">
                        <a data-section="specifications" class="main_nav-link js-main_nav-link">
                        <span class="main_nav-icon">
                            <svg height="512pt" viewBox="0 0 512 512" width="512pt" xmlns="http://www.w3.org/2000/svg"><path
                                    d="m512 452.015625c0-.003906 0-.011719 0-.015625 0-.007812 0-.015625 0-.019531v-350.945313c0-33.082031-26.914062-60-60-60h-362.183594c-2.015625-22.960937-21.339844-41.035156-44.816406-41.035156-24.8125 0-45 20.1875-45 45v317c0 33.085938 26.914062 60 60 60h362.023438v72.433594c0 6.363281 4.007812 12.03125 10.007812 14.144531 6.464844 2.285156 13.195312 3.40625 19.894531 3.40625 12.28125 0 24.464844-3.765625 34.753907-11.046875 15.769531-11.15625 24.925781-28.519531 25.285156-47.769531.011718-.222657.035156-.441407.035156-.667969zm-467-422.015625c8.269531 0 15 6.730469 15 15v257c-10.925781 0-21.167969 2.949219-30 8.070312v-265.070312c0-8.269531 6.730469-15 15-15zm-15 332c0-16.542969 13.457031-30 30-30 3.410156 0 6.769531.574219 9.984375 1.710938 7.8125 2.753906 16.378906-1.34375 19.136719-9.152344.570312-1.613282.832031-3.257813.84375-4.875.011718-.230469.035156-.457032.035156-.6875v-247.960938h362c16.542969 0 30 13.457032 30 30v299.035156c-8.234375-4.773437-17.695312-7.648437-27.792969-8.015624-.359375-.027344-.722656-.054688-1.089843-.054688h-393.117188c-16.542969 0-30-13.457031-30-30zm439.351562 114.449219c-5.210937 3.6875-11.207031 5.578125-17.296874 5.578125-.011719 0-.019532 0-.03125 0v-60.027344h.035156c16.507812.035156 29.929687 13.46875 29.941406 29.980469v.035156c-.007812 9.84375-4.613281 18.75-12.648438 24.433594zm0 0"/><path
                                    d="m391.4375 203.507812-27.164062-10.5625 11.738281-26.675781c2.488281-5.660156 1.25-12.273437-3.125-16.644531l-20.519531-20.519531c-4.375-4.375-10.984376-5.613281-16.644532-3.121094l-26.675781 11.738281-10.5625-27.160156c-2.242187-5.765625-7.792969-9.566406-13.980469-9.566406h-29.015625c-6.183593 0-11.738281 3.800781-13.980469 9.566406l-10.5625 27.160156-26.675781-11.734375c-5.660156-2.492187-12.273437-1.25-16.644531 3.121094l-20.515625 20.519531c-4.375 4.371094-5.617187 10.984375-3.125 16.644532l11.738281 26.675781-27.160156 10.5625c-5.765625 2.246093-9.5625 7.796875-9.5625 13.980469v29.015624c0 6.1875 3.796875 11.738282 9.5625 13.980469l27.164062 10.5625-11.738281 26.675781c-2.488281 5.660157-1.25 12.273438 3.125 16.644532l20.515625 20.519531c4.375 4.375 10.984375 5.617187 16.648438 3.121094l26.675781-11.734375 10.5625 27.160156c2.242187 5.761719 7.792969 9.5625 13.980469 9.5625h29.015625c6.183593 0 11.734375-3.800781 13.976562-9.5625l10.566407-27.164062 26.671874 11.734374c5.664063 2.492188 12.273438 1.253907 16.648438-3.121093l20.515625-20.515625c4.375-4.375 5.617187-10.988282 3.125-16.648438l-11.738281-26.675781 27.160156-10.5625c5.765625-2.242187 9.566406-7.792969 9.566406-13.980469v-29.015625c-.003906-6.183593-3.800781-11.738281-9.566406-13.980469zm-20.4375 32.734376-26.550781 10.328124c-4.085938 1.589844-7.269531 4.882813-8.71875 9.019532-.761719 2.167968-1.640625 4.324218-2.617188 6.414062-1.828125 3.917969-1.878906 8.433594-.140625 12.390625l11.449219 26.019531-6.003906 6.003907-25.695313-11.304688c-4.011718-1.765625-8.597656-1.6875-12.550781.214844-2.175781 1.050781-4.46875 2.007813-6.808594 2.839844-4.105469 1.460937-7.371093 4.632812-8.949219 8.691406l-10.164062 26.136719h-8.492188l-10.167968-26.136719c-1.578125-4.058594-4.84375-7.230469-8.949219-8.691406-2.335937-.832031-4.628906-1.789063-6.8125-2.839844-3.949219-1.902344-8.535156-1.980469-12.546875-.214844l-25.695312 11.308594-6.003907-6.007813 11.445313-26.015624c1.742187-3.960938 1.691406-8.476563-.140625-12.394532-.972657-2.082031-1.855469-4.242187-2.617188-6.414062-1.449219-4.136719-4.636719-7.429688-8.71875-9.015625l-26.550781-10.324219v-8.492188l27.007812-10.507812c4.003907-1.554688 7.148438-4.757812 8.636719-8.789062.71875-1.949219 1.542969-3.898438 2.445313-5.796876 1.875-3.9375 1.945312-8.496093.1875-12.492187l-11.699219-26.585937 6.007813-6.003907 26.910156 11.839844c3.9375 1.730469 8.429687 1.6875 12.332031-.113281 1.785156-.828125 3.605469-1.578125 5.40625-2.230469 4.0625-1.476563 7.289063-4.632813 8.855469-8.664063l10.664062-27.414062h8.492188l10.664062 27.414062c1.566406 4.03125 4.792969 7.1875 8.855469 8.664063 1.800781.652344 3.617187 1.402344 5.402344 2.226563 3.902343 1.804687 8.394531 1.847656 12.335937.113281l26.910156-11.839844 6.003907 6.003906-11.695313 26.589844c-1.757812 3.992187-1.6875 8.550781.1875 12.488281.902344 1.894532 1.726563 3.847656 2.445313 5.800782 1.488281 4.027343 4.632812 7.226562 8.636719 8.785156l27.007812 10.503906zm0 0"/><path
                                    d="m270 184.117188c-26.707031 0-48.433594 21.726562-48.433594 48.433593s21.726563 48.4375 48.433594 48.4375 48.4375-21.730469 48.4375-48.4375-21.730469-48.433593-48.4375-48.433593zm0 66.871093c-10.164062 0-18.433594-8.269531-18.433594-18.4375 0-10.164062 8.269532-18.433593 18.433594-18.433593s18.4375 8.269531 18.4375 18.433593c0 10.167969-8.273438 18.4375-18.4375 18.4375zm0 0"/></svg>
                        </span>
                            <span class="main_nav-txt">Specification</span>
                        </a>
                    </li>
                    <li class="main_nav-item">
                        <a data-section="products" class="main_nav-link js-main_nav-link">
                        <span class="main_nav-icon">
                            <svg height="661pt" viewBox="-20 -40 661.33331 661" width="661pt"
                                 xmlns="http://www.w3.org/2000/svg"><path
                                    d="m10 248.832031h55.476562c3.28125 11.832031 8.007813 23.214844 14.085938 33.882813l-39.265625 39.25c-1.875 1.875-2.929687 4.417968-2.929687 7.074218s1.054687 5.199219 2.929687 7.074219l42.421875 42.433594c3.90625 3.898437 10.234375 3.898437 14.140625 0l39.269531-39.273437c10.667969 6.074218 22.039063 10.804687 33.871094 14.082031v55.476562c0 5.523438 4.476562 10 10 10h60c5.523438 0 10-4.476562 10-10v-55.476562c11.832031-3.277344 23.203125-8.007813 33.871094-14.082031l39.269531 39.273437c3.96875 3.75 10.175781 3.75 14.140625 0l42.429688-42.433594c1.875-1.875 2.929687-4.417969 2.929687-7.074219s-1.054687-5.199218-2.929687-7.074218l-39.273438-39.25c6.078125-10.667969 10.804688-22.050782 14.085938-33.882813h55.476562c5.523438 0 10-4.476562 10-10v-60c0-5.519531-4.476562-10-10-10h-55.476562c-3.28125-11.828125-8.007813-23.210937-14.085938-33.878906l39.265625-39.25c1.875-1.875 2.929687-4.417969 2.929687-7.074219s-1.054687-5.199218-2.929687-7.074218l-42.421875-42.433594c-3.90625-3.902344-10.234375-3.902344-14.140625 0l-39.269531 39.273437c-10.667969-6.070312-22.042969-10.800781-33.871094-14.082031v-55.480469c0-5.519531-4.476562-10-10-10h-60c-5.523438 0-10 4.480469-10 10v55.480469c-11.828125 3.28125-23.203125 8.011719-33.871094 14.082031l-39.269531-39.273437c-3.96875-3.75-10.175781-3.75-14.140625 0l-42.429688 42.433594c-1.875 1.875-2.929687 4.417968-2.929687 7.074218s1.054687 5.199219 2.929687 7.074219l39.273438 39.25c-6.078125 10.667969-10.804688 22.050781-14.085938 33.878906h-55.476562c-5.523438 0-10 4.480469-10 10v60c0 5.523438 4.476562 10 10 10zm10-60h53.300781c4.699219 0 8.765625-3.269531 9.769531-7.859375 3.28125-14.976562 9.214844-29.25 17.519532-42.140625 2.535156-3.953125 1.972656-9.144531-1.351563-12.46875l-37.738281-37.738281 28.289062-28.292969 37.730469 37.738281c3.324219 3.332032 8.519531 3.894532 12.480469 1.355469 12.894531-8.300781 27.164062-14.234375 42.140625-17.519531 4.585937-1.007812 7.859375-5.074219 7.859375-9.773438v-53.300781h40v53.300781c0 4.699219 3.273438 8.765626 7.859375 9.773438 14.976563 3.285156 29.246094 9.21875 42.140625 17.519531 3.960938 2.539063 9.15625 1.976563 12.480469-1.355469l37.730469-37.738281 28.28125 28.292969-37.730469 37.726562c-3.332031 3.328126-3.890625 8.523438-1.351563 12.480469 8.304688 12.898438 14.230469 27.167969 17.507813 42.148438 1.007812 4.589843 5.074219 7.863281 9.769531 7.863281h53.3125v40h-53.3125c-4.695312 0-8.761719 3.269531-9.769531 7.859375-3.277344 14.976563-9.207031 29.246094-17.507813 42.128906-2.535156 3.957031-1.972656 9.148438 1.351563 12.472657l37.738281 37.730468-28.289062 28.300782-37.730469-37.742188c-3.324219-3.328125-8.519531-3.890625-12.480469-1.351562-12.886719 8.304687-27.152344 14.238281-42.128906 17.519531-4.59375 1-7.871094 5.070312-7.871094 9.769531v53.300781h-40v-53.300781c0-4.699219-3.277344-8.769531-7.871094-9.769531-14.976562-3.28125-29.242187-9.214844-42.128906-17.519531-3.960938-2.539063-9.15625-1.976563-12.480469 1.351562l-37.730469 37.742188-28.28125-28.292969 37.730469-37.730469c3.332031-3.324219 3.890625-8.519531 1.351563-12.480469-8.304688-12.894531-14.238282-27.167969-17.519532-42.148437-1.007812-4.589844-5.070312-7.851563-9.769531-7.851563h-53.300781zm0 0"/><path
                                    d="m210 288.832031c44.183594 0 80-35.8125 80-80 0-44.183593-35.816406-80-80-80s-80 35.816407-80 80c.046875 44.160157 35.839844 79.953125 80 80zm0-140c33.132812 0 60 26.867188 60 60 0 33.136719-26.867188 60-60 60s-60-26.863281-60-60c.035156-33.125 26.875-59.964843 60-60zm0 0"/><path
                                    d="m210 318.832031c60.75 0 110-49.246093 110-110 0-60.75-49.25-110-110-110s-110 49.25-110 110c.074219 60.722657 49.277344 109.929688 110 110zm0-200c49.707031 0 90 40.292969 90 90s-40.292969 90-90 90-90-40.292969-90-90c.054688-49.679687 40.316406-89.945312 90-90zm0 0"/><path
                                    d="m570 458.832031v-80c0-5.519531-4.476562-10-10-10h-20v-80c0-5.519531-4.476562-10-10-10h-90c-5.523438 0-10 4.480469-10 10v80h-50c-5.523438 0-10 4.480469-10 10v80h-320c-27.601562.035157-49.9648438 22.398438-50 50v20c.0351562 27.605469 22.398438 49.96875 50 50h520c27.601562-.03125 49.964844-22.394531 50-50v-20c-.035156-27.601562-22.398438-49.964843-50-50zm-20 0h-70v-70h70zm-100-160h70v70h-70zm-60 90h70v70h-70zm210 140c0 16.570313-13.433594 30-30 30h-520c-16.566406 0-30-13.429687-30-30v-20c0-16.566406 13.433594-30 30-30h520c16.566406 0 30 13.433594 30 30zm0 0"/><path
                                    d="m310 488.832031c-16.566406 0-30 13.433594-30 30 0 16.570313 13.433594 30 30 30s30-13.429687 30-30c0-16.566406-13.433594-30-30-30zm0 40c-5.523438 0-10-4.476562-10-10 0-5.519531 4.476562-10 10-10s10 4.480469 10 10c0 5.523438-4.476562 10-10 10zm0 0"/><path
                                    d="m210 488.832031c-16.566406 0-30 13.433594-30 30 0 16.570313 13.433594 30 30 30s30-13.429687 30-30c0-16.566406-13.433594-30-30-30zm0 40c-5.523438 0-10-4.476562-10-10 0-5.519531 4.476562-10 10-10s10 4.480469 10 10c0 5.523438-4.476562 10-10 10zm0 0"/><path
                                    d="m410 488.832031c-16.566406 0-30 13.433594-30 30 0 16.570313 13.433594 30 30 30s30-13.429687 30-30c0-16.566406-13.433594-30-30-30zm0 40c-5.523438 0-10-4.476562-10-10 0-5.519531 4.476562-10 10-10s10 4.480469 10 10c0 5.523438-4.476562 10-10 10zm0 0"/><path
                                    d="m110 488.832031c-16.566406 0-30 13.433594-30 30 0 16.570313 13.433594 30 30 30s30-13.429687 30-30c0-16.566406-13.433594-30-30-30zm0 40c-5.523438 0-10-4.476562-10-10 0-5.519531 4.476562-10 10-10s10 4.480469 10 10c0 5.523438-4.476562 10-10 10zm0 0"/><path
                                    d="m510 488.832031c-16.566406 0-30 13.433594-30 30 0 16.570313 13.433594 30 30 30s30-13.429687 30-30c0-16.566406-13.433594-30-30-30zm0 40c-5.523438 0-10-4.476562-10-10 0-5.519531 4.476562-10 10-10s10 4.480469 10 10c0 5.523438-4.476562 10-10 10zm0 0"/></svg>
                        </span>
                            <span class="main_nav-txt">Products</span>
                        </a>
                    </li>
                    <li class="main_nav-item">
                        <a data-section="line" class="main_nav-link js-main_nav-link">
                        <span class="main_nav-icon">
                            <svg height="512pt" viewBox="0 0 511 512" width="512pt" xmlns="http://www.w3.org/2000/svg"><path
                                    d="m512.441406 382.957031c0-41.351562-33.640625-74.992187-74.992187-74.992187h-16v-44.996094c0-8.28125-6.714844-14.996094-14.996094-14.996094h-59.992187c-8.285157 0-15 6.714844-15 14.996094v44.996094h-29.996094v-44.996094c0-8.28125-6.714844-14.996094-15-14.996094h-59.992188c-8.28125 0-14.996094 6.714844-14.996094 14.996094v44.996094h-29.996093v-44.996094c0-8.28125-6.71875-14.996094-15-14.996094h-59.992188c-8.285156 0-15 6.714844-15 14.996094v44.996094h-15.996093c-41.351563 0-74.992188 33.640625-74.992188 74.992187 0 35.5 24.808594 65.296875 57.992188 73.023438v41.019531c0 8.285156 6.714843 15 15 15 8.28125 0 14.996093-6.714844 14.996093-15v-38.054688h29.996094v37.972657c0 8.28125 6.71875 14.996093 15 14.996093s15-6.714843 15-14.996093v-38.972657h215.972656v38.964844c0 8.285156 6.714844 15 15 15 8.28125 0 14.996094-6.714844 14.996094-15v-37.964844h29.996094v37.964844c0 8.285156 6.714843 15 15 15 8.28125 0 14.996093-6.714844 14.996093-15v-40.929687c33.1875-7.722657 57.996094-37.523438 57.996094-73.023438zm-150.984375-104.988281h29.996094v29.996094h-29.996094zm-119.984375 0h29.996094v29.996094h-29.996094zm-119.988281 0h29.996094v29.996094h-29.996094zm315.964844 149.980469h-361.957031c-24.8125 0-44.996094-20.183594-44.996094-44.992188 0-24.8125 20.183594-44.996093 44.996094-44.996093h361.957031c24.808593 0 44.996093 20.183593 44.996093 44.996093 0 24.808594-20.1875 44.992188-44.996093 44.992188zm0 0"/><path
                                    d="m81.492188 367.957031c-8.261719 0-15 6.738281-15 15 0 8.257813 6.738281 14.996094 15 14.996094 8.261718 0 14.996093-6.738281 14.996093-14.996094 0-8.261719-6.738281-15-14.996093-15zm0 0"/><path
                                    d="m141.484375 367.957031c-8.261719 0-15 6.738281-15 15 0 8.257813 6.738281 14.996094 15 14.996094s15-6.738281 15-14.996094c-.003906-8.261719-6.738281-15-15-15zm0 0"/><path
                                    d="m201.476562 367.957031c-8.261718 0-15 6.738281-15 15 0 8.257813 6.738282 14.996094 15 14.996094 8.261719 0 15-6.738281 15-14.996094 0-8.261719-6.738281-15-15-15zm0 0"/><path
                                    d="m261.46875 367.957031c-8.257812 0-14.996094 6.738281-14.996094 15 0 8.257813 6.738282 14.996094 14.996094 14.996094 8.261719 0 15-6.738281 15-14.996094 0-8.261719-6.738281-15-15-15zm0 0"/><path
                                    d="m321.460938 367.957031c-8.257813 0-14.996094 6.738281-14.996094 15 0 8.257813 6.738281 14.996094 14.996094 14.996094 8.261718 0 15-6.738281 15-14.996094 0-8.261719-6.738282-15-15-15zm0 0"/><path
                                    d="m381.457031 367.957031c-8.261719 0-15 6.738281-15 15 0 8.257813 6.738281 14.996094 15 14.996094 8.257813 0 14.996094-6.738281 14.996094-14.996094 0-8.261719-6.738281-15-14.996094-15zm0 0"/><path
                                    d="m441.449219 367.957031c-8.261719 0-15 6.738281-15 15 0 8.257813 6.738281 14.996094 15 14.996094 8.257812 0 14.996093-6.738281 14.996093-14.996094 0-8.261719-6.738281-15-14.996093-15zm0 0"/><path
                                    d="m44.996094 59.992188h196.476562v57.992187h-20c-3.976562 0-7.789062 1.582031-10.605468 4.394531l-22.996094 23c-2.8125 2.8125-4.390625 6.625-4.390625 10.601563v51.996093c0 8.28125 6.714843 14.996094 14.996093 14.996094 8.285157 0 15-6.714844 15-14.996094v-45.78125l14.210938-14.210937h57.566406l14.210938 14.210937v45.78125c0 8.28125 6.714844 14.996094 15 14.996094 8.28125 0 14.996094-6.714844 14.996094-14.996094v-51.996093c0-3.976563-1.582032-7.792969-4.394532-10.601563l-22.996094-23c-2.8125-2.8125-6.625-4.394531-10.605468-4.394531h-19.996094v-57.992187h196.472656c8.285156 0 15-6.714844 15-15v-29.992188c0-8.285156-6.714844-15-15-15-8.28125 0-14.996094 6.714844-14.996094 15v14.996094h-392.949218v-14.996094c0-8.285156-6.714844-15-15-15-8.28125 0-14.996094 6.714844-14.996094 15v29.992188c0 8.285156 6.714844 15 14.996094 15zm0 0"/></svg>
                        </span>
                            <span class="main_nav-txt">Line</span>
                        </a>
                    </li>
                    <li class="main_nav-item">
                        <a data-section="contacts" class="main_nav-link js-main_nav-link">
                        <span class="main_nav-icon">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
<g>
  <g>
    <path d="M482,233.808V225C482,99.803,378.544,0,255,0C130.643,0,30,100.632,30,225v8.808C10.78,251.61,0,276.097,0,302
      c0,49.626,40.374,90,90,90c14.061,0,5.523,0,45,0c24.813,0,45-20.187,45-45v-92c0-24.813-20.187-45-45-45h-14.162
      C128.324,142.595,185.631,90,255,90c70.396,0,128.553,52.595,136.15,120H377c-24.813,0-45,20.187-45,45v92
      c0,24.813,20.187,45,45,45h15v15c0,24.813-20.187,45-45,45h-17.58c-6.192-17.458-22.865-30-42.42-30h-32
      c-24.813,0-45,20.187-45,45s20.187,45,45,45h32c19.555,0,36.228-12.542,42.42-30H347c41.355,0,75-33.645,75-75v-15
      c49.626,0,90-40.374,90-90C512,276.139,501.25,251.638,482,233.808z M287,482h-32c-8.271,0-15-6.729-15-15s6.729-15,15-15h32
      c8.271,0,15,6.729,15,15S295.271,482,287,482z M90,362c-33.084,0-60-26.916-60-60c0-33.607,27.477-62,60-62V362z M135,240
      c8.271,0,15,6.729,15,15v92c0,8.271-6.729,15-15,15h-15V240H135z M392,362h-15c-8.271,0-15-6.729-15-15v-92
      c0-8.271,6.729-15,15-15h15V362z M421.303,210C413.634,126.44,341.763,60,255,60c-85.925,0-156.707,66.022-164.311,150H90
      c-10.276,0-20.302,1.796-29.755,5.236C65.349,112.231,150.751,30,255,30c105.318,0,191.595,82.23,196.753,185.235
      C442.3,211.796,432.275,210,422,210H421.303z M422,362V240c32.523,0,60,28.393,60,62C482,335.084,455.084,362,422,362z"/>
  </g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
</svg>
                        </span>
                            <span class="main_nav-txt">Contacts</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <button class="main_nav-show js-main_nav-show" type="button">
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                     x="0px" y="0px"
                     viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
<g>
    <g>
        <path d="M467,61H165c-24.813,0-45,20.187-45,45s20.187,45,45,45h302c24.813,0,45-20.187,45-45S491.813,61,467,61z M467,121H165
      c-8.271,0-15-6.729-15-15s6.729-15,15-15h302c8.271,0,15,6.729,15,15S475.271,121,467,121z"/>
    </g>
</g>
                    <g>
                        <g>
                            <path d="M467,211H165c-24.813,0-45,20.187-45,45s20.187,45,45,45h302c24.813,0,45-20.187,45-45S491.813,211,467,211z M467,271H165
      c-8.271,0-15-6.729-15-15s6.729-15,15-15h302c8.271,0,15,6.729,15,15S475.271,271,467,271z"/>
                        </g>
                    </g>
                    <g>
                        <g>
                            <path d="M467,361H165c-24.813,0-45,20.187-45,45s20.187,45,45,45h302c24.813,0,45-20.187,45-45S491.813,361,467,361z M467,421H165
      c-8.271,0-15-6.729-15-15s6.729-15,15-15h302c8.271,0,15,6.729,15,15S475.271,421,467,421z"/>
                        </g>
                    </g>
                    <g>
                        <g>
                            <path d="M45,61C20.187,61,0,81.187,0,106s20.187,45,45,45s45-20.187,45-45S69.813,61,45,61z M45,121c-8.271,0-15-6.729-15-15
      s6.729-15,15-15s15,6.729,15,15S53.271,121,45,121z"/>
                        </g>
                    </g>
                    <g>
                        <g>
                            <path d="M45,211c-24.813,0-45,20.187-45,45s20.187,45,45,45s45-20.187,45-45S69.813,211,45,211z M45,271c-8.271,0-15-6.729-15-15
      s6.729-15,15-15s15,6.729,15,15S53.271,271,45,271z"/>
                        </g>
                    </g>
                    <g>
                        <g>
                            <path d="M45,361c-24.813,0-45,20.187-45,45s20.187,45,45,45s45-20.187,45-45S69.813,361,45,361z M45,421c-8.271,0-15-6.729-15-15
      s6.729-15,15-15s15,6.729,15,15S53.271,421,45,421z"/>
                        </g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
</svg>
            </button>
        </div>
    </header>

<main class="main">
    <div class="main-title_wrapper">
        <div class="w-75 mr-auto ml-auto title-header">
        <div class="text-header-title">
        <h1 class="main-title">AUTOMATIC FORMING MACHINE MMC-400</h1>
        </div>
        </div>
        <div class="w-75 mr-auto ml-auto ">
            <div class="text-header text-center">
                <h2>FOR PRODUCING THE PRODUCTS OF CEREAL MASS</h2>
        <h4>In production the product, you can use various ingredients, for example, such as protein balls, puffed rice, coconut flakes, peeled sunflower seeds, dried apricots and other chopped dried fruits, crushed nuts, poppy seeds, whole kernel nuts, various cereals, balls, extruded products: corn, rice, protein, etc. Sublimated fruits, berries, crushed waffles, it all depends on your imagination and needs.</h4>
        <h4>Syrup acts as a binder, and it is also possible to add honey, or condensed milk or chocolate, etc. Or the use of sublimated syrups such as Molda 13.</h4>
</div>
</div>
    </div>
    <section id="specifications" class="section-padding specifications">
        <h2 class="section-title">Specifications</h2>
        <div class="specifications-wrapper">
            <div class="specifications-text">
                <ul class="specifications-list">
                    <li class="specifications-item">
                        <span class="pro-title">Working width: </span>
                        <span class="pro-detail">200 mm</span>
                    </li>
                         <li class="specifications-item">
                            <span class="pro-title">Roller Diameter: </span>
                        <span class="pro-detail">250 mm</span>
                    </li>
                    <li class="specifications-item">
                        <span class="pro-title">Capacity: </span>
                        <span class="pro-detail">up to 5400 bars / hour *</span>
                    </li>
                    <li class="specifications-item">
                        <span class="pro-title">Energy Efficiency Class: </span>
                        <span class="pro-detail">IE 3</span>
                    </li>          
                    <li class="specifications-item">
                        <span class="pro-title">Irrigation device: </span>
                        <span class="pro-detail">1 pc.</span>
                    </li>           
                    <li class="specifications-item">
                        <span class="pro-title">Tacts/min: </span>
                        <span class="pro-detail">10-55 </span>
                    </li>
                    <li class="specifications-item">
                        <span class="pro-title">Compressed air: </span>
                        <span class="pro-detail">6 bar</span>
                    </li>
                    <li class="specifications-item">
                        <span class="pro-title">Weight: </span>
                        <span class="pro-detail">220 kg</span>
                    </li>
                    <li class="specifications-item">
                        <span class="pro-title">Air consumption: </span>
                        <span class="pro-detail">~70 l/min</span>
                    </li>
                    <li class="specifications-item">
                        <span class="pro-title">Electric power: </span>
                        <span class="pro-detail">380 V, 50 Hz, 3 phases</span>
                    </li>
                    <li class="specifications-item">
                        <span class="pro-title">Dimensions LxWxH: </span>
                        <span class="pro-detail">900х780х770 mm</span>
                    </li>
                        <li class="specifications-item">
                        <span class="pro-title">Fully automatic  by touch screen panel</span>
                    </li>
                    </li>
                        <li class="specifications-item last-specifications-item">
                        <span class="pro-detail-dop">* When calculating a bar size 95*30*15 mm</span>
                    </li>
                </ul>
            </div>
            <div class="specifications-slider_wrapper">
                <div class="specifications-slider owl-carousel owl-theme">
                    <div><img src="/mmc-400/assets/img/400/MMC400-1jpg.jpg" alt=""></div>
                    <div><img src="/mmc-400/assets/img/400/MMC400-2jpg.jpg" alt=""></div>
                    <div><img src="/mmc-400/assets/img/400/MMC400-3jpg.jpg" alt=""></div>
                </div>
            </div>
        </div>
    </section>

<section>
    <h2 class="section-title section-title-advantages">Advantages</h2>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 text-center">
                    <div class="why">
                        <div class="why-icon">
                    <svg width="72pt" height="72pt"  id="Слой_1" data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 394.4 385.5">
  <defs>
    <style>
      .gr1, .gr {
        fill: #2e3192;
      }

      .gr1 {
        stroke: #2e3192;
        stroke-linecap: round;
        stroke-miterlimit: 10;
        stroke-width: 5px;
      }
    </style>
  </defs>
  <g>
    <rect class="gr1" x="2.5" y="338" width="388.67" height="45"/>
    <rect class="gr1" x="19.51" y="247.67" width="53" height="92.87"/>
    <rect class="gr1" x="93.01" y="208" width="53" height="129.54"/>
    <rect class="gr1" x="167.18" y="174.33" width="53" height="164.21"/>
    <rect class="gr1" x="241.35" y="135.33" width="53" height="213.54"/>
    <polygon class="gr" points="394.4 52.86 341.74 21.67 288.61 52.86 310.69 52.86 310.69 337.67 372.72 337.67 372.72 52.86 394.4 52.86"/>
    <path class="gr" d="M95.22,163.35H83.36s18.38,8.3,19,29.65c.59-21.35,19-29.65,19-29.65H109.45V42h11.86s-18.39-8.3-19-29.65c-.59,21.35-19,29.65-19,29.65H95.22Z" transform="translate(-4.17 -12.33)"/>
    <path class="gr" d="M160.4,53.33l8.39,8.39s-7.13-18.87,7.54-34.39C160.82,42,142,34.88,142,34.88l8.39,8.39L111.27,82.34,102.88,74s7.13,18.87-7.55,34.38c15.52-14.67,34.39-7.54,34.39-7.54l-8.39-8.39Z" transform="translate(-4.17 -12.33)"/>
    <path class="gr" d="M172.35,108.78v11.86s8.3-18.38,29.65-19c-21.35-.59-29.65-19-29.65-19V94.55H51V82.69s-8.3,18.39-29.65,19c21.35.59,29.65,19,29.65,19V108.78Z" transform="translate(-4.17 -12.33)"/>
  </g>
</svg>

                    </div>
                    <hr>
                    <p class="text-center">Compact and high capacity of the forming machine MMC-400</p>
                    </div>
                </div>    
                <div class="clearfix"></div>
                <div class="col-md-3 text-center">
                    <div class="why">
                        <div class="why-icon">
<svg width="72pt" height="72pt" id="Слой_1" data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 370.87 371.34">
  <defs>
    <style>
      .cls-1 {
        fill: #2e3192;
      }

      .cls-2 {
        fill: #fff;
        stroke: #2e3192;
        stroke-miterlimit: 10;
      }
    </style>
  </defs>
  <circle class="gr" cx="46.91" cy="94.54" r="38.16"></circle>
  <rect class="gr" x="129.21" width="105.7" height="62.28"></rect>
  <rect class="gr" x="299.05" y="71.77" width="64.91" height="64.91"></rect>
  <ellipse class="gr" cx="334.46" cy="284.16" rx="30.7" ry="55.48"></ellipse>
  <polygon class="gr" points="72.44 289.37 31.58 302.24 0 273.3 9.28 231.47 50.14 218.6 81.72 247.55 72.44 289.37"></polygon>
  <polygon class="gr" points="207.72 368.51 178.22 354.81 150.21 371.34 154.13 339.06 129.75 317.53 161.67 311.27 174.61 281.43 190.42 309.86 222.79 312.94 200.65 336.76 207.72 368.51"></polygon>
  <g>
    <ellipse class="cls-2" cx="136.67" cy="204.8" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="137.68" cy="204.25" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="138.69" cy="203.71" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="139.71" cy="203.16" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="140.72" cy="202.61" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="141.73" cy="202.06" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="142.74" cy="201.51" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="143.75" cy="200.96" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="144.76" cy="200.42" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="145.78" cy="199.87" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="146.79" cy="199.32" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="147.8" cy="198.77" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="148.81" cy="198.22" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="149.82" cy="197.68" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="150.83" cy="197.13" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="151.84" cy="196.58" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="152.86" cy="196.03" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="153.87" cy="195.48" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="154.88" cy="194.93" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="155.89" cy="194.39" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="156.9" cy="193.84" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="157.91" cy="193.29" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="158.93" cy="192.74" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="159.94" cy="192.19" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="160.95" cy="191.65" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="161.96" cy="191.1" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="162.97" cy="190.55" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="163.98" cy="190" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="164.99" cy="189.45" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="166.01" cy="188.9" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="167.02" cy="188.36" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="168.03" cy="187.81" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="169.04" cy="187.26" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="170.05" cy="186.71" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="171.06" cy="186.16" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="172.07" cy="185.62" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="173.09" cy="185.07" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="174.1" cy="184.52" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="175.11" cy="183.97" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="176.12" cy="183.42" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="177.13" cy="182.87" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="178.14" cy="182.33" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="179.16" cy="181.78" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="180.17" cy="181.23" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="181.18" cy="180.68" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="182.19" cy="180.13" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="183.2" cy="179.59" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="184.21" cy="179.04" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="185.22" cy="178.49" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="186.24" cy="177.94" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="187.25" cy="177.39" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="188.26" cy="176.84" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="189.27" cy="176.3" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="190.28" cy="175.75" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="191.29" cy="175.2" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="192.31" cy="174.65" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="193.32" cy="174.1" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="194.33" cy="173.56" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="195.34" cy="173.01" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="196.35" cy="172.46" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="197.36" cy="171.91" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="198.37" cy="171.36" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="199.39" cy="170.81" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="200.4" cy="170.27" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="201.41" cy="169.72" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="202.42" cy="169.17" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="203.43" cy="168.62" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="204.44" cy="168.07" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="205.45" cy="167.53" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="206.47" cy="166.98" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="207.48" cy="166.43" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="208.49" cy="165.88" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="209.5" cy="165.33" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="210.51" cy="164.78" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="211.52" cy="164.24" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="212.54" cy="163.69" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="213.55" cy="163.14" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="214.56" cy="162.59" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="215.57" cy="162.04" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="216.58" cy="161.5" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="217.59" cy="160.95" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="218.6" cy="160.4" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="219.62" cy="159.85" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="220.63" cy="159.3" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="221.64" cy="158.75" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="222.65" cy="158.21" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="223.66" cy="157.66" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="224.67" cy="157.11" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="225.69" cy="156.56" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="226.7" cy="156.01" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="227.71" cy="155.47" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="228.72" cy="154.92" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="229.73" cy="154.37" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="230.74" cy="153.82" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="231.75" cy="153.27" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="232.77" cy="152.72" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="233.78" cy="152.18" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="234.79" cy="151.63" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="235.8" cy="151.08" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="236.81" cy="150.53" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="237.82" cy="149.98" rx="23.48" ry="43.77"></ellipse>
    <ellipse class="cls-2" cx="238.83" cy="149.44" rx="23.48" ry="43.77"></ellipse>
  </g>
  <path class="cls-1" d="M136.67,38A130.92,130.92,0,0,0,133,58c-1,.36-1.94.72-2.89,1.11a127.09,127.09,0,0,1,2.64-18.3,114.81,114.81,0,0,0-13.91,5.37A101.4,101.4,0,0,0,99.45,57.89a83.61,83.61,0,0,0-15.84,16l-2.55-1.88A86.3,86.3,0,0,1,97.51,55.39a104.17,104.17,0,0,1,20-12.1,120.21,120.21,0,0,1,14.3-5.51,140.23,140.23,0,0,0-15.13-11.94c1.31-.54,2.62-1,3.94-1.52A140.58,140.58,0,0,1,136.67,38Z" transform="translate(-13.88 -17.51)"></path>
  <path class="cls-1" d="M327,80.33a157.25,157.25,0,0,0-19.86,4.58q-1.09-1.16-2.22-2.28a154.44,154.44,0,0,1,17.92-4.75,134.88,134.88,0,0,0-10.42-10.7,124.43,124.43,0,0,0-25.09-18,106.81,106.81,0,0,0-28.88-10.66l.65-3.1a109.74,109.74,0,0,1,29.73,11,127.3,127.3,0,0,1,25.73,18.44,139.53,139.53,0,0,1,10.67,11,164.29,164.29,0,0,0,5-18.53c1,1,1.94,2,2.88,3A164.2,164.2,0,0,1,327,80.33Z" transform="translate(-13.88 -17.51)"></path>
  <path class="cls-1" d="M363.84,243.8a195.47,195.47,0,0,0-14.94-14c.24-1.06.46-2.14.68-3.21q7.19,5.76,13.93,12.35c1.25-4.84,2.3-9.73,3.12-14.65a145.78,145.78,0,0,0,1.87-32.51,109,109,0,0,0-6.5-31.73l3-1.11a111.82,111.82,0,0,1,6.69,32.65,148.91,148.91,0,0,1-1.9,33.22q-1.26,7.53-3.18,14.93,9.1-2.57,18.17-6.05c-.27,1.32-.55,2.64-.85,4A203.84,203.84,0,0,1,363.84,243.8Z" transform="translate(-13.88 -17.51)"></path>
  <path class="cls-1" d="M236.33,367.67a194,194,0,0,0,6.35-19.44c1.07-.23,2.14-.48,3.2-.73q-2.19,8.94-5.32,17.83c4.91-.9,9.79-2,14.6-3.35a145.86,145.86,0,0,0,31-12.41,111.08,111.08,0,0,0,26.57-19.92l2.28,2.21a114.67,114.67,0,0,1-27.33,20.5A149.27,149.27,0,0,1,256,365q-7.37,2.06-14.87,3.42,6.15,7.19,13.14,13.92c-1.31.32-2.63.62-3.94.91A206.21,206.21,0,0,1,236.33,367.67Z" transform="translate(-13.88 -17.51)"></path>
  <path class="cls-1" d="M80.92,319.67A164,164,0,0,0,101,316.31c.68.82,1.39,1.62,2.09,2.43a158.35,158.35,0,0,1-18.2,3.62,144.07,144.07,0,0,0,9.74,11.34,132,132,0,0,0,26,21.15,114.7,114.7,0,0,0,30.71,13.28l-.81,3.07A117.83,117.83,0,0,1,119,357.55a135.21,135.21,0,0,1-26.66-21.66,144.5,144.5,0,0,1-10-11.59,168.88,168.88,0,0,0-6.19,18.18c-.9-1-1.81-2.07-2.68-3.13A172.7,172.7,0,0,1,80.92,319.67Z" transform="translate(-13.88 -17.51)"></path>
  <path class="cls-1" d="M41.67,160.33q7.14,7.51,14.79,14.14c-.24,1.07-.5,2.14-.72,3.21Q48.63,171.82,42,165.16c-1.31,4.82-2.41,9.7-3.3,14.61A142.67,142.67,0,0,0,36.28,206a93.57,93.57,0,0,0,3.57,25.88l-3,.91A97.29,97.29,0,0,1,33.1,206a145.88,145.88,0,0,1,2.44-26.81c.9-5,2-10,3.35-14.88-6.08,1.65-12.17,3.57-18.22,5.82.27-1.32.58-2.63.88-3.94Q31.58,162.75,41.67,160.33Z" transform="translate(-13.88 -17.51)"></path>
</svg>

                    </div>
                    <hr>
                    <p class="text-center">Quick change of formats, and wide range of different formats and individual development for the client's product</p>
                    </div>
                </div>    
                <div class="clearfix"></div>
                <div class="col-md-3 text-center">
                <div class="why">
                        <div class="why-icon">
                    <svg width="72pt" height="72pt" id="Слой_1" data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 344.46 374.87">
  <defs>
    <style>
      .cls-1, .cls-2 {
        fill: #2e3192;
      }

      .cls-2 {
        stroke: #00aeef;
        stroke-miterlimit: 10;
      }
    </style>
  </defs>
  <ellipse class="cls-1" cx="113.04" cy="249.52" rx="5.91" ry="6.36" transform="translate(-95.23 13.57) rotate(-11.75)"/>
  <ellipse class="cls-1" cx="139.07" cy="255.9" rx="5.91" ry="6.36" transform="translate(-95.99 19) rotate(-11.75)"/>
  <ellipse class="cls-1" cx="164.39" cy="256.21" rx="5.91" ry="6.36" transform="translate(-95.52 24.16) rotate(-11.75)"/>
  <ellipse class="cls-1" cx="209.91" cy="240.71" rx="5.91" ry="6.36" transform="translate(-91.41 33.1) rotate(-11.75)"/>
  <ellipse class="cls-1" cx="188.48" cy="249.72" rx="5.91" ry="6.36" transform="translate(-93.69 28.93) rotate(-11.75)"/>
  <ellipse class="cls-1" cx="115.07" cy="283.83" rx="7.02" ry="7.56" transform="translate(-113.18 22.43) rotate(-14.26)"/>
  <ellipse class="cls-1" cx="146.3" cy="290.05" rx="7.02" ry="7.56" transform="translate(-113.75 30.31) rotate(-14.26)"/>
  <ellipse class="cls-1" cx="176.39" cy="289.1" rx="7.02" ry="7.56" transform="translate(-112.59 37.69) rotate(-14.26)"/>
  <ellipse class="cls-1" cx="229.64" cy="268.31" rx="7.02" ry="7.56" transform="translate(-105.82 50.17) rotate(-14.26)"/>
  <ellipse class="cls-1" cx="204.65" cy="280.13" rx="7.02" ry="7.56" transform="translate(-109.5 44.38) rotate(-14.26)"/>
  <ellipse class="cls-1" cx="119" cy="329.34" rx="8.09" ry="8.71" transform="translate(-139.44 35.68) rotate(-17.32)"/>
  <ellipse class="cls-1" cx="155.31" cy="334.57" rx="8.09" ry="8.71" transform="translate(-139.35 46.73) rotate(-17.32)"/>
  <ellipse class="cls-1" cx="189.84" cy="331.63" rx="8.09" ry="8.71" transform="translate(-136.91 56.87) rotate(-17.32)"/>
  <ellipse class="cls-1" cx="249.8" cy="304.46" rx="8.09" ry="8.71" transform="translate(-126.11 73.49) rotate(-17.32)"/>
  <ellipse class="cls-1" cx="221.8" cy="319.58" rx="8.09" ry="8.71" transform="matrix(0.95, -0.3, 0.3, 0.95, -131.88, 65.84)"/>
  <ellipse class="cls-1" cx="118.42" cy="372.51" rx="9.92" ry="10.68" transform="translate(-152.32 37.47) rotate(-17.32)"/>
  <ellipse class="cls-1" cx="162.93" cy="378.92" rx="9.92" ry="10.68" transform="translate(-152.21 51.01) rotate(-17.32)"/>
  <ellipse class="cls-1" cx="205.27" cy="375.31" rx="9.92" ry="10.68" transform="translate(-149.22 63.45) rotate(-17.32)"/>
  <ellipse class="cls-1" cx="278.78" cy="342" rx="9.92" ry="10.68" transform="translate(-135.97 83.82) rotate(-17.32)"/>
  <ellipse class="cls-1" cx="244.45" cy="360.54" rx="9.92" ry="10.68" transform="matrix(0.95, -0.3, 0.3, 0.95, -143.04, 74.44)"/>
  <g>
    <ellipse class="cls-2" cx="87.32" cy="169.79" rx="83.3" ry="72.76"/>
    <ellipse class="cls-2" cx="84.15" cy="164.47" rx="80.26" ry="70.02"/>
    <ellipse class="cls-2" cx="79.22" cy="154.02" rx="77.22" ry="67.28"/>
    <ellipse class="cls-2" cx="74.68" cy="139.52" rx="74.18" ry="64.54"/>
    <ellipse class="cls-2" cx="72.65" cy="122.02" rx="71.14" ry="61.8"/>
    <ellipse class="cls-2" cx="75.27" cy="102.59" rx="68.1" ry="59.06"/>
    <ellipse class="cls-2" cx="83.17" cy="84.69" rx="65.06" ry="56.32"/>
    <ellipse class="cls-2" cx="93.77" cy="71.43" rx="62.02" ry="53.58"/>
    <ellipse class="cls-2" cx="106.1" cy="61.35" rx="58.98" ry="50.84"/>
    <ellipse class="cls-2" cx="118.94" cy="53.92" rx="55.94" ry="48.1"/>
    <ellipse class="cls-2" cx="131.07" cy="48.65" rx="52.9" ry="45.36"/>
    <ellipse class="cls-2" cx="141.25" cy="45.03" rx="49.86" ry="42.62"/>
    <ellipse class="cls-2" cx="158.51" cy="40.38" rx="46.82" ry="39.88"/>
    <ellipse class="cls-2" cx="175.71" cy="38.09" rx="43.78" ry="37.14"/>
    <ellipse class="cls-2" cx="191.76" cy="37.87" rx="40.74" ry="34.4"/>
    <ellipse class="cls-2" cx="206.42" cy="39.13" rx="37.7" ry="31.66"/>
    <ellipse class="cls-2" cx="219.41" cy="41.3" rx="34.66" ry="28.92"/>
    <ellipse class="cls-2" cx="230.47" cy="43.79" rx="31.62" ry="26.18"/>
    <ellipse class="cls-2" cx="243.76" cy="47.33" rx="28.58" ry="23.44"/>
    <ellipse class="cls-2" cx="261.68" cy="53.58" rx="25.54" ry="20.7"/>
    <ellipse class="cls-2" cx="277.87" cy="60.94" rx="22.5" ry="17.96"/>
    <ellipse class="cls-2" cx="292.36" cy="69.05" rx="19.46" ry="15.22"/>
    <ellipse class="cls-2" cx="305.15" cy="77.55" rx="16.42" ry="12.48"/>
    <ellipse class="cls-2" cx="316.27" cy="86.1" rx="13.38" ry="9.74"/>
    <ellipse class="cls-2" cx="325.73" cy="94.34" rx="10.34" ry="7"/>
    <ellipse class="cls-2" cx="333.53" cy="101.92" rx="7.3" ry="4.26"/>
    <ellipse class="cls-2" cx="339.7" cy="108.49" rx="4.26" ry="1.52"/>
  </g>
</svg>
</div>
                    <hr>
                    <p class="text-center">A wide range of masses for forming</p>
                    </div>
                </div>    
                <div class="clearfix"></div>
                <div class="col-md-3 text-center">
                <div class="why">
                        <div class="why-icon">
<svg width="72pt" height="72pt" id="Слой_1" data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 346.76 380.33">
  <defs>
    <style>
      .cls-1, .cls-5, .cls-6 {
        fill: none;
      }

      .cls-1, .cls-2, .cls-4, .cls-5, .cls-6 {
        stroke: #2e3192;
        stroke-miterlimit: 10;
      }

      .cls-1, .cls-2 {
        stroke-width: 3px;
      }

      .cls-2, .cls-3 {
        fill: #2e3192;
      }

      .cls-4 {
        fill: #fff;
      }

      .cls-6 {
        stroke-width: 0.5px;
      }
    </style>
  </defs>
  <g>
    <rect class="cls-1" x="1.5" y="119.29" width="343.48" height="219.84"></rect>
    <path class="gr" d="M56.26,374.23A16.05,16.05,0,0,1,47,377a15.84,15.84,0,0,1-10.14-3.63,21.39,21.39,0,0,0,4.41-7.09c2.58-7.31-1.19-13.4-4.41-17.11H56.26c-1.17,1.31-7.33,8.38-4.85,17.11A18.55,18.55,0,0,0,56.26,374.23Z" transform="translate(-30.6 -9.35)"></path>
    <path class="gr" d="M201.14,128.56l-5.39-.09c-.16-5.44-.09-9.84,0-12.88.12-4.13.9-8.61-1.94-10-1-.51-1.47-.23-2.48-.78-2.63-1.42-2.17-5-2-10.2.34-7.67-.12-12.44,0-12.44s.2,6,.22,6-.13-6-.2-12.39c-.07-5.86-.12-10.26,0-15.78.17-9.13.57-11,.65-20.91,0-1.59,0-2,0-7.44,0-8,0-14.54,0-18.83a23.6,23.6,0,0,1,19,0c-.19,4.65-.44,11.38-.65,19.53-.25,9.83-.34,17.61-.43,25.4-.17,15.22-.26,22.84-.22,23.33.41,4.83-.51,9.69-.21,14.52.17,2.78.62,8.07-2.59,9.51-1,.44-1.65.22-2.59.86-1.69,1.15-1.59,3.22-1.51,6.14.07,2.5,0,5,.11,7.52C201,121.73,201.12,124.79,201.14,128.56Z" transform="translate(-30.6 -9.35)"></path>
    <path class="gr" d="M370.84,373.54a16.28,16.28,0,0,1-9.28,2.77,15.87,15.87,0,0,1-10.14-3.63,21.23,21.23,0,0,0,4.41-7.09c2.58-7.31-1.18-13.4-4.41-17.11h19.42c-1.18,1.31-7.34,8.38-4.86,17.11A18.46,18.46,0,0,0,370.84,373.54Z" transform="translate(-30.6 -9.35)"></path>
    <path class="cls-1" d="M375.22,336.91H187.49L218,272.15H351.8Q363.52,304.52,375.22,336.91Z" transform="translate(-30.6 -9.35)"></path>
    <rect class="gr" x="186.53" y="147.66" width="134.74" height="114.41"></rect>
  </g>
  <g>
    <ellipse class="gr" cx="99.32" cy="228.87" rx="23.42" ry="17.89"></ellipse>
    <rect class="gr" x="79.33" y="252" width="45.7" height="77.67" rx="18.56" ry="18.56"></rect>
    <rect class="cls-3" x="77.95" y="313.54" width="20.57" height="66.79"></rect>
    <rect class="cls-3" x="105.86" y="313.47" width="20.57" height="66.79"></rect>
    <polygon class="cls-3" points="165.46 262.73 180.55 290.89 170.64 293.99 155.55 265.82 165.46 262.73"></polygon>
    <path class="cls-3" d="M192.31,268.54c2.62-3.5-3.58-8.93-2.72-9.41s10.74,4.25,9.7,10.76a9.25,9.25,0,0,1-6.71,6.93c-5.56,1.69-11.65-1.08-14.51-4.19-5.29-5.75-.27-13.51.66-13.46.69,0-.46,4.38,3.31,8.33.84.89,3,3.2,6,3.07A5.84,5.84,0,0,0,192.31,268.54Z" transform="translate(-30.6 -9.35)"></path>
    <path class="cls-3" d="M143.94,272.57l17,28.53a3.71,3.71,0,0,0,4.34,1.17l3.83-1.39c1.64-.6,2.39-2.1,1.65-3.35l-17-28.53a3.71,3.71,0,0,0-4.34-1.17l-3.83,1.39C144,269.82,143.2,271.33,143.94,272.57Z" transform="translate(-30.6 -9.35)"></path>
    <path class="cls-3" d="M197.27,282.63,160.86,294.9c-1.64.55-2.39,2-1.66,3.28l1.71,3a3.73,3.73,0,0,0,4.3,1.28l36.41-12.27c1.64-.55,2.39-2,1.66-3.28l-1.71-3A3.73,3.73,0,0,0,197.27,282.63Z" transform="translate(-30.6 -9.35)"></path>
    <path class="cls-3" d="M120.94,274.16l-17.11,28.52a3.73,3.73,0,0,1-4.35,1.17l-3.82-1.39c-1.65-.6-2.38-2.11-1.63-3.35l17.11-28.52a3.71,3.71,0,0,1,4.34-1.17l3.82,1.39C121,271.41,121.68,272.92,120.94,274.16Z" transform="translate(-30.6 -9.35)"></path>
    <path class="cls-3" d="M68.68,282.77,103.83,297c1.58.64,2.19,2.16,1.35,3.36l-2,2.87a3.81,3.81,0,0,1-4.41,1L63.63,290c-1.58-.64-2.19-2.16-1.35-3.37l2-2.86A3.84,3.84,0,0,1,68.68,282.77Z" transform="translate(-30.6 -9.35)"></path>
  </g>
  <path class="cls-3" d="M55.86,287.1l-7,7.41c-1.19,1.25-.54,3.17,1.43,4.26s4.56,1,5.74-.29l7-7.42-3.87-2.14Z" transform="translate(-30.6 -9.35)"></path>
  <polygon class="cls-3" points="41.38 268.9 29.59 281.35 26.74 279.77 38.52 267.32 41.38 268.9"></polygon>
  <path class="cls-3" d="M75.61,274.53l-3.72,5.05-4.46-2.46,5.27-4.22Z" transform="translate(-30.6 -9.35)"></path>
  <g>
    <path class="cls-4" d="M141.91,198.06c-1.59,1.56-4.74.52-12.66.53-7.06,0-9.75.84-11.6-.67-1.61-1.31-1.3-3.32-1.22-4.13.82-8.87-13.52-15-15.36-23.06-2.12-9.3,11.6-24.53,28.8-24.13,16.2.38,28.81,14.49,26.87,23.6-1.82,8.57-17.08,15.24-14.66,23.72C142.38,195,143.17,196.81,141.91,198.06Z" transform="translate(-30.6 -9.35)"></path>
    <path class="cls-4" d="M141.84,198.67c1,.79.28,1.59-2.31,6.83s-2.61,5.84-4.27,6.61a16.6,16.6,0,0,1-12.09,0c-1.87-.87-1.7-1.64-4.27-6.72s-3.52-5.86-2.49-6.72c1.28-1.06,3.74-.53,12.8-.53S140.54,197.62,141.84,198.67Z" transform="translate(-30.6 -9.35)"></path>
    <line class="cls-5" x1="89.37" y1="192.48" x2="106.79" y2="195.5"></line>
    <line class="cls-5" x1="93.17" y1="197.96" x2="106.59" y2="195.5"></line>
    <line class="cls-5" x1="103.42" y1="200.94" x2="92.93" y2="197.96"></line>
    <path class="cls-6" d="M125.36,213.05c0,1.24,1.83,2.21,3.86,2.15s3.46-1,3.47-2.15" transform="translate(-30.6 -9.35)"></path>
    <path class="cls-6" d="M112.94,160.06a19.65,19.65,0,0,1,11-7.06,26.48,26.48,0,0,1,15,.53" transform="translate(-30.6 -9.35)"></path>
    <line class="cls-6" x1="98.66" y1="186.03" x2="98.66" y2="173.37"></line>
    <line class="cls-6" x1="98.57" y1="170.3" x2="98.66" y2="161.91"></line>
    <line class="cls-6" x1="104.89" y1="158.77" x2="98.52" y2="162.1"></line>
    <line class="cls-6" x1="90.63" y1="157.21" x2="95.73" y2="160.51"></line>
    <line class="cls-6" x1="63.49" y1="136.05" x2="70.82" y2="142.44"></line>
    <line class="cls-6" x1="73.61" y1="129.65" x2="78.85" y2="136.31"></line>
    <line class="cls-6" x1="85.05" y1="125.87" x2="88.88" y2="133.03"></line>
    <line class="cls-6" x1="98.66" y1="124.31" x2="98.66" y2="133.11"></line>
    <line class="cls-6" x1="133.03" y1="135.71" x2="125.7" y2="142.11"></line>
    <line class="cls-6" x1="122.91" y1="129.31" x2="117.67" y2="135.98"></line>
    <line class="cls-6" x1="111.47" y1="125.54" x2="107.64" y2="132.69"></line>
  </g>
</svg>
                    </div>
                    <hr>
                    <p class="text-center">Easy service, the ability to integrate into an existing line</p>
                    </div>
                </div>    
                <div class="clearfix"></div>
            </div>
            <div class="row">
                <div class="col-md-3 text-center">
                <div class="why">
                        <div class="why-icon">
                    <svg width="72pt" height="72pt" id="Слой_1" data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 366.82 378.88">
  <defs>
    <style>

      .cls-1, .gr, .gr2 {
        stroke: #2e3192;
        stroke-miterlimit: 10;
        stroke-width: 3px;
      }

      .gr, .gr2 {
        fill: #2e3192;
      }

      .gr2 {
        font-size: 72px;
        font-family: MyriadPro-Regular, Myriad Pro;
      }
    </style>
  </defs>
  <g>
    <rect class="cls-1" x="1.5" y="122.42" width="363.54" height="225.68"/>
    <path class="gr" fill="#2e3192" d="M45,386.07a17.5,17.5,0,0,1-9.82,2.84,17.14,17.14,0,0,1-10.74-3.72,21.81,21.81,0,0,0,4.67-7.28c2.73-7.5-1.25-13.76-4.67-17.56H45c-1.25,1.33-7.77,8.6-5.14,17.56A18.94,18.94,0,0,0,45,386.07Z" transform="translate(-17.96 -11.54)"/>
    <path class="gr" d="M198.38,133.86l-5.71-.08c-.17-5.59-.1-10.11,0-13.22.13-4.25,1-8.85-2.06-10.29-1.1-.53-1.56-.24-2.62-.8-2.79-1.46-2.3-5.16-2.06-10.47.35-7.87-.13-12.77,0-12.77s.2,6.21.23,6.21S186,86.27,186,79.72c-.07-6-.13-10.54,0-16.2.18-9.37.6-11.3.69-21.47,0-1.63,0-2,0-7.63,0-8.27,0-14.93,0-19.34a25.7,25.7,0,0,1,20.09,0c-.2,4.77-.46,11.69-.68,20.05-.27,10.09-.37,18.08-.46,26.08-.18,15.63-.27,23.44-.23,23.95.43,5-.54,9.94-.23,14.91.18,2.85.66,8.28-2.74,9.75-1,.45-1.74.23-2.74.89-1.79,1.18-1.68,3.3-1.6,6.3.07,2.57,0,5.15.12,7.72C198.24,126.86,198.35,130,198.38,133.86Z" transform="translate(-17.96 -11.54)"/>
    <path class="gr" d="M378,385.36a17.5,17.5,0,0,1-9.82,2.84,17.14,17.14,0,0,1-10.74-3.72,22,22,0,0,0,4.68-7.28c2.72-7.5-1.26-13.76-4.68-17.56H378c-1.25,1.33-7.77,8.6-5.14,17.56A18.94,18.94,0,0,0,378,385.36Z" transform="translate(-17.96 -11.54)"/>
    <path class="cls-1" d="M382.62,347.75H183.92l32.32-66.48H357.83Z" transform="translate(-17.96 -11.54)"/>
    <rect class="gr" x="197.33" y="151.55" width="142.61" height="117.45"/>
  </g>
  <text class="gr2" transform="translate(15.72 244.58)">RENT</text>
</svg>
                    </div>
                    <hr>
                    <p class="text-center">The ability to provide equipment for lease (for testing at the customer's enterprise)</p>
                    </div>
                </div>    
                <div class="clearfix"></div>
                <div class="col-md-3 text-center">
                <div class="why">
                        <div class="why-icon">
<svg width="72pt" height="72pt" id="Слой_1" data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 370.75 389.06">
  <defs>
    <style>
      .cls-1 {
        fill: none;
      }

      .cls-1, .cls-2 {
        stroke: #2e3192;
        stroke-miterlimit: 10;
        stroke-width: 3px;
      }

      .cls-2, .cls-3 {
        fill: #2e3192;
      }
    </style>
  </defs>
  <rect class="cls-1" x="205.94" y="64.76" width="147.77" height="118.07"></rect>
  <path class="cls-2" d="M231.18,201.76a6.1,6.1,0,0,1-4,1.49,6.17,6.17,0,0,1-4.36-1.95,12.35,12.35,0,0,0,1.89-3.81,10.76,10.76,0,0,0-1.89-9.19h8.35a11.77,11.77,0,0,0-2.09,9.19A10.57,10.57,0,0,0,231.18,201.76Z" transform="translate(-14.85 -5.11)"></path>
  <path class="gr" d="M293.51,69.82l-2.32,0c-.07-2.92,0-5.28,0-6.91.05-2.22.39-4.63-.84-5.38-.44-.28-.63-.13-1.07-.42-1.13-.77-.93-2.7-.83-5.48.14-4.12-.06-6.68,0-6.68s.08,3.25.09,3.25-.05-3.23-.08-6.65c0-3.15,0-5.52,0-8.48.07-4.9.24-5.91.28-11.23v-4c0-4.33,0-7.81,0-10.12a8.37,8.37,0,0,1,3.9-1.07,8.5,8.5,0,0,1,4.27,1.07c-.09,2.5-.19,6.11-.28,10.49-.11,5.28-.15,9.45-.19,13.64-.07,8.18-.11,12.26-.09,12.53.17,2.6-.22,5.2-.09,7.8.07,1.49.26,4.33-1.12,5.1-.42.24-.71.12-1.11.47-.73.62-.69,1.73-.65,3.29,0,1.35,0,2.7,0,4C293.45,66.16,293.5,67.8,293.51,69.82Z" transform="translate(-14.85 -5.11)"></path>
  <path class="cls-2" d="M366.51,201.39a6.1,6.1,0,0,1-4,1.49,6.21,6.21,0,0,1-4.36-1.95,12.35,12.35,0,0,0,1.89-3.81,10.78,10.78,0,0,0-1.89-9.19h8.35a11.77,11.77,0,0,0-2.09,9.19A10.57,10.57,0,0,0,366.51,201.39Z" transform="translate(-14.85 -5.11)"></path>
  <path class="cls-1" d="M368.4,181.72H287.63l13.14-34.78h57.55Z" transform="translate(-14.85 -5.11)"></path>
  <rect class="gr" x="285.54" y="80" width="57.97" height="61.44"></rect>
  <circle class="gr" cx="132.85" cy="67.47" r="17.89"></circle>
  <rect class="gr" x="117.57" y="90.6" width="34.91" height="77.67" rx="16.22" ry="16.22"></rect>
  <rect class="cls-3" x="115.64" y="153.43" width="15.71" height="66.79"></rect>
  <rect class="cls-3" x="138.63" y="153.43" width="15.71" height="66.79"></rect>
  <rect class="cls-3" x="100.57" y="124.83" width="52.36" height="8.22" rx="2.95" ry="2.95" transform="translate(-55.81 191.38) rotate(-67.43)"></rect>
  <rect class="cls-3" x="98.43" y="146.81" width="30.43" height="8.18" transform="translate(127.43 332.52) rotate(-151.74)"></rect>
  <path class="cls-3" d="M97.71,139.18c-.68-4-7.78-5.15-7.58-5.94s9-1.93,12.56,3.6a8.67,8.67,0,0,1,.45,8.6c-2.2,4-7.56,4.83-11.22,3.82-6.77-1.87-8.75-10.3-8.17-10.71s2.52,3.6,7.25,4.82c1.06.28,3.82,1,5.51-.57A4.14,4.14,0,0,0,97.71,139.18Z" transform="translate(-14.85 -5.11)"></path>
  <rect class="cls-3" x="150.27" y="115.02" width="36.65" height="8.22" rx="2.51" ry="2.51" transform="translate(108.46 315.43) rotate(-112.57)"></rect>
  <rect class="cls-3" x="169" y="122.23" width="35.37" height="8.22" rx="2.49" ry="2.49" transform="translate(-50.77 85.76) rotate(-25.03)"></rect>
  <circle class="gr" cx="35.18" cy="244.74" r="16.84"></circle>
  <rect class="gr" x="20.8" y="266.51" width="32.87" height="73.13" rx="15.28" ry="15.28"></rect>
  <rect class="cls-3" x="19.35" y="325.61" width="14.79" height="62.89"></rect>
  <rect class="cls-3" x="40.38" y="325.61" width="14.79" height="62.89"></rect>
  <rect class="cls-3" x="0.01" y="302.5" width="56.8" height="7.74" rx="2.99" ry="2.99" transform="matrix(0.38, -0.92, 0.92, 0.38, -280.25, 209.89)"></rect>
  <rect class="cls-3" x="46.53" y="302.19" width="56.8" height="7.74" rx="2.99" ry="2.99" transform="translate(-198.18 481.48) rotate(-111.2)"></rect>
  <circle class="gr" cx="132.02" cy="244.9" r="16.84"></circle>
  <rect class="gr" x="117.64" y="266.68" width="32.87" height="73.13" rx="15.28" ry="15.28"></rect>
  <rect class="cls-3" x="116.15" y="325.84" width="14.79" height="62.89"></rect>
  <rect class="cls-3" x="137.13" y="325.84" width="14.79" height="62.89"></rect>
  <rect class="cls-3" x="96.84" y="302.67" width="56.8" height="7.74" rx="2.99" ry="2.99" transform="matrix(0.38, -0.92, 0.92, 0.38, -220.74, 299.41)"></rect>
  <rect class="cls-3" x="143.37" y="302.36" width="56.8" height="7.74" rx="2.99" ry="2.99" transform="translate(-66.5 571.99) rotate(-111.2)"></rect>
  <circle class="gr" cx="235.35" cy="244.4" r="16.84"></circle>
  <rect class="gr" x="220.97" y="266.18" width="32.87" height="73.13" rx="15.28" ry="15.28"></rect>
  <rect class="cls-3" x="219.48" y="325.34" width="14.79" height="62.89"></rect>
  <rect class="cls-3" x="240.54" y="325.26" width="14.79" height="62.89"></rect>
  <rect class="cls-3" x="200.17" y="302.17" width="56.8" height="7.74" rx="2.99" ry="2.99" transform="matrix(0.38, -0.92, 0.92, 0.38, -156.61, 394.52)"></rect>
  <rect class="cls-3" x="246.7" y="301.86" width="56.8" height="7.74" rx="2.99" ry="2.99" transform="translate(74.66 667.65) rotate(-111.2)"></rect>
  <circle class="gr" cx="332.85" cy="245.24" r="16.84"></circle>
  <rect class="gr" x="318.47" y="267.01" width="32.87" height="73.13" rx="15.28" ry="15.28"></rect>
  <rect class="cls-3" x="317.02" y="326.05" width="14.79" height="62.89"></rect>
  <rect class="cls-3" x="337.92" y="326.17" width="14.79" height="62.89"></rect>
  <rect class="cls-3" x="297.67" y="303" width="56.8" height="7.74" rx="2.99" ry="2.99" transform="translate(-97.31 485.06) rotate(-67.43)"></rect>
  <rect class="cls-3" x="344.2" y="302.7" width="56.8" height="7.74" rx="2.99" ry="2.99" transform="translate(206.64 759.69) rotate(-111.2)"></rect>
</svg>

                    </div>
                    <hr>
                    <p class="text-center">Staff training and equipment starting are included</p>
                    </div>
                </div>    
                <div class="clearfix"></div>
                <div class="col-md-3 col-xs-6 text-center">
                <div class="why">
                        <div class="why-icon">
                    <svg width="72pt" height="72pt" id="Слой_1" data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 392.69 376.94">
  <defs>
    <style>
      .cls-1, .cls-3 {
        fill: #2e3192;
      }

      .cls-1, .cls-2, .cls-4 {
        stroke: #2e3192;
        stroke-miterlimit: 10;
      }

      .cls-2 {
        fill: #fff;
      }

      .cls-4 {
        fill: none;
      }
    </style>
  </defs>
  <g>
    <path class="gr" d="M32.24,177.72c6.65-6.27,24.43,11,36.84,3.1,2.64-1.67,4.11-4.45,7.07-10,7.45-14,6.93-23.6,12.17-47.45,1.14-5.14,2.12-9.09,3.31-13.65.35-1.34.71-2.72,1.11-4.21C94.3,99.57,96,93.12,98.12,86.1c1.73-5.73,3.71-11.84,6.11-18.38,4.9-13.35,8.16-22.09,15-32.8,11.18-17.65,19.14-20.47,21.32-21.15a27.84,27.84,0,0,1,17.91.6A27.26,27.26,0,0,1,171.15,25.1c1.52,2.36,6,10.38,3,28.63-2.53,15.31-8.43,26.18-13.83,35.91-3.64,6.54-6.83,12.28-9.69,17.39-4.92,8.79-8.86,15.72-12.39,21.67-2.76,4.66-5.28,8.71-7.83,12.59-8,12.15-23.61,34.89-21.41,52.48a14.11,14.11,0,0,0,.59,3.12c4.72,13.69,27.09,13.83,27,22.09-.07,6.18-12.66,11.52-24.38,15.29-4,.42-10.44.44-16.14-3.21-10.55-6.77-7.89-19.21-16.32-22.94-9.29-4.11-17.86,8.64-30,5.58-7.79-1.94-12.6-9.23-15.37-14.76C29,185.21,29.94,179.88,32.24,177.72Z" transform="translate(-8.33 -12.06)"/>
    <path class="gr" d="M155.45,140.49A174.85,174.85,0,0,0,138.2,128.7c3.53-5.95,7.47-12.88,12.39-21.67A258.43,258.43,0,0,1,204,145c6.93,7.51,6.9,18.53,1.36,24.63-3.84,4.23-10.06,5.81-16,4.48-3.43-4.08-8.14-9.43-14-15.42A249.92,249.92,0,0,0,155.45,140.49Z" transform="translate(-8.33 -12.06)"/>
    <path class="gr" d="M29,84.91C44.86,82,70.17,79.52,98.72,86.34c-2.25,7-4.14,13.34-5.87,19.22l-1.22,4.16c-29.62-4.69-59.49,5.57-66.17,8-6.88-.17-11.39-7.08-10.34-15.61C16.14,93.77,22.16,86.28,29,84.91Z" transform="translate(-8.33 -12.06)"/>
  </g>
  <g>
    <ellipse class="cls-1" cx="45.45" cy="352.61" rx="16.62" ry="18.4"/>
    <ellipse class="cls-1" cx="78.14" cy="352.61" rx="16.62" ry="18.4"/>
    <ellipse class="cls-1" cx="125.54" cy="352.45" rx="16.62" ry="18.4"/>
    <ellipse class="cls-1" cx="158.24" cy="352.45" rx="16.62" ry="18.4"/>
    <ellipse class="cls-2" cx="45.27" cy="352" rx="12.08" ry="13.38"/>
    <ellipse class="cls-2" cx="78.32" cy="352.4" rx="12.08" ry="13.38"/>
    <ellipse class="cls-2" cx="125.54" cy="352.81" rx="12.08" ry="13.38"/>
    <ellipse class="cls-2" cx="158.6" cy="352.4" rx="12.08" ry="13.38"/>
    <g>
      <rect class="gr" x="16.85" y="276.88" width="171.63" height="76.03" rx="10" ry="10"/>
      <rect class="gr" x="16.85" y="276.88" width="171.63" height="76.03" rx="10" ry="10"/>
    </g>
    <path class="cls-2" style="fill:white" d="M44.38,335l-18.86,6.64c-.08-4.4-.12-8-.14-10.41,0-3.2,0-5-.07-8.37s-.09-5.85-.13-7.54q0-7.47-.07-14.94a13.65,13.65,0,0,1,3.18-7.21,11.36,11.36,0,0,1,8.36-3.85H46.4c1.58,0,4,0,6.84,0,3.93-.08,4.46-.22,5.17.31,1.25.91,1.68,2.83,1.09,13.57a113.25,113.25,0,0,1-1.15,13.05c-1,5.94-1.48,8.95-3.34,11.39a23.69,23.69,0,0,1-6.13,5.21A26.17,26.17,0,0,1,44.38,335Z" transform="translate(-8.33 -12.06)"/>
    <rect class="cls-2" style="fill:white" x="61.8" y="283.82" width="30.37" height="27.46" rx="13.04" ry="13.04"/>
    <rect class="cls-2" style="fill:white" x="106.2" y="283.51" width="30.37" height="27.46" rx="13.04" ry="13.04"/>
    <rect class="cls-2" style="fill:white" x="150.33" y="283.21" width="30.37" height="27.46" rx="13.04" ry="13.04"/>
    <rect class="cls-1" style="fill:white" x="189.02" y="327.56" width="9.81" height="12.67"/>
    <ellipse class="cls-1" cx="228.52" cy="352" rx="16.62" ry="18.4"/>
    <ellipse class="cls-1" cx="261.21" cy="352" rx="16.62" ry="18.4"/>
    <ellipse class="cls-1" cx="308.61" cy="351.85" rx="16.62" ry="18.4"/>
    <ellipse class="cls-1" cx="341.31" cy="351.85" rx="16.62" ry="18.4"/>
    <ellipse class="cls-2" cx="228.34" cy="351.4" rx="12.08" ry="13.38"/>
    <ellipse class="cls-2" cx="261.39" cy="351.8" rx="12.08" ry="13.38"/>
    <ellipse class="cls-2" cx="308.61" cy="352.2" rx="12.08" ry="13.38"/>
    <ellipse class="cls-2" cx="341.67" cy="351.8" rx="12.08" ry="13.38"/>
    <g>
      <rect class="gr" x="199.92" y="276.27" width="171.63" height="76.03" rx="10" ry="10"/>
      <rect class="gr" x="199.92" y="276.27" width="171.63" height="76.03" rx="10" ry="10"/>
    </g>
    <rect class="cls-1" x="0.5" y="371.01" width="384.67" height="5.43"/>
  </g>
  <g>
    <path class="gr" d="M378,266l-165.8.33-43.82-69.51,232-1.51Z" transform="translate(-8.33 -12.06)"/>
    <path class="gr" d="M374.84,198.71H257.73q20-43.26,40-86.51h77.07Z" transform="translate(-8.33 -12.06)"/>
    <rect class="gr" x="316.64" y="50.27" width="27.2" height="57.42"/>
    <circle class="cls-2" style="fill:white" cx="317.96" cy="143.96" r="19.64"/>
  </g>
  <path class="cls-1" d="M499.67,253.67" transform="translate(-8.33 -12.06)"/>
</svg>


                    </div>
                    <hr>
                    <p class="text-center">Logistic support (air, railway, car, sea)</p>
                    </div>
                </div>    
                <div class="clearfix"></div>
                <div class="col-md-3 col-xs-6 text-center">
                    <div class="why">
                        <div class="why-icon">
                    <svg width="72pt" height="72pt" id="Слой_1" data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 391.35 401.89">
  <defs>
    <style>
      .cls-1, .cls-4, .cls-6 {
        fill: #fff;
      }

      .cls-2, .cls-5 {
        fill: none;
      }

      .cls-2, .cls-4, .cls-5, .cls-6 {
        stroke: #2e3192;
        stroke-miterlimit: 10;
      }

      .cls-2, .cls-6 {
        stroke-width: 3px;
      }

      .cls-3 {
        fill: #2e348e;
      }

      .cls-4 {
        stroke-width: 5px;
      }

      .cls-7 {
        font-size: 323.13px;
        fill: #2e3192;
        font-family: AAlbionicBold, a_Albionic;
        font-weight: 700;
      }
    </style>
  </defs>
  <g>
    <rect class="cls-1" x="1.5" y="43.31" width="283.79" height="333.71" rx="10" ry="10"/>
    <rect class="cls-2" x="1.5" y="43.31" width="283.79" height="333.71" rx="10" ry="10"/>
  </g>
  <g>
    <ellipse class="cls-1" cx="277.01" cy="245.8" rx="101.83" ry="104.77"/>
    <g>
      <path class="cls-3" d="M386.61,288.46c.66-2.1,1.2-4.23,1.79-6.35L373,278.28a98.92,98.92,0,0,0,2.8-18.68l15.8.87c.12-2.16.13-4.33.19-6.5h4l-.14,5.65c-.1,1.88-.26,3.76-.4,5.64l-15.76-1.47c-.19,1.94-.46,3.88-.7,5.82s-.62,3.85-1.05,5.76l15.5,3.23c-.43,1.85-.79,3.73-1.3,5.56s-1,3.68-1.56,5.49Z" transform="translate(-4.5 -8.17)"/>
      <path class="cls-3" d="M371.24,319.83l1.88-2.72,1.75-2.81L361.38,306a98.73,98.73,0,0,0,8.28-16.94l14.82,5.55c.82-2,1.43-4.11,2.13-6.17l3.83,1.19c-.61,1.8-1.15,3.61-1.81,5.38s-1.32,3.54-2.07,5.28L372,294.18c-.8,1.78-1.52,3.6-2.43,5.33l-1.3,2.62c-.46.86-1,1.71-1.42,2.56l13.8,7.75c-.47.83-.92,1.67-1.41,2.49l-1.51,2.43c-.51.8-1,1.62-1.53,2.41l-1.62,2.36Z" transform="translate(-4.5 -8.17)"/>
      <path class="cls-3" d="M347.05,345.08q2.63-2,5.16-4.16l-10.31-12a97.5,97.5,0,0,0,13-13.61l12.43,9.78c1.32-1.73,2.68-3.44,3.88-5.25l3.3,2.3c-1.06,1.57-2.21,3.07-3.36,4.57s-2.36,3-3.58,4.41l-12.05-10.26c-1.22,1.52-2.6,2.9-3.91,4.35s-2.76,2.75-4.16,4.11l10.77,11.59c-1.43,1.27-2.83,2.56-4.29,3.79s-2.95,2.43-4.48,3.58Z" transform="translate(-4.5 -8.17)"/>
      <path class="cls-3" d="M316.11,361.53l3.14-1.1c1-.39,2.05-.82,3.08-1.23l-6-14.65a93.15,93.15,0,0,0,16.58-8.83l8.81,13.15c1.85-1.17,3.56-2.52,5.33-3.79l2.43,3.19c-1.54,1.11-3,2.28-4.62,3.33s-3.14,2.13-4.78,3.1l-8.27-13.5c-1.69,1-3.34,2-5.08,2.9l-2.59,1.36-2.65,1.23,6.6,14.39c-1.73.84-3.51,1.54-5.29,2.26s-3.59,1.35-5.4,2Z" transform="translate(-4.5 -8.17)"/>
      <path class="cls-3" d="M281.5,367.24c2.21-.07,4.43-.06,6.63-.22l-1-15.8a91.44,91.44,0,0,0,18.52-3l4.15,15.26c2.09-.63,4.22-1.16,6.27-1.92l1.29,3.8c-1.79.66-3.63,1.15-5.46,1.69s-3.68,1-5.53,1.42L302.89,353c-1.89.5-3.82.76-5.73,1.14s-3.86.53-5.79.78L293,370.67l-5.73.44-5.75.15Z" transform="translate(-4.5 -8.17)"/>
      <path class="cls-3" d="M246.9,361.53c2.07.77,4.23,1.3,6.34,2l4.15-15.28a91.32,91.32,0,0,0,18.52,3L275,367c2.18.15,4.36.14,6.54.21v4l-5.7-.15-5.69-.44,1.6-15.74c-1.93-.24-3.87-.47-5.79-.78l-2.87-.53-1.44-.26-1.42-.34-3.51,15.44c-1.86-.46-3.74-.85-5.58-1.43s-3.69-1-5.49-1.7Z" transform="translate(-4.5 -8.17)"/>
      <path class="cls-3" d="M216,345.08c1.79,1.29,3.53,2.65,5.4,3.83l8.8-13.15a93.19,93.19,0,0,0,16.59,8.82l-6,14.65c1,.41,2,.84,3.05,1.22l3.1,1.08-1.29,3.8c-1.8-.63-3.61-1.22-5.36-2s-3.54-1.41-5.25-2.24l6.58-14.4-2.65-1.23-2.59-1.36c-1.74-.87-3.4-1.91-5.08-2.89L223,354.74c-1.65-1-3.21-2.08-4.82-3.12s-3.1-2.23-4.66-3.35Z" transform="translate(-4.5 -8.17)"/>
      <path class="cls-3" d="M191.76,319.83c1.22,1.84,2.6,3.56,3.93,5.32l12.43-9.8a97,97,0,0,0,13,13.6l-10.3,12c1.67,1.4,3.36,2.78,5.09,4.11l-2.43,3.19c-1.51-1.14-3-2.36-4.44-3.55s-2.85-2.51-4.27-3.76l10.77-11.6c-1.4-1.35-2.81-2.71-4.16-4.11s-2.7-2.83-3.92-4.35l-12,10.28c-1.23-1.46-2.47-2.91-3.61-4.44s-2.32-3-3.38-4.61Z" transform="translate(-4.5 -8.17)"/>
      <path class="cls-3" d="M176.4,288.46c.7,2.09,1.32,4.2,2.15,6.25l14.82-5.57a97.7,97.7,0,0,0,8.29,16.94l-13.48,8.29,1.73,2.77,1.85,2.69-3.29,2.3-1.61-2.34c-.54-.78-1-1.6-1.52-2.4l-1.5-2.41c-.49-.8-.93-1.64-1.4-2.46l13.79-7.77-1.42-2.55-1.3-2.63c-.91-1.72-1.63-3.54-2.44-5.32l-14.59,6.14c-.76-1.75-1.39-3.55-2.08-5.32s-1.22-3.61-1.83-5.42Z" transform="translate(-4.5 -8.17)"/>
      <path class="cls-3" d="M171.17,254c.07,2.19.07,4.39.2,6.58l15.8-.88A99.75,99.75,0,0,0,190,278.35l-15.36,3.83c.59,2.1,1.12,4.21,1.78,6.28l-3.83,1.19c-.59-1.79-1-3.63-1.55-5.45s-.86-3.68-1.3-5.52l15.5-3.24c-.44-1.9-.7-3.84-1.05-5.76s-.51-3.87-.71-5.82l-15.76,1.48c-.14-1.89-.3-3.78-.4-5.68l-.14-5.69Z" transform="translate(-4.5 -8.17)"/>
      <path class="cls-3" d="M176.4,219.47c-.67,2.1-1.2,4.24-1.79,6.36L190,229.65a99,99,0,0,0-2.8,18.68l-15.8-.87c-.13,2.17-.13,4.34-.2,6.51h-4l.14-5.65c.1-1.88.26-3.77.4-5.65l15.75,1.47c.19-1.94.46-3.87.7-5.81s.63-3.86,1-5.76l-15.49-3.24c.43-1.85.79-3.72,1.29-5.56s1-3.68,1.57-5.49Z" transform="translate(-4.5 -8.17)"/>
      <path class="cls-3" d="M191.76,188.11l-1.87,2.72-1.75,2.8,13.49,8.29a97.7,97.7,0,0,0-8.29,16.94l-14.81-5.55c-.83,2-1.43,4.1-2.13,6.16l-3.83-1.19c.6-1.79,1.14-3.6,1.81-5.37s1.32-3.55,2.07-5.28L191,213.75c.81-1.77,1.52-3.6,2.43-5.32l1.31-2.62c.45-.87.94-1.71,1.42-2.57l-13.8-7.75c.47-.83.92-1.67,1.41-2.48l1.51-2.43c.51-.81,1-1.63,1.53-2.42l1.62-2.35Z" transform="translate(-4.5 -8.17)"/>
      <path class="cls-3" d="M216,162.86c-1.75,1.34-3.46,2.74-5.15,4.16l10.31,12a96.41,96.41,0,0,0-13,13.61l-12.44-9.79c-1.31,1.74-2.67,3.44-3.88,5.26l-3.29-2.3c1.05-1.58,2.2-3.08,3.36-4.58s2.35-3,3.57-4.41l12,10.27c1.23-1.52,2.6-2.91,3.92-4.35s2.76-2.76,4.16-4.11L204.75,167c1.43-1.26,2.84-2.56,4.3-3.79s2.95-2.43,4.47-3.58Z" transform="translate(-4.5 -8.17)"/>
      <path class="cls-3" d="M246.9,146.41l-3.14,1.09c-1,.39-2,.82-3.08,1.23l6,14.65a93.5,93.5,0,0,0-16.58,8.83l-8.8-13.14c-1.85,1.16-3.57,2.52-5.34,3.79l-2.43-3.2c1.54-1.11,3-2.27,4.62-3.33s3.15-2.13,4.79-3.09l8.27,13.49c1.68-1,3.33-2,5.08-2.89l2.58-1.36,2.65-1.23-6.59-14.39c1.72-.84,3.51-1.55,5.29-2.27s3.59-1.35,5.4-2Z" transform="translate(-4.5 -8.17)"/>
      <path class="cls-3" d="M281.5,140.69c-2.21.07-4.42.07-6.63.22l1,15.8a91.34,91.34,0,0,0-18.52,3l-4.16-15.27c-2.09.64-4.21,1.16-6.26,1.93l-1.29-3.8c1.78-.66,3.63-1.16,5.45-1.7s3.69-1,5.54-1.41l3.52,15.43c1.88-.5,3.82-.75,5.73-1.13s3.86-.54,5.79-.79L270,137.27l5.74-.44,5.74-.15Z" transform="translate(-4.5 -8.17)"/>
      <path class="cls-3" d="M316.11,146.41c-2.08-.78-4.23-1.31-6.35-1.95l-4.14,15.27a91.44,91.44,0,0,0-18.52-3l.95-15.79c-2.18-.15-4.36-.15-6.55-.22v-4l5.7.15,5.7.43L291.3,153c1.93.24,3.87.46,5.79.77l2.87.53,1.44.27,1.42.33,3.5-15.43c1.87.45,3.75.85,5.58,1.42s3.7,1,5.5,1.71Z" transform="translate(-4.5 -8.17)"/>
      <path class="cls-3" d="M347.05,162.86c-1.79-1.29-3.53-2.66-5.4-3.84l-8.8,13.16a93.5,93.5,0,0,0-16.58-8.83l6-14.65c-1-.4-2-.83-3-1.21l-3.1-1.08,1.29-3.8c1.8.63,3.61,1.22,5.36,2s3.54,1.41,5.25,2.24l-6.58,14.39,2.65,1.24,2.59,1.35c1.74.87,3.39,1.91,5.07,2.9L340,153.2c1.65,1,3.21,2.07,4.82,3.11s3.1,2.24,4.65,3.35Z" transform="translate(-4.5 -8.17)"/>
      <path class="cls-3" d="M371.24,188.11c-1.22-1.84-2.59-3.56-3.92-5.32l-12.44,9.79a96.88,96.88,0,0,0-13-13.6l10.29-12c-1.67-1.39-3.36-2.78-5.09-4.1l2.43-3.2c1.52,1.14,3,2.37,4.45,3.55s2.84,2.51,4.26,3.77l-10.77,11.6c1.41,1.35,2.82,2.7,4.17,4.11s2.69,2.82,3.92,4.34l12-10.27c1.23,1.46,2.47,2.9,3.6,4.44s2.33,3,3.39,4.61Z" transform="translate(-4.5 -8.17)"/>
      <path class="cls-3" d="M386.61,219.47c-.71-2.08-1.33-4.2-2.16-6.24l-14.82,5.57a97.7,97.7,0,0,0-8.29-16.94l13.48-8.3-1.73-2.77-1.85-2.68,3.3-2.3,1.61,2.34c.53.78,1,1.59,1.52,2.39l1.5,2.41c.49.81.93,1.65,1.4,2.47l-13.8,7.76,1.43,2.56,1.3,2.62c.91,1.73,1.63,3.55,2.43,5.33l14.59-6.14c.77,1.75,1.39,3.55,2.09,5.32s1.22,3.61,1.83,5.41Z" transform="translate(-4.5 -8.17)"/>
      <path class="cls-3" d="M391.83,254c-.06-2.2-.06-4.4-.19-6.59l-15.81.88a99.63,99.63,0,0,0-2.8-18.67l15.35-3.84c-.59-2.09-1.11-4.21-1.77-6.28l3.83-1.19c.59,1.8,1,3.64,1.55,5.45s.86,3.68,1.29,5.52l-15.49,3.24c.43,1.91.69,3.85,1,5.77s.51,3.87.71,5.81l15.75-1.48c.14,1.9.3,3.79.41,5.69l.14,5.69Z" transform="translate(-4.5 -8.17)"/>
    </g>
  </g>
  <ellipse class="cls-4" cx="277.34" cy="245.46" rx="67.55" ry="69.51"/>
  <line class="cls-5" x1="23.87" y1="118.51" x2="199.68" y2="118.51"/>
  <line class="cls-5" x1="24.3" y1="151.49" x2="165.18" y2="151.49"/>
  <line class="cls-5" x1="24.3" y1="182.37" x2="160.62" y2="182.37"/>
  <line class="cls-5" x1="23.97" y1="214.01" x2="140.53" y2="214.01"/>
  <line class="cls-5" x1="24.18" y1="246.75" x2="139.73" y2="246.75"/>
  <line class="cls-5" x1="24.1" y1="277.91" x2="146.74" y2="277.91"/>
  <line class="cls-5" x1="23.68" y1="308.88" x2="168.11" y2="308.88"/>
  <line class="cls-5" x1="24.3" y1="339.99" x2="201.16" y2="339.99"/>
  <rect class="cls-6" x="49.54" y="27.18" width="185.81" height="34.41" rx="16.96" ry="16.96"/>
  <path class="cls-2" d="M105.05,35.19a47.17,47.17,0,0,1,83.81,0" transform="translate(-4.5 -8.17)"/>
  <text class="cls-7" transform="translate(19.57 335.65) scale(0.97 1)">!</text>
</svg>

                    </div>
                    <hr>
                    <p class="text-center">Use of quality components</p>
                    </div>
                </div>    
                <div class="clearfix"></div>   
        </div>
    </section>

    <section id="products" class="product">
        <h2 class="section-title">The samples of products</h2>
        <ul class="product-list">
            <li class="product-item animated-item js-animated-item">
                <div class="product-img_wrapper">
                    <img src="/mmc-400/assets/img/400/2-400png.png" alt="" class="product-img">
                </div>
                <div class="product-info">
                    <p class="product-description">Contains B-group vitamins, many macro- and microelements, polyunsaturated fat, is a real source of energy.</p>
                    <p class="product-description"><span>Ingredients: </span>sunflower seeds, black sesame seeds, flax seeds, sublimated raspberries, corn flakes, raisins, syrup with add honey.</p>
                </div>
            </li>
            <li class="product-item animated-item js-animated-item">
                <div class="product-img_wrapper">
                    <img src="/mmc-400/assets/img/400/3-400png.png" alt="" class="product-img">
                </div>
                <div class="product-info">
                    <p class="product-description">The beneficial composition of this balls helps to reduce the acidity of the stomach, remove toxins from the body, and also restores energy, causes a surge of strength in the human body.</p>
                    <p class="product-description"><span>Ingredients: </span>puffed rice, whole peanuts, raisins, dried chopped barberry, rye flakes.</p>
                </div>
            </li>
            <li class="product-item animated-item js-animated-item">
                <div class="product-img_wrapper">
                    <img src="/mmc-400/assets/img/400/4-400png.png" alt="" class="product-img">
                </div>
                <div class="product-info">
                    <p class="product-description">The bar is enriched with protein and fiber. This makes it ideal for those who want to always monitor the state of their figure. And those beneficial substances that are in its composition positively affect the body as a whole.</p>
                    <p class="product-description"><span>Ingredients: </span>Rice balls, candied fruits (pineapple), pumpkin seeds, wheat flakes, dried cranberries, chocolate, crushed hazelnuts.</p>
                </div>
            </li>
            <li class="product-item animated-item js-animated-item">
                <div class="product-img_wrapper">
                    <img src="/mmc-400/assets/img/400/5-400png.png" alt="" class="product-img">
                </div>
                <div class="product-info">
                    <p class="product-description">It is rich in easily digestible protein, it contains dried blueberries - rich in vitamins, as well as sublimated strawberries, which prevents the formation of cancerous tumors and prevents the occurrence of anemia.</p>
                    <p class="product-description"><span>Ingredients: </span>protein balls, oatmeal, dried blueberries, sublimated strawberries, raisins, Jerusalem artichoke syrup.</p>
                </div>
            </li>
        </ul>
    </section>
    <section id="line" class="section-line">
    <h2 class="section-title process-title">The technological process of work the forming machine MMC-400</h2>
        <div class="line_wrapper">
            <div class="line-video_wrapper">
                <div class="line-video">
                    <iframe src="https://www.youtube.com/embed/tylrL1QHBSE" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
            <div class="profile-wrapper fadeInRight">
                <div class="about">
                    <p class="about-txt">Forming machine for cereal mass MMC-200 is very easy to operate and service. You will no need large production areas and huge lines. Despite its small size, the forming machine MMC-200 has capacity up to 5 400 bars per hour, with a working width of 200 mm.</p>
<p class="about-txt">The prepared mass (cereal mixed with syrup) is loaded into the hopper of the forming machine manually or automatically using a transport system. Special feeding shafts in the hopper of the forming machine fill the cells in the forming roll by cereal mass. Cells are made individually for each customer based on the size and shape of the final product. Then the stamp system gives the desired shape to the cereal mass.</p>
<p class="about-txt">Thus, the forming machine MMC-200 works without scraps and defects, and cereals are not damaged during forming. Control is carried out using the touch screen panel. The stamp system has adjustable parameters, such as pressure force (allows you to adjust the density of the final product), stamp pressure time (for different masses, different stamp pressure time may be required to forming). All parameter settings are saved in the recipe, which allows you to produce a large assortment of cereal masses with one forming machine. Experiment, find new combinations of taste and benefit, because the compositions of cereal masses can be a great many.</p>
<p class="about-txt">Next, the already formed product enters to the belt of the transport system of the forming machine. Thanks to the integrated transport system, the finished product can transferred to the enrobing or packaging machine.</p>
                </div>
            </div>
        </div>
</section>
<section class="process">
        <h2 class="section-title-2">The technological process of the automatic line</h2>
        <div class="line_wrapper">
            <div class="line-video_wrapper">
                <div class="line-video">
                    <iframe src="https://www.youtube.com/embed/bM88mnjvZ6A" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
            <div class="profile-wrapper fadeInRight">
                <div class="about">
                    <p class="about-txt-2 animated-item js-animated-item"><span>Step 1. Mixing the components. </span>Cereal ingredients in accordance with the proportions of the formulation are loaded into the mixer MSW-90. Maked the mixing process. Then a binder (syrup) is added to the resulting mass and the mass is re-mixed to a homogeneous consistency. The resulting mass is unloaded and fed into the hopper of the forming machine for cereal mass MMC-200 using a transport system or manually.</p>
                    <p class="about-txt-2 animated-item js-animated-item"><span>Step 2. Forming. </span>After loading the mass into the hopper of the forming machine MMC-200, maked the forming process and the product of the final form for the next process step according to the technology enters the machine conveyor belt. It can be: cooling (for solidification syrup); coating with chocolate or yogurt glaze (the whole product or only the bottom); heat treatment (on trays in a convection-type oven or by conveyor into a tunnel-type oven).</p>
                    <p class="about-txt-2 animated-item js-animated-item"><span>Step 3. Cooling. </span>If the technology of the binder (syrup) requires cooling for further work, then the product after the conveyor belt of the forming machine goes to the conveyor of the cooling tunnel SW-CT 200, the working length is 10 m.</p>
                    <p class="about-txt-2 animated-item js-animated-item"><span>Step 4. Enrobing. </span>If the product according to the technology needs to be enrobed with chocolate or any other glaze, then after the cooling tunnel or immediately after the forming machine MMC-200, the product enters the mesh tape of the SW-ET 200 enrobing machine, where the product is completely enrobing with chocolate or glaze or only the bottom of the product.</p>
                    <p class="about-txt-2 animated-item js-animated-item"><span>Step 5. Cooling. </span>After the enrobing machine SW-ET 200, the product must be cooled. For this is used the cooling tunnel SW-CT 200 , the working length 10 m.</p>
                    <p class="about-txt-2 animated-item js-animated-item"><span>Step 6. Packing. </span>After all the processes according to the technology are finished, the product can be packaged. The most popular type of packing for this kind of product is flowpack packaging. To automate the packaging process, as well as to increase the speed of packaging, is used the automatic packing machine PMW-250 with automatic feeders, which align the product from the production line to one stream. The packed product is ready for sale.</p>
                </div>
            </div>
        </div>
    </section>
<section class="photo" id="photo">
        <h3 class="section-title-photo">Pictures</h3>
        <ul class="photo-wrapper">
            <li class="line-item animated-item js-animated-item">
                <div class="line-img-wrapper">
                    <img src="/mmc-400/assets/img/400/line/liniy_4png.png" alt="" class="line-img">
                    <span></span>
                </div>
                <h4 class="line-subtitle">Mixer MSW-90</h4>
            </li>
            <li class="line-item animated-item js-animated-item">
                <div class="line-img-wrapper">
                    <img src="/mmc-400/assets/img/400/line/MMC400.png" alt="" class="line-img">
                    <span></span>
                </div>
                <h4 class="line-subtitle">MMC-400</h4>
            </li>
            <li class="line-item animated-item js-animated-item">
                <div class="line-img-wrapper">
                    <img src="/mmc-400/assets/img/400/line/liniy_3png.png" alt="" class="line-img">
                    <span></span>
                </div>
                <h4 class="line-subtitle">Enrobing machine SW-ET/200</h4>
            </li>
            <li class="line-item animated-item js-animated-item">
                <div class="line-img-wrapper">
                    <img src="/mmc-400/assets/img/400/line/liniy_2png.png" alt="" class="line-img">
                    <span></span>
                </div>
                <h4 class="line-subtitle">Cooling tunnel SW-CT/200</h4>
            </li>
            <li class="line-item animated-item js-animated-item">
                <div class="line-img-wrapper">
                    <img src="/mmc-400/assets/img/400/line/liniy_1png.png" alt="" class="line-img">
                    <span></span>
                </div>
                <h4 class="line-subtitle">Packing machine PMW-250</h4>
            </li>
        </ul>
    </section>
    <section class="contacts js-contacts" id="contacts">
        <div class="contacts-bg js-contacts-bg">
            <img src="/mmc-200/assets/img/background.jpg" alt="" class="contact-bg-img">
        </div>
        <div class="contacts-content">
            <h2 class="section-title">Contacts</h2>
            <div class="contacts-wrapper">
                <ul class="contacts-list">
                    <li class="contacts-item">
                        <h6>
                            <svg height="16pt" viewBox="0 -1 512 512" width="16pt" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink">
                                <linearGradient id="a" gradientUnits="userSpaceOnUse" x1="256.0002597504" x2="256.0002597504"
                                                y1=".0001997504" y2="510.7493837504">
                                    <stop offset="0" stop-color="#2af598"/>
                                    <stop offset="1" stop-color="#009efd"/>
                                </linearGradient>
                                <path d="m204.5 458.605469v51.855469l-12.539062-10.128907c-1.9375-1.566406-48.035157-38.992187-94.78125-92.660156-64.484376-74.035156-97.179688-140.492187-97.179688-197.519531v-5.652344c0-112.761719 91.738281-204.5 204.5-204.5s204.5 91.738281 204.5 204.5v5.652344c0 4.789062-.253906 9.652344-.714844 14.574218l-39.992187-36.484374c-8.191407-83.15625-78.519531-148.339844-163.792969-148.339844-90.757812 0-164.597656 73.839844-164.597656 164.597656v5.652344c0 96.367187 124.164062 213.027344 164.597656 248.453125zm122.699219-28.660157h59.851562v-59.851562h-59.851562zm-122.699219-310.238281c46.753906 0 84.792969 38.039063 84.792969 84.792969s-38.039063 84.792969-84.792969 84.792969-84.792969-38.039063-84.792969-84.792969 38.039063-84.792969 84.792969-84.792969zm0 39.902344c-24.753906 0-44.890625 20.136719-44.890625 44.890625 0 24.75 20.136719 44.890625 44.890625 44.890625 24.75 0 44.890625-20.140625 44.890625-44.890625 0-24.753906-20.140625-44.890625-44.890625-44.890625zm280.609375 243.222656-11.21875-10.234375v64.058594c0 29.828125-24.269531 54.09375-54.097656 54.09375h-126.332031c-29.828126 0-54.097657-24.265625-54.097657-54.09375v-64.058594l-11.21875 10.234375-26.890625-29.476562 155.371094-141.746094 155.375 141.746094zm-51.121094-46.636719-77.363281-70.574218-77.359375 70.574218v100.457032c0 7.828125 6.367187 14.195312 14.195313 14.195312h126.332031c7.828125 0 14.195312-6.367187 14.195312-14.195312zm0 0"
                                      fill="url(#a)"/>
                            </svg><span>RUSSIA, STAVROPOL REGION, KOCHUBEEV DISTRICT,
<br>H. NOVOZELENCHUKSKY, STR. GAGARINA, 1</span>
                        </h6>
                    </li>
                    <li class="contacts-item">
                        <svg height="16pt" width="16pt" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
<linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="256.2437" y1="513.822" x2="256.2437" y2="1.547"
                gradientTransform="matrix(0.9992 0 0 -0.9992 -0.0391 513.4789)">
    <stop offset="0" style="stop-color:#2AF598"/>
    <stop offset="1" style="stop-color:#009EFD"/>
</linearGradient>
                            <path style="fill:url(#SVGID_1_);" d="M385.22,511.933c-12.434,0-24.949-2.751-36.609-8.414
  c-49.209-23.902-123.478-68.002-197.837-142.36C76.414,286.798,32.314,212.53,8.414,163.321
  c-15.662-32.248-9.054-71.047,16.445-96.546L92.011,0.067l136.304,137.121l-53.979,54.676c9.194,16.219,29.054,47.218,62.524,80.688
  c33.464,33.465,64.239,53.102,80.305,62.151l55.77-54.001L512,419.999l-66.843,67.074
  C428.878,503.353,407.176,511.933,385.22,511.933z M431.028,472.942h0.01H431.028z M91.833,56.581L53.074,95.083
  c-13.415,13.415-16.933,33.84-8.708,50.775c22.561,46.451,64.238,116.606,134.671,187.039
  c70.43,70.431,140.586,112.108,187.039,134.67c16.926,8.221,37.341,4.709,50.805-8.739l38.669-38.804l-83.09-83.227l-47.467,45.962
  l-12.295-5.404c-2.008-0.882-49.799-22.238-104.101-76.54c-54.267-54.266-76.075-102.463-76.978-104.489l-5.55-12.462l45.984-46.579
  L91.833,56.581z"/>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
</svg>
                        <span>TEL. +7 (86554) 9-53-17 EXT. 500/504/104/501/506</span>
                    </li>
                    <li class="contacts-item">
                        <svg width="16pt" height="16pt" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
<linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="256" y1="446" x2="256" y2="70" gradientTransform="matrix(1 0 0 -1 0 514)">
    <stop  offset="0" style="stop-color:#2AF598"/>
    <stop  offset="1" style="stop-color:#009EFD"/>
</linearGradient>
                            <path style="fill:url(#SVGID_1_);" d="M452,68H60C26.916,68,0,94.916,0,128v256c0,33.084,26.916,60,60,60h392
	c33.084,0,60-26.916,60-60V128C512,94.916,485.084,68,452,68z M448.354,108L256,251.074L63.646,108H448.354z M452,404H60
	c-11.028,0-20-8.972-20-20V140.263l216,160.663l216-160.663V384C472,395.028,463.028,404,452,404z"/>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
</svg>
                        <span><a href="mailto:info@sweetstech.com">info@sweetstech.com</a></span>
                    </li>
                </ul>
                <div class="map-wrapper">
                    <iframe class="map-wrapper-iframe" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d5819944.899191486!2d41.9003569!3d44.5812749!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xcceb78920dd5d98!2s%22Sweets%20technologies%22%20Ltd.!5e0!3m2!1sru!2sru!4v1581571868237!5m2!1sru!2sru" width="100%" height="320" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </section>
</main>

<div class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 logo">
        <a href="/index.html" class="logo-link">
            <img src="assets/img/logo.png" alt="sweets technologies logo" class="footer-logo-img">
        </a>
    </div>
            <div class="col-md-4 text-center social">
        <a href="https://www.instagram.com/sweetstech" target="_blank">
            <svg height="18pt" viewBox="0 0 511 511.9" width="18pt" xmlns="http://www.w3.org/2000/svg"><path d="m510.949219 150.5c-1.199219-27.199219-5.597657-45.898438-11.898438-62.101562-6.5-17.199219-16.5-32.597657-29.601562-45.398438-12.800781-13-28.300781-23.101562-45.300781-29.5-16.296876-6.300781-34.898438-10.699219-62.097657-11.898438-27.402343-1.300781-36.101562-1.601562-105.601562-1.601562s-78.199219.300781-105.5 1.5c-27.199219 1.199219-45.898438 5.601562-62.097657 11.898438-17.203124 6.5-32.601562 16.5-45.402343 29.601562-13 12.800781-23.097657 28.300781-29.5 45.300781-6.300781 16.300781-10.699219 34.898438-11.898438 62.097657-1.300781 27.402343-1.601562 36.101562-1.601562 105.601562s.300781 78.199219 1.5 105.5c1.199219 27.199219 5.601562 45.898438 11.902343 62.101562 6.5 17.199219 16.597657 32.597657 29.597657 45.398438 12.800781 13 28.300781 23.101562 45.300781 29.5 16.300781 6.300781 34.898438 10.699219 62.101562 11.898438 27.296876 1.203124 36 1.5 105.5 1.5s78.199219-.296876 105.5-1.5c27.199219-1.199219 45.898438-5.597657 62.097657-11.898438 34.402343-13.300781 61.601562-40.5 74.902343-74.898438 6.296876-16.300781 10.699219-34.902343 11.898438-62.101562 1.199219-27.300781 1.5-36 1.5-105.5s-.101562-78.199219-1.300781-105.5zm-46.097657 209c-1.101562 25-5.300781 38.5-8.800781 47.5-8.601562 22.300781-26.300781 40-48.601562 48.601562-9 3.5-22.597657 7.699219-47.5 8.796876-27 1.203124-35.097657 1.5-103.398438 1.5s-76.5-.296876-103.402343-1.5c-25-1.097657-38.5-5.296876-47.5-8.796876-11.097657-4.101562-21.199219-10.601562-29.398438-19.101562-8.5-8.300781-15-18.300781-19.101562-29.398438-3.5-9-7.699219-22.601562-8.796876-47.5-1.203124-27-1.5-35.101562-1.5-103.402343s.296876-76.5 1.5-103.398438c1.097657-25 5.296876-38.5 8.796876-47.5 4.101562-11.101562 10.601562-21.199219 19.203124-29.402343 8.296876-8.5 18.296876-15 29.398438-19.097657 9-3.5 22.601562-7.699219 47.5-8.800781 27-1.199219 35.101562-1.5 103.398438-1.5 68.402343 0 76.5.300781 103.402343 1.5 25 1.101562 38.5 5.300781 47.5 8.800781 11.097657 4.097657 21.199219 10.597657 29.398438 19.097657 8.5 8.300781 15 18.300781 19.101562 29.402343 3.5 9 7.699219 22.597657 8.800781 47.5 1.199219 27 1.5 35.097657 1.5 103.398438s-.300781 76.300781-1.5 103.300781zm0 0"/><path d="m256.449219 124.5c-72.597657 0-131.5 58.898438-131.5 131.5s58.902343 131.5 131.5 131.5c72.601562 0 131.5-58.898438 131.5-131.5s-58.898438-131.5-131.5-131.5zm0 216.800781c-47.097657 0-85.300781-38.199219-85.300781-85.300781s38.203124-85.300781 85.300781-85.300781c47.101562 0 85.300781 38.199219 85.300781 85.300781s-38.199219 85.300781-85.300781 85.300781zm0 0"/><path d="m423.851562 119.300781c0 16.953125-13.746093 30.699219-30.703124 30.699219-16.953126 0-30.699219-13.746094-30.699219-30.699219 0-16.957031 13.746093-30.699219 30.699219-30.699219 16.957031 0 30.703124 13.742188 30.703124 30.699219zm0 0"/></svg>
        </a>
            <a href="https://www.youtube.com/channel/UCISaAQ5WmmMtvU7-_g_diDQ" target="_blank">
            <svg version="1.1" height="18pt" width="18pt" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
<g><g><path d="M490.24,113.92c-13.888-24.704-28.96-29.248-59.648-30.976C399.936,80.864,322.848,80,256.064,80
            c-66.912,0-144.032,0.864-174.656,2.912c-30.624,1.76-45.728,6.272-59.744,31.008C7.36,138.592,0,181.088,0,255.904
            C0,255.968,0,256,0,256c0,0.064,0,0.096,0,0.096v0.064c0,74.496,7.36,117.312,21.664,141.728
            c14.016,24.704,29.088,29.184,59.712,31.264C112.032,430.944,189.152,432,256.064,432c66.784,0,143.872-1.056,174.56-2.816
            c30.688-2.08,45.76-6.56,59.648-31.264C504.704,373.504,512,330.688,512,256.192c0,0,0-0.096,0-0.16c0,0,0-0.064,0-0.096
            C512,181.088,504.704,138.592,490.24,113.92z M192,352V160l160,96L192,352z"/>
    </g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
            </a>
            <a href="https://facebook.com/sweetstec" target="_blank">
                <svg height="18pt" width="18pt" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m437 0h-362c-41.351562 0-75 33.648438-75 75v362c0 41.351562 33.648438 75 75 75h151v-181h-60v-90h60v-61c0-49.628906 40.371094-90 90-90h91v90h-91v61h91l-15 90h-76v181h121c41.351562 0 75-33.648438 75-75v-362c0-41.351562-33.648438-75-75-75zm0 0"/></svg>
            </a>
        </div>         
    <div class="col-md-4 copy">
        <p>All rights reserved. © <a href="https://sweetstech.com/ru/">Sweets Technologies Ltd.</a></p>
    </div> 
</div>
</div>
</div>
<div class="order-success">
    <p class="order-success-txt">
        <span></span>
        <button type="button" class="order-success-close"></button>
    </p>
</div>

<div class="contacts-form_wrapper js-contacts-form_wrapper">
    <form action="/mmc-200/index.php" class="form" method="post" enctype="multipart/form-data">
        <h3 class="form-title">MMC-400</h3>
        <div class="input_wrapper">
            <label for="nsp" class="form-label js-form-label">Name</label>
            <input type="text" id="nsp" name="nsp" class="form-input js-form-input" required>
        </div>
        <div class="input_wrapper">
            <label for="company" class="form-label js-form-label">Company</label>
            <input type="text" id="company" name="company" class="form-input js-form-input" required>
        </div>
        <div class="input_wrapper">
            <label for="email" class="form-label js-form-label">E-mail</label>
            <input type="email" id="email" name="email" class="form-input js-form-input" required>
        </div>
        <div class="input_wrapper phone_wrapper">
            <label for="phone" class="form-label js-form-label">Phone</label>
            <input type="tel" id="phone" name="phone" class="form-input js-form-input">
        </div>
        <input type="hidden" name="product" value="mmc-200">
        <p class="form-info">* - required</p>
        <p class="form-info">
            <input type="checkbox" class="form-accept js-form-accept" checked="checked" id="accept" style="cursor:pointer;">
            <label style="cursor:pointer;" for="accept">I agree to the processing of personal data</label>
        </p>
        <input type="hidden" name="prod" value="MMC-200">
        <div class="form-btn_wrapper">
            <button type="submit" class="form-btn js-form-btn">
                <span class="js-form-btn_txt">Get quotation</span>
                <div class="spinner js-spinner">
                    <div class="bounce1"></div>
                    <div class="bounce2"></div>
                    <div class="bounce3"></div>
                </div>
            </button>
        </div>
        <button class="form-close js-form-close form-close-inner" type="button">
            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
<g>
    <g>
        <path d="M256,0C114.508,0,0,114.497,0,256c0,141.493,114.497,256,256,256c141.492,0,256-114.497,256-256
			C512,114.507,397.503,0,256,0z M256,472c-119.384,0-216-96.607-216-216c0-119.385,96.607-216,216-216
			c119.384,0,216,96.607,216,216C472,375.385,375.393,472,256,472z"/>
    </g>
</g>
                <g>
                    <g>
                        <path d="M343.586,315.302L284.284,256l59.302-59.302c7.81-7.81,7.811-20.473,0.001-28.284c-7.812-7.811-20.475-7.81-28.284,0
			L256,227.716l-59.303-59.302c-7.809-7.811-20.474-7.811-28.284,0c-7.81,7.811-7.81,20.474,0.001,28.284L227.716,256
			l-59.302,59.302c-7.811,7.811-7.812,20.474-0.001,28.284c7.813,7.812,20.476,7.809,28.284,0L256,284.284l59.303,59.302
			c7.808,7.81,20.473,7.811,28.284,0C351.398,335.775,351.397,323.112,343.586,315.302z"/>
                    </g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
</svg>
        </button>
    </form>
    <button class="form-close js-form-close form-close-outer" type="button">
        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
<g>
    <g>
        <path d="M256,0C114.508,0,0,114.497,0,256c0,141.493,114.497,256,256,256c141.492,0,256-114.497,256-256
			C512,114.507,397.503,0,256,0z M256,472c-119.384,0-216-96.607-216-216c0-119.385,96.607-216,216-216
			c119.384,0,216,96.607,216,216C472,375.385,375.393,472,256,472z"/>
    </g>
</g>
            <g>
                <g>
                    <path d="M343.586,315.302L284.284,256l59.302-59.302c7.81-7.81,7.811-20.473,0.001-28.284c-7.812-7.811-20.475-7.81-28.284,0
			L256,227.716l-59.303-59.302c-7.809-7.811-20.474-7.811-28.284,0c-7.81,7.811-7.81,20.474,0.001,28.284L227.716,256
			l-59.302,59.302c-7.811,7.811-7.812,20.474-0.001,28.284c7.813,7.812,20.476,7.809,28.284,0L256,284.284l59.303,59.302
			c7.808,7.81,20.473,7.811,28.284,0C351.398,335.775,351.397,323.112,343.586,315.302z"/>
                </g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
</svg>
    </button>
</div>
<button type="button" class="show-form js-show-form">Get quotation</button>

<div class="to-top js-to-top">
    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"><path fill="none" d="M0 0h24v24H0V0z"></path><path d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.58 5.59L20 12l-8-8-8 8z"></path></svg>
</div>

<script src="/mmc-200/js/landings.js"></script>

</body>
</html>
