<?php
/**
 * @copyright   Copyright (C) 2017 Cory Webb Media, LLC. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

if ($fields)
{
    // Render the selected fields with FieldsHelper::render
    echo FieldsHelper::render(
        $context,
        'fields.render',
        array(
            'item' => $item,
            'context' => $context,
            'fields' => $fields
        )
    );

    // Note: You can override this to render each field individually
    //  by looping through the '$fields' array. Each field in the array
    //  is a standard object, and has a "value" parameter and a "rawvalue"
    //  parameter. The "value" parameter is rendered through the field
    //  type's output layout, and the "rawvalue" parameter is the raw value
    //  entered for the field by the admin. You may also use FieldsHelper::render
    //  to render a single field using the following:
    //
    //  echo FieldsHelper::render(
    //      $context,
    //      'field.render',
    //      array(
    //          'field' => $field
    //      )
    //  );
    //
    //  This is assuming that '$field' is the variable you get when looping
    //   through the '$fields' array.
}
