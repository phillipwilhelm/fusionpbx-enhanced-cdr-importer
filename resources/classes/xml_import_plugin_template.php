<?php /*
        Contributor(s):
        Luis Daniel Lucio Quiroz <dlucio@okay.com.mx>
*/

if (!class_exists('xml_import_plugin_template')) {
	abstract class xml_import_plugin_template {
		abstract public function fields();
		abstract public function xml_array($row, $leg, $xml_string);
		abstract public function execute();
		abstract public function read_files();
		abstract public function post();
	}
}
?>
