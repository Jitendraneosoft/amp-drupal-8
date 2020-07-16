<?php

namespace Drupal\schema_metatag;

use Drupal\Component\Utility\Random;

/**
 * Class SchemaMetatagManager.
 *
 * @package Drupal\schema_metatag
 */
class SchemaMetatagManager implements SchemaMetatagManagerInterface {

  /**
   * {@inheritdoc}
   */
  public static function parseJsonld(array &$elements) {
    // Elements are in indeterminable order.
    // First time through, collect and nest by group.
    $schema_metatags = [];
    foreach ($elements as $key => $item) {
      if (!empty($item[0]['#attributes']['schema_metatag'])) {
        $group = $item[0]['#attributes']['group'];
        // Nest items by the group they are in.
        $name = $item[0]['#attributes']['name'];
        $content = $item[0]['#attributes']['content'];
        $schema_metatags[$group][$name] = $content;
        unset($elements[$key]);
      }
    }
    // Second time through, replace group name with index,
    // and add JSON LD wrappers.
    $items = [];
    $group_key = 0;
    foreach ($schema_metatags as $group_name => $data) {
      if (empty($items)) {
        $items['@context'] = 'https://schema.org';
      }
      if (!empty($data)) {
        $items['@graph'][$group_key] = $data;
      }
      $group_key++;
    }
    return $items;
  }

