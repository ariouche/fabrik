<?php
/**
 * Slideshow vizualization: view
 *
 * @package     Joomla.Plugin
 * @subpackage  Fabrik.visualization.slideshow
 * @copyright   Copyright (C) 2005-2015 fabrikar.com - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

namespace Fabrik\Plugins\Visualization\Slideshow\Views;

// No direct access
defined('_JEXEC') or die('Restricted access');

use Fabrik\Helpers\Html as HtmlHelper;
use Fabrik\Helpers\Text;
use \JFactory;
use \JHtml;
use \JViewLegacy;
use \JComponentHelper;

/**
 * Fabrik Slideshow Viz HTML View
 *
 * @package     Joomla.Plugin
 * @subpackage  Fabrik.visualization.timeline
 * @since       3.0
 */
class Html extends JViewLegacy
{
	/**
	 * Execute and display a template script.
	 *
	 * @param   string $tpl The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise a JError object.
	 */

	public function display($tpl = 'default')
	{
		$app         = JFactory::getApplication();
		$input       = $app->input;
		$srcs        = HtmlHelper::framework();
		$model       = $this->getModel();
		$usersConfig = JComponentHelper::getParams('com_fabrik');
		$model->setId($input->getInt('id', $usersConfig->get('visualizationid', $input->getInt('visualizationid', 0))));
		$this->row = $model->getVisualization();

		if (!$model->canView())
		{
			echo Text::_('JERROR_ALERTNOAUTHOR');

			return false;
		}

		$this->js             = $this->get('JS');
		$params               = $model->getParams();
		$this->params         = $params;
		$this->showFilters    = $model->showFilters();
		$this->filters        = $this->get('Filters');
		$this->filterFormURL  = $this->get('FilterFormURL');
		$this->params         = $model->getParams();
		$this->containerId    = $this->get('ContainerId');
		$srcs['FbListFilter'] = 'media/com_fabrik/js/listfilter.js';

		if ($this->get('RequiredFiltersFound'))
		{
			$srcs['Slideshow2'] = 'components/com_fabrik/libs/slideshow2/js/slideshow.js';
			$mode               = $params->get('slideshow_viz_type', 1);

			switch ($mode)
			{
				case 1:
					break;
				case 2:
					$srcs['Kenburns'] = 'components/com_fabrik/libs/slideshow2/js/slideshow.kenburns.js';
					break;
				case 3:
					$srcs['Push'] = 'components/com_fabrik/libs/slideshow2/js/slideshow.push.js';
					break;
				case 4:
					$srcs['Fold'] = 'components/com_fabrik/libs/slideshow2/js/slideshow.fold.js';
					break;
				default:
					break;
			}

			JHtml::stylesheet('components/com_fabrik/libs/slideshow2/css/slideshow.css');
			$srcs['SlideShow'] = 'plugins/fabrik_visualization/Slideshow/slideshow.js';
		}

		HtmlHelper::slimbox();
		HtmlHelper::iniRequireJs($model->getShim());
		HtmlHelper::script($srcs, $this->js);

		$tpl      = $params->get('slideshow_viz_layout', 'bootstrap');
		$tmplPath = $model->pathBase . 'Slideshow/Views/Slideshow/tmpl/' . $tpl;
		$this->_setPath('template', $tmplPath);
		HtHtmlHelperml::stylesheetFromPath('plugins/fabrik_visualization/Slideshow/Views/Slideshow/tmpl/' . $tpl . '/template.css');
		HtmlHelper::stylesheetFromPath('plugins/fabrik_visualization/Slideshow/Views/Slideshow/tmpl/' . $tpl . '/custom.css');
		echo parent::display();
	}
}