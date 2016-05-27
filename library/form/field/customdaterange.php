<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Fsdb
 * @author     Carlos Cámara <carlos@joomladesigner.com>
 * @copyright  2016 Joomla Design Studios INC
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');

/**
 * Supports a value from an external table
 *
 * @since  1.6
 */
class HeptaFormFieldCustomDateRange extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var      string
	 * @since    1.6
	 */
	protected $type = 'hepta.CustomDateRange';

	private $table;

	private $key_field;

	private $value_field;

	public function getInput() {

		
		JHtml::script('hepta/formfields/vendor/momentjs/moment.min.js', true, true, false, false, false);
		JHtml::script('hepta/formfields/vendor/daterangepicker/daterangepicker.js', true, true, false, false, true);
		JHtml::stylesheet('hepta/formfields/vendor/daterangepicker/daterangepicker.css', array(), true, false, false, true);

		$html = '<input type="text" name="' . $this->name . '" value="' . $this->value .'" placeholder="' . JText::_($this->hint) . '" />';

		$script[] = 'jQuery(document).ready(function(){';
		$script[] = 'jQuery(\'input[name="' . $this->name . '"]\').daterangepicker({
    "dateLimit": {
        "days": 7
    },
    "ranges": {
        "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_TODAY") . '":[
			moment(),
			moment()
			],
        "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_YESTERDAY") . '": [
			moment().subtract(1, \'days\'),
			moment().subtract(1, \'days\')
			],
        "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_PAST_WEEK") . '": [
			moment().subtract(1, \'weeks\').startOf(\'isoWeek\'),
			moment().subtract(1, \'weeks\').endOf(\'isoWeek\')
			],
        "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_PAST_MONTH") . '": [
            moment().subtract(1, \'month\').startOf(\'month\'),
            moment().subtract(1, \'month\').endOf(\'month\')
        ],
        "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_PRIOR_MONTH") . '": [
            moment().subtract(2, \'month\').startOf(\'month\'),
            moment().subtract(2, \'month\').endOf(\'month\')
        ],
        "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_PAST_QUARTER") . '": [
            moment().subtract(1, \'quarter\').startOf(\'quarter\'),
            moment().subtract(1, \'quarter\').endOf(\'quarter\')
        ],
        "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_PRIOR_QUARTER") . '": [
            moment().subtract(2, \'quarter\').startOf(\'quarter\'),
            moment().subtract(2, \'quarter\').endOf(\'quarter\')
        ]
    },
    "locale": {
        "format": "YYYY/MM/DD",
        "separator": " - ",
        "applyLabel": "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_APPLY") . '",
        "cancelLabel": "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_CLEAR") . '",
        "fromLabel": "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_FROM") . '",
        "toLabel": "To",
        "customRangeLabel": "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_CUSTOM") . '",
        "daysOfWeek": [
            "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_SUNDAY_SHORT") . '",
            "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_MONDAY_SHORT") . '",
            "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_TUESDAY_SHORT") . '",
            "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_WEDNESDAY_SHORT") . '",
            "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_THURSDAY_SHORT") . '",
            "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_FRIDAY_SHORT") . '",
            "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_SATURDAY_SHORT") . '"
        ],
        "monthNames": [
            "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_JANUARY") . '",
            "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_FEBRUARY") . '",
            "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_MARCH") . '",
            "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_APRIL") . '",
            "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_MAY") . '",
            "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_JUNE") . '",
            "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_JULY") . '",
            "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_AUGUST") . '",
            "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_SEPTEMBER") . '",
            "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_OCTOBER") . '",
            "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_NOVEMBER") . '",
            "' . JText::_("LIB_HEPTA_FORM_FIELDS_CUSTOMDATE_DECEMBER") . '"
        ],
        "firstDay": 1
    },
    "linkedCalendars": false,
    "autoUpdateInput": false,
    "opens": "center",
    "buttonClasses": "uk-button",
    "applyClass": "uk-button uk-button-primary"
});';

		

		$script[] = 'jQuery(\'input[name="' . $this->name . '"]\').on(\'cancel.daterangepicker\', function(ev, picker) {
      jQuery(this).val(\'\');
  });';
		$script[] = 'jQuery(\'input[name="' . $this->name . '"]\').on(\'apply.daterangepicker\', function(ev, picker) {
      jQuery(this).val(picker.startDate.format(\'YYYY/MM/DD/\') + " - " + picker.endDate.format(\'YYYY/MM/DD\'));
  });';
$script[] = '});';
		JFactory::getDocument()->addScriptDeclaration(implode(' ',$script));

		return $html;

	}

	private function getConfiguration()
	{
		$configuration = array();
		
		return $configuration;
	}

	/**
	 * Wrapper method for getting attributes from the form element
	 *
	 * @param   string  $attr_name  Attribute name
	 * @param   mixed   $default    Optional value to return if attribute not found
	 *
	 * @return mixed The value of the attribute if it exists, null otherwise
	 */
	public function getAttribute($attr_name, $default = null)
	{
		if (!empty($this->element[$attr_name]))
		{
			return $this->element[$attr_name];
		}
		else
		{
			return $default;
		}
	}
}
