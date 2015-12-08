<?php

/**
 * Support the htmlinject hook, which allows modules to change header, pre and post body on all pages.
 */
$this->data['htmlinject'] = array(
    'htmlContentPre' => array(),
    'htmlContentPost' => array(),
    'htmlContentHead' => array(),
);

$this->data['header'] = "Single Sign On (SSO) : " . $this->t('{auth2factor:login:authentication}');

$jquery = array();
if (array_key_exists('jquery', $this->data)) $jquery = $this->data['jquery'];

if (array_key_exists('pageid', $this->data)) {
    $hookinfo = array(
        'pre' => &$this->data['htmlinject']['htmlContentPre'],
        'post' => &$this->data['htmlinject']['htmlContentPost'],
        'head' => &$this->data['htmlinject']['htmlContentHead'],
        'jquery' => &$jquery,
        'page' => $this->data['pageid']
    );

    SimpleSAML_Module::callHooks('htmlinject', $hookinfo);
}
// - o - o - o - o - o - o - o - o - o - o - o - o -

/**
 * Do not allow to frame simpleSAMLphp pages from another location.
 * This prevents clickjacking attacks in modern browsers.
 *
 * If you don't want any framing at all you can even change this to
 * 'DENY', or comment it out if you actually want to allow foreign
 * sites to put simpleSAMLphp in a frame. The latter is however
 * probably not a good security practice.
 */
header('X-Frame-Options: SAMEORIGIN');

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="target-densitydpi=device-dpi, width=device-width, height=device-height, initial-scale=1.0" />
<script type="text/javascript" src="/<?php echo $this->data['baseurlpath']; ?>resources/script.js"></script>
<title><?php
if(array_key_exists('header', $this->data)) {
    echo $this->data['header'];
} else {
    echo 'simpleSAMLphp';
}
?></title>
    <!-- Javascript -->
    <script type="text/javascript" src="<?php echo SimpleSAML_Module::getModuleURL('theme2factor/jquery.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo SimpleSAML_Module::getModuleURL('theme2factor/jquery-ui.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo SimpleSAML_Module::getModuleURL('theme2factor/placeholders.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo SimpleSAML_Module::getModuleURL('theme2factor/dialogs.js'); ?>"></script>

    <!-- Fonts/CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo SimpleSAML_Module::getModuleURL('theme2factor/fonts.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo SimpleSAML_Module::getModuleURL('theme2factor/normalize.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo SimpleSAML_Module::getModuleURL('theme2factor/default.css'); ?>" />

    <!-- Icon -->
    <link rel="icon" type="image/icon" href="<?php echo SimpleSAML_Module::getModuleURL('theme2factor/favicon_16.ico'); ?>" />

    <!-- IE Fixes -->
    <!--[if lt IE 9]>
      <script type="text/javascript" src="<?php echo SimpleSAML_Module::getModuleURL('theme2factor/PIE/PIE_IE678.js'); ?>"></script>
    <![endif]-->
    <!--[if IE 9]>
      <script type="text/javascript" src="<?php echo SimpleSAML_Module::getModuleURL('theme2factor/PIE/PIE_IE9.js'); ?>"></script>
    <![endif]-->
    <script type="text/javascript" src="<?php echo SimpleSAML_Module::getModuleURL('theme2factor/ie.js'); ?>"></script>

<?php

if(!empty($this->data['htmlinject']['htmlContentHead'])) {
    foreach($this->data['htmlinject']['htmlContentHead'] AS $c) {
        echo $c;
    }
}




if ($this->isLanguageRTL()) {
?>
    <link rel="stylesheet" type="text/css" href="/<?php echo $this->data['baseurlpath']; ?>resources/default-rtl.css" />
<?php
}
?>


    <meta name="robots" content="noindex, nofollow" />


<?php
if(array_key_exists('head', $this->data)) {
    echo '<!-- head -->' . $this->data['head'] . '<!-- /head -->';
}
?>
</head>
<?php
$onLoad = '';
if(array_key_exists('autofocus', $this->data)) {
    $onLoad .= 'SimpleSAML_focus(\'' . $this->data['autofocus'] . '\');';
}
if (isset($this->data['onLoad'])) {
    $onLoad .= $this->data['onLoad'];
}

if($onLoad !== '') {
    $onLoad = ' onload="' . $onLoad . '"';
}
?>
<body<?php echo $onLoad; ?>>
<div id="cover" style="display: none;"></div>
<div id="wrap">

    <!--<div id="header">
        <h1><a style="text-decoration: none; color: white" href="/<?php echo $this->data['baseurlpath']; ?>"><?php
            echo (isset($this->data['header']) ? $this->data['header'] : 'simpleSAMLphp');
        ?></a></h1>
    </div>-->


    <?php

    $includeLanguageBar = FALSE;
    if (!empty($_POST))
        $includeLanguageBar = FALSE;
    if (isset($this->data['hideLanguageBar']) && $this->data['hideLanguageBar'] === TRUE)
        $includeLanguageBar = FALSE;

    if ($includeLanguageBar) {


        echo '<div id="languagebar">';
        $languages = $this->getLanguageList();
        $langnames = array(
                    'en' => 'English',
        );

        $textarray = array();
        foreach ($languages AS $lang => $current) {
            $lang = strtolower($lang);
            if ($current) {
                $textarray[] = $langnames[$lang];
            } else {
                $textarray[] = '<a href="' . htmlspecialchars(SimpleSAML_Utilities::addURLparameter(SimpleSAML_Utilities::selfURL(), array($this->languageParameterName => $lang))) . '">' .
                    $langnames[$lang] . '</a>';
            }
        }
        echo join(' | ', $textarray);
        echo '</div>';

    }



    ?>

    <div id="dialog-help" class="dialog-box" style="display: none;">
      <h1>Help</h1>
      <p>Steps to sign on</p>
      <ol>
        <li><strong>Username and Password</strong> - Log in with your usual username and password</li>
        <li><strong>Question</strong> - You will need to answer one of three possible questions using the on-screen keyboard to enter in your answer</li>
        <li><strong>OTP (One Time Password)</strong> - A six digit code will be sent to your email address. You will then need to type this code in.</li>
      </ol>
      <p>If you have not set up your questions, you will be asked to select and answer three questions</p>
      <p>Please contact your system administrator if you have any more queries.</p>
      <p>Machine ID: <?php echo gethostname() ?></p>
      <a href="#" class="dialog-close btn">Close</a>
    </div>
    <div id="dialog-forgot" class="dialog-box" style="display: none;">
      <h1>Forgot Password</h1>
      <p>Please contact your system administrator in order to get a new password.</p>
      <a href="#" class="dialog-close btn">Close</a>
    </div>


    <div id="login-box">
      <div id="login-header">
        <div id="logo">
          <img src="<?php echo SimpleSAML_Module::getModuleURL('theme2factor/logo.jpg'); ?>" alt="SimpleSAMLphp Logo" />
        </div>

<?php

if(!empty($this->data['htmlinject']['htmlContentPre'])) {
    foreach($this->data['htmlinject']['htmlContentPre'] AS $c) {
        echo $c;
    }
}