  /**
   * {@inheritdoc}
   */
  public static function encodeJsonld(array $items) {
    // If some group has been found, render the JSON LD,
    // otherwise return nothing.
    if (!empty($items)) {
      return json_encode($items, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE);
    }
    else {
      return '';
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function renderArrayJsonLd($jsonld) {
    return [
      '#type' => 'html_tag',
      '#tag' => 'script',
      '#value' => $jsonld,
      '#attributes' => ['type' => 'application/ld+json'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function getRenderedJsonld($entity = NULL, $entity_type = NULL) {
    // If nothing was passed in, assume the current entity.
    // @see schema_metatag_entity_load() to understand why this works.
    if (empty($entity)) {
      $entity = metatag_get_route_entity();
    }
    // Get all the metatags for this entity.
    $metatag_manager = \Drupal::service('metatag.manager');
    if (!empty($entity) && $entity instanceof ContentEntityInterface) {
      foreach ($metatag_manager->tagsFromEntity($entity) as $tag => $data) {
        $metatags[$tag] = $data;
      }
    }
    // Trigger hook_metatags_alter().
    // Allow modules to override tags or the entity used for token replacements.
    $context = ['entity' => $entity];
    \Drupal::service('module_handler')->alter('metatags', $metatags, $context);
    $elements = $metatag_manager->generateElements($metatags, $entity);

    // Parse the Schema.org metatags out of the array.
    if ($items = self::parseJsonld($elements)) {
      // Encode the Schema.org metatags as JSON LD.
      if ($jsonld = self::encodeJsonld($items)) {
        // Pass back the rendered result.
        return \Drupal::service('renderer')->render(self::renderArrayJsonLd($jsonld));
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function pivot($content) {
    if (!is_array($content) || empty($content)) {
      return $content;
    }
    // Figure out the maximum number of items to include in the pivot.
    // Nested associative arrays should be excluded, only count numeric arrays.
    $count = max(array_map([__CLASS__, 'countNumericKeys'], $content));
    $pivoted = [];
    $exploded = [];
    $keys = array_keys($content);
    for ($i = 0; $i < $count; $i++) {
      foreach ($content as $key => $item) {
        // If a lower array is pivoted, pivot that first.
        if (is_array($item) && array_key_exists('pivot', $item)) {
          unset($item['pivot']);
          $item = self::pivot($item);
        }
        // Some properties, like @type, may need to repeat the first item,
        // others may have too few values to fill out the array.
        // Make sure all properties have the right number of values.
        if (is_string($item) || (!is_string($item) && self::countNumericKeys($item) <= $count)) {
          $exploded[$key] = [];
          $prev = '';
          for ($x = 0; $x < $count; $x++) {
            if (!is_string($item) && self::countNumericKeys($item) > $x) {
              $exploded[$key][$x] = $item[$x];
              $prev = $item[$x];
            }
            elseif (!is_string($item) && self::countNumericKeys($item) > 0) {
              $exploded[$key][$x] = $prev;
            }
            else {
              $exploded[$key][$x] = $item;
            }
          }
          $pivoted[$i][$key] = $exploded[$key][$i];
        }
        else {
          $pivoted[$i][$key] = $item;
        }
      }
    }
    return $pivoted;
  }

  /**
   * If the item is an array with numeric keys, count the keys.
   */
  public static function countNumericKeys($item) {
    if (!is_array($item)) {
      return 0;
    }
    foreach (array_keys($item) as $key) {
      if (!is_numeric($key)) {
        return 0;
      }
    }
    return count($item);
  }

  /**
   * {@inheritdoc}
   */
  public static function explode($value) {
    $value = explode(',', $value);
    $value = array_map('trim', $value);
    //$value = array_unique($value);
    if (count($value) == 1) {
      return $value[0];
    }

    return $value;
  }

  /**
   * {@inheritdoc}
   */
  public static function serialize($value) {
    // Make sure the same value isn't serialized more than once if this is
    // called multiple times.
    if (is_array($value)) {
      // Don't serialize an empty array.
      // Otherwise Metatag won't know the field is empty.
      $trimmed = self::arrayTrim($value);
      if (empty($trimmed)) {
        return '';
      }
      else {
        $value = serialize($trimmed);
      }
    }
    return $value;
  }

  /**
   * {@inheritdoc}
   */
  public static function unserialize($value) {
    // Make sure the the value is not just a plain string and that
    // the same value isn't unserialized more than once if this is called
    // multiple times.
    if (self::isSerialized($value)) {
      // If a line break made it into the serialized array, it can't be
      // unserialized.
      $value = str_replace("\n", "", $value);
      // Fix problems created if token replacements are a different size
      // than the original tokens.
      $value = self::recomputeSerializedLength($value);
      // Keep broken unserialization from throwing errors on the page.
      if ($value = @unserialize($value)) {
        $value = self::arrayTrim($value);
      }
      else {
        // Fail safe if unserialization is broken.
        $value = [];
      }
    }
    return $value;
  }

  /**
   * {@inheritdoc}
   */
  public static function isSerialized($value) {
    // If it isn't a string, it isn't serialized.
    if (!is_string($value)) {
      return FALSE;
    }
    $data = trim($value);
    if ('N' == $value) {
      return TRUE;
    }
    if (!preg_match('/^([adObis]):/', $value, $badions)) {
      return FALSE;
    }
    switch ($badions[1]) {
      case 'a':
      case 'O':
      case 's':
        if (preg_match("/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $value)) {
          return TRUE;
        }
        break;

      case 'b':
      case 'i':
      case 'd':
        if (preg_match("/^{$badions[1]}:[0-9.E-]+;\$/", $value)) {
          return TRUE;
        }
        break;

    }
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public static function arrayTrim($array) {

    // See if this is an array or an object.
    $needs_type = static::isObject($array);

    foreach ($array as $key => &$value) {
      if (empty($value)) {
        unset($array[$key]);
      }
      else {
        if (is_array($value)) {
          $value = static::arrayTrim($value);
          if (empty($value)) {
            unset($array[$key]);
          }
        }
      }
    }

    // If all that's left is the pivot, return empty.
    if ($array == ['pivot' => 1]) {
      return [];
    }
    // If all that's left is @type, return empty.
    if (count($array) == 1 && key($array) == '@type') {
      return [];
    }
    // If this is an object but none of the values is @type or @id, return
    // empty.
    if ($needs_type && is_array($array) && !array_key_exists('@type', $array) && !array_key_exists('@id', $array)) {
      return [];
    }
    // Otherwise return the cleaned up array.
    return (array) $array;
  }

  /**
   * {@inheritdoc}
   */
  public static function isObject($array) {
    return empty(static::countNumericKeys($array));
  }

  /**
   * {@inheritdoc}
   */
  public static function recomputeSerializedLength($value) {
    $value = preg_replace_callback('!s:(\d+):"(.*?)";!', function ($match) {
      return ($match[1] == strlen($match[2])) ? $match[0] : 's:' . strlen($match[2]) . ':"' . $match[2] . '";';
    }, $value);
    return $value;
  }

  /**
   * {@inheritdoc}
   */
  public static function randomString($length = 8) {
    $randomGenerator = new Random();
    if ($length < 4) {
      return $randomGenerator->string($length, TRUE);
    }
    // Swap special characters into the string.
    $replacement_pos = floor($length / 2);
    $string = $randomGenerator->string($length - 2, TRUE);
    return substr_replace($string, '>&', $replacement_pos, 0);
  }

  /**
   * {@inheritdoc}
   */
  public static function randomMachineName($length = 8) {
    $randomGenerator = new Random();
    return $randomGenerator->name($length, TRUE);
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultInputValues() {
    return [
      'title' => '',
      'description' => '',
      'value' => [],
      '#required' => FALSE,
      'visibility_selector' => '',
      'actionTypes' => [],
      'actions' => [],
    ];
  }

  /**
   * Alternate visibility selector for the field element.
   *
   * This is necessary because the form elements on the general configuration
   * form have different parents than the form elements in the metatags field
   * widget. This function makes is possible to convert the #states visibility
   * selectors for the general configuration form into the right pattern
   * so they will work on the field widget.
   *
   * @param string $selector
   *   The selector constructed for the main metatag form.
   * @param string $group
   *   The group this part of the form belongs in.
   * @param string $id
   *   The id of the individual element.
   *
   * @return string
   *   A rewritten selector that will work in the field form.
   */
  public static function altSelector($selector) {

    $metatag_manager = \Drupal::service('metatag.manager');
    $metatag_groups = $metatag_manager->sortedGroupsWithTags();

    $group = '';
    $matches = [];
    $regex = '/:input\[name="(\w+)\[/';
    preg_match($regex, $selector, $matches);
    $id = $matches[1];
    foreach ($metatag_groups as $group_name => $group_info) {
      if (!empty($group_info['tags'])) {
        if (array_key_exists($id, $group_info['tags'])) {
          $tag = $group_info['tags'][$id];
          $group = $tag['group'];
          break;
        }
      }
    }
    // Original pattern, general configuration form:
    // - schema_web_page_publisher[@type]
    // Alternate pattern, field widget form:
    // - field_metatags[0][schema_web_page][schema_web_page_publisher][@type]
    $original = $id . '[';
    $alternate = 'field_metatags[0][' . $group . '][' . $id . '][';
    $new = str_replace($original, $alternate, $selector);
    return $new;
  }

}
