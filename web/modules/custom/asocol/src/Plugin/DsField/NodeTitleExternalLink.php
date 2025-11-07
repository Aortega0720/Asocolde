<?php

namespace Drupal\asocol\Plugin\DsField;

use Drupal\Core\Template\Attribute;
use Drupal\Core\Url;
use Drupal\ds\Plugin\DsField\Node\NodeTitle;

/**
 * Plugin that renders the title of a node with external link.
 *
 * @DsField(
 *   id = "node_title_external link",
 *   title = @Translation("Title with external link"),
 *   entity_type = "node",
 *   provider = "node"
 * )
 */
class NodeTitleExternalLink extends NodeTitle {

  /**
   * Constructs a Display Suite field plugin.
   */
  public function __construct($configuration, $plugin_id, $plugin_definition) {
    // Set the title, used to construct the field label, based on the label
    // of the node type's title field.
    if (!empty($configuration['entity'])) {
      /* @var \Drupal\Core\Field\FieldDefinitionInterface $field */
      $field = $configuration['entity']->getFieldDefinition('title');
      $title = $field->getLabel();
      $configuration['field']['title'] = $title;
      $plugin_definition['title'] = $title;
    }

    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();

    // Initialize output.
    $output = '';

    // Basic string.
    $entity_render_key = $this->entityRenderKey();

    if (isset($config['link text'])) {
      $output = $this->t($config['link text']);
    }
    elseif (!empty($entity_render_key) && isset($this->entity()->{$entity_render_key})) {
      if ($this->getEntityTypeId() == 'user' && $entity_render_key == 'name') {
        $output = $this->entity()->getAccountName();
      }
      else {
        $output = $this->entity()->{$entity_render_key}->value;
      }
    }

    if (empty($output)) {
      return [];
    }

    $template = <<<TWIG
{% if wrapper %}
<{{ wrapper }}{{ attributes }}>
{% endif %}
{% if is_link %}
  {{ link(output, entity_url, link_attributes) }}
{% else %}
  {{ output }}
{% endif %}
{% if wrapper %}
</{{ wrapper }}>
{% endif %}
TWIG;

    // Sometimes it can be impossible to make a link to the entity, because it
    // has no id as it has not yet been saved, e.g. when previewing an unsaved
    // inline entity form.
    $is_link = FALSE;
    $entity_url = NULL;
    if (!empty($this->entity()->id())) {
      $is_link = !empty($config['link']) || !empty($config['mail_link']);

      if (!empty($config['mail_link'])) {
        $entity_url = Url::fromUri('mailto:' . $output);
      }
      else {
        $node = $this->entity();
        if ($node->field_url->isEmpty()) {
          $entity_url = $node->toUrl();
          $target = '_self';
        }
        else {
          $entity_url = $node->field_url[0]->getUrl();
          $target = '_blank';
        }
      }
      $classes = [];
      if (!empty($config['link class'])) {
        $classes = explode(' ', $config['link class']);
      }
      $entity_url->setOption('attributes', ['class' => $classes, 'target' => $target]);
    }

    // Build the attributes.
    $attributes = new Attribute();
    if (!empty($config['class'])) {
      $attributes->addClass($config['class']);
    }

    // Build the link attributes.
    $link_attributes = new Attribute();
    if (!empty($config['link']) && !empty($config['link class'])) {
      $link_attributes->addClass($config['link class']);
    }

    return [
      '#type' => 'inline_template',
      '#template' => $template,
      '#context' => [
        'is_link' => $is_link,
        'wrapper' => !empty($config['wrapper']) ? $config['wrapper'] : '',
        'attributes' => $attributes,
        'link_attributes' => $link_attributes,
        'entity_url' => $entity_url,
        'output' => $output,
      ],
    ];
  }

}
