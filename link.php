<?php
namespace Plugins\link;

use \Typemill\Plugin;

class link extends Plugin
{
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
    if(!$this->adminpath)
    {
        $this->addCSS('/link/public/css/style.css');
    }
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
        // create string $class variable from params if target is set to _blank
        $class = isset($params['target']) && $params['target'] == '_blank' ? 'class="external"' : '';

        // create string $url variable from params if url is set
        $url = isset($params['url']) ? $params['url'] : '';
        // set $url to "#" if url is not set
        $url = $url == '' ? '#' : $url;

        $target = array_key_exists('target', $params) ? $params['target'] : '_self';
        $html = '<a ' . $class . ' href="' . $url . '" target="' . $target . '">' . $params['text'] . '</a>';

        # and return a html-snippet that replaces the shortcode on the page.
        $shortcode->setData($html);
      } catch (\Throwable $th) {
        throw $th;
      }
    }
  }
}
