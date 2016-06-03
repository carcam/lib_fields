<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Esubcontratacion
 * @author     Carlos <carlos@heptatechnologies.com>
 * @copyright  Copyright (C) 2015. Todos los derechos reservados.
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

/**
 * Supports an HTML select list of categories
 *
 * @since  1.6
 */
class HeptaFormFieldDropzone extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var        string
	 * @since    1.6
	 */
	protected $type = 'hepta.Dropzone';

	public function getInput()
	{
		JHtml::stylesheet('hepta/formfields/dropzone/dropzone-field.css', array(), true);
		JHtml::script("hepta/formfields/vendor/dropzone/dropzone.js", false, true, false,false, true);
		JHtml::script("hepta/formfields/dropzone-field.js", false, true, false,false, true);


		// Initialize some field attributes.
		$accept    = !empty($this->accept) ? ' accept="' . $this->accept . '"' : '';
		$size      = !empty($this->size) ? ' size="' . $this->size . '"' : '';
		$class     = !empty($this->class) ? ' class="' . $this->class . '"' : '';
		$disabled  = $this->disabled ? ' disabled' : '';
		$required  = $this->required ? ' required aria-required="true"' : '';
		$autofocus = $this->autofocus ? ' autofocus' : '';
		$multiple  = $this->multiple ? ' multiple' : '';

		$html = $this->getUploadZone();
		return $html;
	}

	protected function getUploadZone()
	{
		$zone = "";

		$zone .= '<div id="' . $this->id .'" class="filezone"></div>';

		$script = 'jQuery(document).ready(function(){'
					. 'jQuery("div#' . $this->id .'").dropzone({'
						. 'url: "/nothing", autoProcessQueue: false, '
						. 'uploadMultiple: true,'
						. 'parallelUploads:2, '
						. 'maxFiles: 2,'
						. 'maxfilesexceeded: function(file){this.removeFile(file);alert("max files");},'
					. '})'
				. '})';


		JFactory::getDocument()->addScriptDeclaration($script);

		return $zone;
	}
	
}
