<?php

namespace Drupal\amp_cts\EventSubscriber;

use Drupal\amp\Routing\AmpContext;
use Drupal\amp_cts\Render\AmpCssTreeShakingHtmlResponseProcessor;
use Drupal\Core\DependencyInjection\ServiceProviderBase;
use Drupal\Core\Render\HtmlResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Response subscriber to handle amp css tree shaking responses.
 */
class AmpCssTreeShakingHtmlResponseSubscriber extends ServiceProviderBase implements EventSubscriberInterface {

  /**
   * The AMP CSS Tree Shaking response processor service.
   *
   * @var \Drupal\amp_cts\Render\AmpCssTreeShakingHtmlResponseProcessor
   */
  protected $ampCssTreeShakingHtmlResponseProcessor;

  /**
   * The route amp context to determine whether a route is an amp one.
   *
   * @var \Drupal\amp\Routing\AmpContext
   */
  protected $ampContext;

  /**
   * Constructs an AmpCssTreeShakingHtmlResponseSubscriber object.
   *
   * @param \Drupal\amp_cts\Render\AmpCssTreeShakingHtmlResponseProcessor $amp_cts_html_response_processor
   *   AMP CSS Tree Shaking HTML Processor.
   * @param \Drupal\amp\Routing\AmpContext $amp_context
   *   AMP routing context.
   */
  public function __construct(AmpCssTreeShakingHtmlResponseProcessor $amp_cts_html_response_processor, AmpContext $amp_context) {
    $this->ampCssTreeShakingHtmlResponseProcessor = $amp_cts_html_response_processor;
    $this->ampContext = $amp_context;
  }

  /**
   * Processes markup for HtmlResponse responses.
   *
   * @param \Symfony\Component\HttpKernel\Event\FilterResponseEvent $event
   *   The event to process.
   */
  public function onRespond(FilterResponseEvent $event) {
    $response = $event->getResponse();

    if (!$response instanceof HtmlResponse) {
      return;
    }

    if ($this->ampContext->isAmpRoute()) {
      try {
        $newResponse = $this->ampCssTreeShakingHtmlResponseProcessor->processCssTreeShaking($response);
        $event->setResponse($newResponse);
      }
      catch (\Exception $e) {
        // Do nothing, origin response will be used.
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    // We want to run this as late as possible,
    // after the HTML has been modified by all the Response listeners.
    $events[KernelEvents::RESPONSE][] = ['onRespond', -2048];
    return $events;
  }

}
