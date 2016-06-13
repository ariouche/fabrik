<?php
/**
 * Fabrik Admin Home Page View
 *
 * @package     Joomla.Administrator
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2015 fabrikar.com - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Fabrik\Helpers\Admin\Admin;
use Fabrik\Helpers\Html;
use Fabrik\Helpers\Worker;

jimport('joomla.application.component.view');

/**
 * Fabrik Admin Home Page View
 *
 * @package     Joomla.Administrator
 * @subpackage  Fabrik
 * @since       3.0
 */
class FabrikAdminViewHome extends JViewLegacy
{
	/**
	 * Recently logged activity
	 * @var  array
	 */
	protected $logs;

	/**
	 * RSS feed
	 * @var  array
	 */
	protected $feed;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  template
	 *
	 * @return  void
	 */
	public function display($tpl = null)
	{
		$srcs = Html::framework();
		Html::script($srcs);
		$db = Worker::getDbo(true);
		$query = $db->getQuery(true);
		$query->select('*')->from('#__{package}_log')->where('message_type != ""')->order('timedate_created DESC');
		$db->setQuery($query, 0, 10);
		$this->logs = $db->loadObjectList();
		$this->feed = $this->get('RSSFeed');
		$this->addToolbar();
		Admin::addSubmenu('home');
		Admin::setViewLayout($this);
		$this->sidebar = JHtmlSidebar::render();

		FabrikHelperHTML::iniRequireJS();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 */
	protected function addToolbar()
	{
		$canDo = JHelperContent::getActions('com_fabrik');

		if ($canDo->get('core.admin'))
		{
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_fabrik');
		}
	}
}
