<?php
/**
 * @copyright   Copyright (C) 2017 Cory Webb Media, LLC. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::register('FieldsHelper', JPATH_ADMINISTRATOR . '/components/com_fields/helpers/fields.php');

/**
 * Helper for mod_cw_fielddisplay
 */
class ModCwFieldDisplayHelper
{

	/**
	 * Custom field context
	 **/
	protected $context;

	/**
	 * Item (Article, category, contact, etc.)
	 */
	protected $item;

	/**
	 * Constructor
	 *
	 * @param   \Joomla\Registry\Registry  &$params  object holding the models parameters
	 */
	public function __construct(&$params)
	{
		$this->getContext($params);
		$this->getItem($params);
	}

	/**
	 * Get the field(s) to be displayed.
	 *
	 * @param   \Joomla\Registry\Registry  &$params  object holding the models parameters
	 *
	 * @return  array()
	 */
	public function getFields(&$params)
	{
		$app       = JFactory::getApplication();
		$option    = $app->input->get('option');
		$view      = $app->input->get('view');

		$context   = $this->getContext($params);
		$item      = $this->getItem($params);

		// Get all fields for context/item
		$fields    = FieldsHelper::getfields($context, $item, true);

		// Check if the admin filtered the list by field names
		$field_names = $params->get('fields', '');
		$fields_by_name = array();

		if ($field_names)
		{
			$field_names = explode(',', $field_names);

			foreach($fields as $field)
			{
				if (in_array($field->name, $field_names))
				{
					$fields_by_name[] = $field;
				}
			}
		}
		else
		{
			$fields_by_name = $fields;
		}

		// Check if the admin filtered the list by group IDs
		$field_groups = $params->get('fieldgroups', '');
		$return_fields = array();

		if ($field_groups)
		{
			$field_groups = explode(',', $field_groups);

			foreach ($fields_by_name as $field) {
				if (in_array($field->group_id, $field_groups))
				{
					$return_fields[] = $field;
				}
			}
		}
		else
		{
			$return_fields = $fields_by_name;
		}

		return $return_fields;
	}

	/**
	 * Get the custom field context.
	 *  Default contexts available in Joomla 3.7.x are:
	 *   com_content.article
	 *   com_content.categories
	 *   com_users.user
	 *   com_contact.contact
	 *   com_contact.categories
	 *
	 * @param   \Joomla\Registry\Registry  &$params  object holding the models parameters
	 *
	 * @return   string
	 */
	public function getContext(&$params)
	{
		// Return the context if it is already set
		if (!empty($this->context))
		{
			return $this->context;
		}

		if ($params->get('context', ''))
		{
			return $params->get('context');
		}

		$app    = JFactory::getApplication();
		$option = $app->input->getCmd('option', '');
		$view   = $app->input->getCmd('view', '');

		if ($view == 'category' || $view == 'category')
		{
			return $option . '.' . 'categories';
		}

		return $option . '.' . $view;
	}

	/**
	 * Get the item with which the custom fields are associated
	 *
	 * @param   \Joomla\Registry\Registry  &$params  object holding the models parameters
	 *
	 * @return   stdClass
	 */
	public function getItem(&$params)
	{
		// Return the item if it is already set
		if (!empty($this->item))
		{
			return $this->item;
		}

		$this->item = new stdClass();

		if ($params->get('item_id', 0))
		{
			$this->item->id = $params->get('item_id');
		}
		else
		{
			$app = JFactory::getApplication();

			$this->item->id = $app->input->getStr('id', 0);

			if (!is_numeric($this->item->id))
			{
				$id = explode(':', $this->item->id);
				$this->item->id = $id[0];
			}
		}

		$context = $this->getContext($params);

		if (strstr($context, 'categories'))
		{
			$this->item->catid = $this->item->id;
		}

		if ($context == 'com_users.user')
		{
			$this->item->id = JFactory::getUser()->id;
		}

		return $this->item;
	}


}
