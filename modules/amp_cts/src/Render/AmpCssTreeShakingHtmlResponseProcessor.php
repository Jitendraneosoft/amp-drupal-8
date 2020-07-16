<?php

namespace Drupal\amp_cts\Render;

use Drupal\Core\DependencyInjection\ServiceProviderBase;
use Drupal\Core\Render\HtmlResponse;
use DrupalJedi\CssTreeShaking;

/**
 * Processes css tree shaking of HTML responses.
 */
class AmpCssTreeShakingHtmlResponseProcessor extends ServiceProviderBase {

  /**
   * Processes the content of a response.
   *
   * @param \Drupal\Core\Render\HtmlResponse $response
   *   The response to process.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   The processed response, with the content updated to amp markup.
   *
   * @throws \Exception
   *   Thrown when the $content wasn't shaked.
   *   the processor expects.
   */
  public function processCssTreeShaking(HtmlResponse $response) {
    $content = $response->getContent();

    try {
      $cssShaker = new CssTreeShaking($content);
      $content = $cssShaker->shakeIt(TRUE);
    }
    catch (\Exception $e) {
      \watchdog_exception('amp_cts', $e);
      throw new \Exception($e->getMessage(), $e->getCode(), $e);
    }

    $response->setContent($content);

    return $response;
  }

}
