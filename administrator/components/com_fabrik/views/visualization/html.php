<?php
/**
 * View to edit a visualization.
 *
 * @package     Joomla.Administrator
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2015 fabrikar.com - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

namespace Fabrik\Admin\Views\Visualization;

// No direct access
defined('_JEXEC') or die('Restricted access');

use \Fabrik\Helpers\HTML as HelperHTML;
use \JFactory as JFactory;
use Fabrik\Admin\Helpers\Fabrik;
use Fabrik\Helpers\Text;
use \JToolBarHelper as JToolBarHelper;
use \stdClass as stdClass;

/**
 * View to edit a visualization.
 *
 * @package     Joomla.Administrator
 * @subpackage  Fabrik
 * @since       3.5
 */
class Html extends \Fabrik\Admin\Views\Html
{
	/**
	 * Form
	 *
	 * @var JForm
	 */
	protected $form;

	/**
	 * Visualization item
	 *
	 * @var JTable
	 */
	protected $item;

	/**
	 * View state
	 *
	 * @var object
	 */
	protected $state;

	/**
	 * Plugin HTML
	 * @var string
	 */
	protected $pluginFields;

	/**
	 * Render the view
	 *
	 * @return  string
	 */
	public function render()
	{
		// Initialise variables.
		$this->form = $this->model->getForm();
		$this->item = $this->model->getItem();
		$this->state = $this->model->getState();
		$this->pluginFields = $this->model->getPluginHTML();

		$this->addToolbar();

		$srcs = HelperHTML::framework();
		$srcs[] = 'media/com_fabrik/js/fabrik.js';
		$srcs[] = 'administrator/components/com_fabrik/views/namespace.js';
		$srcs[] = 'administrator/components/com_fabrik/views/pluginmanager.js';
		$srcs[] = 'administrator/components/com_fabrik/views/visualization/adminvisualization.js';

		$shim = array();
		$dep = new stdClass;
		$dep->deps = array('admin/pluginmanager');
		$shim['admin/visualization/adminvisualization'] = $dep;

		HelperHTML::iniRequireJS($shim);

		$opts = new stdClass;
		$opts->plugin = $this->item->plugin;

		$js = "
	var options = " . json_encode($opts) . ";
		Fabrik.controller = new AdminVisualization(options);
";

		HelperHTML::script($srcs, $js);

		return parent::render();
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 *
	 * @return  null
	 */

	protected function addToolbar()
	{
		$app = JFactory::getApplication();
		$app->input->set('hidemainmenu', true);
		$user = JFactory::getUser();
		$isNew = ($this->item->id == 0);
		$userId = $user->get('id');
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
		$canDo = Fabrik::getActions($this->state->get('filter.category_id'));
		$title = $isNew ? Text::_('COM_FABRIK_MANAGER_VISUALIZATION_NEW') : Text::_('COM_FABRIK_MANAGER_VISUALIZATION_EDIT');
		$title .= $isNew ? '' : ' "' . $this->item->label . '"';
		JToolBarHelper::title($title, 'visualization.png');

		if ($isNew)
		{
			// For new records, check the create permission.
			if ($canDo->get('core.create'))
			{
				JToolBarHelper::apply('visualization.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('visualization.save', 'JTOOLBAR_SAVE');
				JToolBarHelper::addNew('visualization.save2new', 'JTOOLBAR_SAVE_AND_NEW');
			}

			JToolBarHelper::cancel('visualization.cancel', 'JTOOLBAR_CANCEL');
		}
		else
		{
			// Can't save the record if it's checked out.
			if (!$checkedOut)
			{
				// Since it's an existing record, check the edit permission, or fall back to edit own if the owner.
				if ($canDo->get('core.edit') || ($canDo->get('core.edit.own') && $this->item->created_by == $userId))
				{
					JToolBarHelper::apply('visualization.apply', 'JTOOLBAR_APPLY');
					JToolBarHelper::save('visualization.save', 'JTOOLBAR_SAVE');

					// We can save this record, but check the create permission to see if we can return to make a new one.
					if ($canDo->get('core.create'))
					{
						JToolBarHelper::addNew('visualization.save2new', 'JTOOLBAR_SAVE_AND_NEW');
					}
				}
			}

			if ($canDo->get('core.create'))
			{
				JToolBarHelper::custom('visualization.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
			}

			JToolBarHelper::cancel('visualization.cancel', 'JTOOLBAR_CLOSE');
		}

		JToolBarHelper::divider();
		JToolBarHelper::help('JHELP_COMPONENTS_FABRIK_VISUALIZATIONS_EDIT', false, Text::_('JHELP_COMPONENTS_FABRIK_VISUALIZATIONS_EDIT'));
	}
}