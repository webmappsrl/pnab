<?php
// Before removing this file, please verify the PHP ini setting `auto_prepend_file` does not point to this.

if (file_exists('/home/webmapp9/public_html/pnab.it/wp-content/plugins/wordfence/waf/bootstrap.php')) {
	define("WFWAF_LOG_PATH", '/home/webmapp9/public_html/pnab.it/wp-content/wflogs/');
	include_once '/home/webmapp9/public_html/pnab.it/wp-content/plugins/wordfence/waf/bootstrap.php';
}
?>