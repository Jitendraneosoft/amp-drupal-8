<?php

namespace Drupal\schema_recipe\Plugin\metatag\Tag;

use Drupal\schema_metatag\Plugin\metatag\Tag\SchemaPersonOrgBase;

/**
 * Provides a plugin for the 'author' meta tag.
 *
 * - 'id' should be a globally unique id.
 * - 'name' should match the Schema.org element name.
 * - 'group' should match the id of the group that defines the Schema.org type.
 *
 * @MetatagTag(
 *   id = "schema_recipe_author",
 *   label = @Translation("author"),
 *   description = @Translation("RECOMMENDED BY GOOGLE. Author of the recipe."),
 *   name = "author",
 *   group = "schema_recipe",
 *   weight = 7,
 *   type = "string",
 *   secure = FALSE,
 *   multiple = TRUE
 * )
 */
class SchemaRecipeAuthor extends SchemaPersonOrgBase {

}
