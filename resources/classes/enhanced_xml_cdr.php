<?php
/*
	FusionPBX
	Version: MPL 1.1

	The contents of this file are subject to the Mozilla Public License Version
	1.1 (the "License"); you may not use this file except in compliance with
	the License. You may obtain a copy of the License at
	http://www.mozilla.org/MPL/

	Software distributed under the License is distributed on an "AS IS" basis,
	WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License
	for the specific language governing rights and limitations under the
	License.

	Contributor(s):
	Luis Daniel Lucio Quiroz <dlucio@okay.com.mx>

	Note: this is a class that extends work done by Mark Crane
*/


/**
 * xml_cdr class provides methods for adding cdr records to the database
 *
 * @method boolean add
 */
if (!class_exists('xml_cdr')) {
	require_once $_SERVER["DOCUMENT_ROOT"] . PROJECT_PATH . '/app/xml_cdr/resources/classes/xml_cdr.php';

}

require_once $_SERVER["DOCUMENT_ROOT"] . PROJECT_PATH . '/app/fusionpbx-enhanced-cdr-importer/resources/classes/xml_import_plugin_template.php';

class enhanced_xml_cdr extends xml_cdr {

	private $plugins;

	public function __construct() {
		parent::__construct();

		// Look for plugins, here is where the magic starts
		$plg = glob($_SERVER["DOCUMENT_ROOT"] . PROJECT_PATH . '/app/fusionpbx-enhanced-cdr-importer/resources/plugins/*.php'); /* Fixes the coloring :) */
		$this->plugins = array();

		foreach ($plg as &$class_file) {
			if (!class_exists($class_name)) {
				include_once $class_file;
				$class_name = basename($class_file, '.php');
				$this->plugins[$class_name] = new $class_name;
			}
		}

		unset ($plg);
	}

	public function fields() {
		parent::fields();

		foreach ($this->plugins as $p){
			if (method_exists($p, 'fields')){
				$p->fields();
			}
		}
	}

	public function xml_array($row, $leg, $xml_string) {
		parent::xml_array($row, $leg, $xml_string);

		foreach ($this->plugins as $p){
			if (method_exists($p, 'xml_array')){
				$p->xml_array($row, $leg, $xml_string);
			}
		}
	}

	public function read_files(){
		parent::read_files();

		foreach ($this->plugins as $p){
			if (method_exists($p, 'read_files')){
				$p->read_files($this->array);
			}
		}
	}

	public function post(){
		parent::post();

		foreach ($this->plugins as $p){
			if (method_exists($p, 'post')){
				$p->post($this->array);
			}
		}
	}
}
/*
//example use
	$cdr = new xml_cdr;
	$cdr->read_files();
*/
?>
