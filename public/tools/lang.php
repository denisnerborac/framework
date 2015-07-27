<?php
require '../../config/core.conf.php';

header('Content-type: text/html; charset='.Lang::$encoding);

echo _("Hello world !").'<br>';
echo _("Welcome !").'<br>';

$locale = (isset($_GET['locale']))? $_GET['locale'] : Lang::getDefaultLocale();

$lang = new Lang($locale);

echo $lang->getUserLocale();
echo '<br>';
echo $lang->getUserLang();
echo '<br>';
echo $locale;

print "<p>";
foreach(Lang::$locales as $l) {
	print "[<a href=\"?locale=$l\">$l</a>] ";
}
print "</p>\n";

if (!locale_emulation()) {
	print "<p>locale '$locale' is supported by your system, using native gettext implementation.</p>\n";
}
else {
	print "<p>locale '$locale' is <strong>not</strong> supported on your system, using custom gettext implementation.</p>\n";
}

echo Lang::_("Hello world !").'<br>';
echo Lang::_("Welcome !").'<br>';