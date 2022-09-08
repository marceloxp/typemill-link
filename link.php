<?php
namespace Plugins\link;

use \Typemill\Plugin;

class link extends Plugin
{
  # [:link text="Google" id="link-google" class="my-custom-class" target="_blank" url="https://google.com.br/":]
  # [:link text="Google" id="link-google" target="_blank" url="https://google.com.br/":]
  # [:link text="Google" target="_blank" url="https://google.com.br/":]
  # [:link text="Google" target="_blank" url="https://google.com.br/":]
  # [:link text="Google" url="https://google.com.br/":]
  # [:link text="Google":]
  protected $settings;

  # listen to the shortcode event
  public static function getSubscribedEvents()
  {
    return array(
      'onShortcodeFound' => 'onShortcodeFound',
      'onTwigLoaded' => 'onTwigLoaded',
    );
  }

  public function onTwigLoaded()
  {
    $this->addCSS('/link/public/css/style.css');
  }

  # if typemill found a shortcode and fires the event
  public function onShortcodeFound($shortcode)
  {
    # read the data of the shortcode
    $shortcodeArray = $shortcode->getData();

    if(is_array($shortcodeArray) && $shortcodeArray['name'] == 'registershortcode')
    {
        $shortcode->setData($shortcodeArray);
    }

    // var_dump($shortcodeArray);
    # check if it is the shortcode name that we where looking for
    if(is_array($shortcodeArray) && $shortcodeArray['name'] == 'link')
    {
      try {
        # we found our shortcode, so stop firing the event to other plugins
        $shortcode->stopPropagation();

        $params = $shortcodeArray['params'];

        $classes = [];
        $target = isset($params['target']) ? $params['target'] : '_self';
        $class = isset($params['class']) ? $params['class'] : '';
        $text = isset($params['text']) ? $params['text'] : 'Link';
        $url = isset($params['url']) ? $params['url'] : '#';
         
        // create string $class variable from params if target is set to _blank
        if (!empty($class)) {
          $classes[] = $class;
        }
        if ($target === '_blank') {
          $classes[] = 'external';
        }
        $class = sprintf('class="%s"', implode(' ', $classes));
        
        unset($params['text']);
        unset($params['class']);
        unset($params['target']);
        unset($params['url']);

        if (!empty($params)) {
          $params = array_map(function($key, $value) {
            return sprintf('%s="%s"', $key, $value);
          }, array_keys($params), $params);
          $params = implode(' ', $params);
        } else {
          $params = '';
        }

        $html = '<a ' . $params . ' ' . $class . ' href="' . $url . '" target="' . $target . '">' . $text . '</a>';

        # and return a html-snippet that replaces the shortcode on the page.
        $shortcode->setData($html);
      } catch (\Throwable $th) {
        throw $th;
      }
    }
  }
}
