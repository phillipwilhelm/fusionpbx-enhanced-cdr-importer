<?php /*
        Contributor(s):
        Luis Daniel Lucio Quiroz <dlucio@okay.com.mx>
*/

if (!class_exists('xml_import_plugin_template')) {
	abstract class xml_import_plugin_template {
		abstract public function fields();
		abstract public function xml_array($row, $leg, $xml_string);
		abstract public function read_files($payload = '');
		abstract public function post($payload = '');

		function __construct(){
			openlog(get_class(), LOG_PID | LOG_PERROR, LOG_LOCAL0);
		}

		function __destruct(){
			closelog();
		}
	}
}
?>
