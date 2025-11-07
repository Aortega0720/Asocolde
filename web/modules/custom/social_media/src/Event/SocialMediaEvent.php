<?php

namespace Drupal\social_media\Event;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class SocialMediaEvent.
 *
 * Dispatched when a social media element is being processed.
 */
class SocialMediaEvent extends Event {

  /**
   * The render array element.
   *
   * @var array
   */
  protected array $element;

  /**
   * Constructor.
   *
   * @param array $element
   *   The render array element to be processed.
   */
  public function __construct(array $element) {
    $this->element = $element;
  }

  /**
   * Gets the element.
   *
   * @return array
   *   The element.
   */
  public function getElement(): array {
    return $this->element;
  }

  /**
   * Sets the element.
   *
   * @param array $element
   *   The render array element to set.
   */
  public function setElement(array $element): void {
    $this->element = $element;
  }

}
