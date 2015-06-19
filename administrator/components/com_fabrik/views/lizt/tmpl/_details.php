<?php
/**
 * Admin List Tmpl
 *
 * @package     Joomla.Administrator
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2015 fabrikar.com - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @since       3.0
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Fabrik\Helpers\Text;

?>
<div class="tab-pane active" id="detailsX">

	<ul class="nav nav-tabs">
		<li class="active">
			<a data-toggle="tab" href="#details-publishing">
				<?php echo Text::_('COM_FABRIK_TEXT'); ?>
			</a>
		</li>
		<li>
			<a data-toggle="tab" href="#details-filters">
				<?php echo Text::_('COM_FABRIK_FILTERS') ?>
			</a>
		</li>
		<li>
			<a data-toggle="tab" href="#details-nav">
				<?php echo Text::_('COM_FABRIK_NAVIGATION') ?>
			</a>
		</li>
		<li>
			<a data-toggle="tab" href="#details-layout">
				<?php echo Text::_('COM_FABRIK_LAYOUT') ?>
			</a>
		</li>
		<li>
			<a data-toggle="tab" href="#details-link">
				<?php echo Text::_('COM_FABRIK_LINKS') ?>
			</a>
		</li>
		<li>
			<a data-toggle="tab" href="#details-notes">
				<?php echo Text::_('COM_FABRIK_NOTES') ?>
			</a>
		</li>
		<li>
			<a data-toggle="tab" href="#details-advanced">
				<?php echo Text::_('COM_FABRIK_ADVANCED') ?>
			</a>
		</li>
	</ul>

	<div class="tab-content">

		<div class="tab-pane" id="details-filters">
			<fieldset class="form-horizontal">
				<?php
				foreach ($this->form->getFieldset('main_filter') as $this->field) :
					require '_control_group.php';
				endforeach;
				foreach ($this->form->getFieldset('filters') as $this->field) :
					require '_control_group.php';
				endforeach;
				?>
			</fieldset>
		</div>

		<div class="tab-pane active" id="details-publishing">
			<fieldset class="form-horizontal">
				<?php foreach ($this->form->getFieldset('main') as $this->field) :
					require '_control_group.php';
				endforeach;
				?>
				<?php foreach ($this->form->getFieldset('details2') as $this->field) :
					require '_control_group.php';
				endforeach;
				?>
			</fieldset>
		</div>

		<div class="tab-pane" id="details-nav">
			<fieldset class="form-horizontal">
				<?php
				foreach ($this->form->getFieldset('main_nav') as $this->field) :
					require '_control_group.php';
				endforeach;
				foreach ($this->form->getFieldset('navigation') as $this->field) :
					require '_control_group.php';
				endforeach;
				?>
			</fieldset>
		</div>

		<div class="tab-pane" id="details-layout">
			<fieldset class="form-horizontal">
				<?php

				?>
			</fieldset>

			<fieldset class="form-horizontal">
				<div class="row-fluid">
					<div class="span6">
						<legend><?php echo Text::_('COM_FABRIK_TEMPLATES') ?></legend>
						<?php
						foreach ($this->form->getFieldset('main_template') as $this->field) :
							require '_control_group.php';
						endforeach;
						foreach ($this->form->getFieldset('layout') as $this->field) :
							require '_control_group.php';
						endforeach;
						?>
					</div>
					<div class="span6">
						<legend><?php echo Text::_('COM_FABRIK_PDF') ?></legend>
						<?php
						foreach ($this->form->getFieldset('pdf') as $this->field) :
							require '_control_group.php';
						endforeach;
						?>
					</div>
				</div>
			</fieldset>

			<fieldset class="form-horizontal">
				<div class="row-fluid">
					<div class="span6">
						<legend><?php echo Text::_('COM_FABRIK_BOOTSTRAP_LIST_OPTIONS') ?></legend>
						<?php
						foreach ($this->form->getFieldset('layout-bootstrap') as $this->field) :
							require '_control_group.php';
						endforeach;
						?>
					</div>
					<div class="span6">
						<legend><?php echo Text::_('COM_FABRIK_TABS') ?></legend>
						<?php
						foreach ($this->form->getFieldset('tabs') as $this->field) :
							require '_control_group.php';
						endforeach;
						?>
					</div>
				</div>
			</fieldset>
		</div>

		<div class="tab-pane" id="details-link">
			<div class="row-fluid">
				<div class="span8">
					<fieldset class="form-horizontal">
						<?php foreach ($this->form->getFieldset('links') as $this->field) :
							require '_control_group.php';
						endforeach;
						?>
					</fieldset>
				</div>
				<div class="span4">
					<fieldset class="form-horizontal">
						<?php foreach ($this->form->getFieldset('links2') as $this->field) :
							require '_control_group.php';
						endforeach;
						?>
					</fieldset>
				</div>
			</div>

		</div>

		<div class="tab-pane" id="details-notes">
			<fieldset class="form-horizontal">
				<?php foreach ($this->form->getFieldset('notes') as $this->field) :
					require '_control_group.php';
				endforeach;
				?>
			</fieldset>
		</div>

		<div class="tab-pane" id="details-advanced">
			<fieldset class="form-horizontal">
				<?php foreach ($this->form->getFieldset('advanced') as $this->field) :
					require '_control_group.php';
				endforeach;
				?>
			</fieldset>
		</div>
	</div>
</div>