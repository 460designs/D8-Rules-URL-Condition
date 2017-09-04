<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\Condition\UrlHasText.php
 */

namespace Drupal\rules\Plugin\Condition;

use Drupal\rules\Core\RulesConditionBase;
use Drupal\Core\Language\LanguageInterface;

/**
 * Provides a 'Url Has Text' condition.
 *
 * @Condition(
 *   id = "rules_url_has_text",
 *   label = @Translation("Url Has Text"),
 *   category = @Translation("Data"),
 *   context = {
 *     "operator" = @ContextDefinition("string",
 *       label = @Translation("Operator"),
 *       description = @Translation("The evaluation operator. One of 'contains', 'starts', 'ends', or 'regex'. Defaults to 'contains'."),
 *       default_value = "contains",
 *       required = FALSE
 *     ),
 *     "match" = @ContextDefinition("string",
 *        label = @Translation("Matching text"),
 *     )
 *   }
 * )
 *
 */

class UrlHasText extends RulesConditionBase {

  /**
   * Evaluate the url for text.
   *
   * @param mixed $url
   *   Current url.
   * @param string $operator
   *   Url evaluation operator. One of:
   *     - "contains"
   *     - "starts"
   *     - "ends"
   *     - "regex"
   *   Values that do not match one of these operators are defaulted to "contains"
   * @param mixed $text
   *   The string to be compared against $url.
   *
   * @return bool
   *   The evaluation of the condition.
   */
  protected function doEvaluate($url, $operator, $text) {
	$url = $this->currentPathStack->getPath();
    $operator = $operator ? $operator : 'contains';
    switch ($operator) {
      case 'starts':
        return strpos($url, $text) === 0;

      case 'ends':
        return strrpos($url, $text) === (strlen($url) - strlen($text));

      case 'regex':
        return (bool) preg_match('/'. str_replace('/', '\\/', $text) .'/', $url);

      default:
        
        return strpos($url, $text) !== FALSE;
    }
  }

}