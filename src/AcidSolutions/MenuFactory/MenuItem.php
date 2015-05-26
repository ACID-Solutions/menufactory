<?php namespace AcidSolutions\MenuFactory;

use \Closure;
/**
* MenuItem
*/
class MenuItem
{

  private $_label   = '';
  private $_uri     = '';
  private $_pattern = '';
  private $_allow   = true;
  private $_child   = array();
  private $_options = array();

  function __construct($name = '', $params = null )
  {
    $this->_label = $name;
    if ($params instanceof Closure) {
      $this->_options = array();
    }else{
      $this->_options = $params;
    }

    return $this;
  }
  public function add($name, $params = null)
  {
    $child = new MenuItem($name, $params);
    $this->_child[] = $child;

    if ($params instanceof Closure) {
      $params($child);
    }
    return $child;
  }
  public function uri($uri = '')
  {
    $this->_uri = $uri;
    return $this;
  }
  public function pattern($pattern)
  {
    $this->_pattern = $pattern;
    return $this;
  }

  private function _prepareLabel()
  {
    if (!empty($this->_pattern)) {
      if (stripos($this->_pattern, '__LABEL__')) {
        return str_ireplace('__LABEL__', $this->_label, $this->_pattern);
      }
    }
    return $this->_label;
  }
  public function allow($test)
  {
    if ($test instanceof Closure) {
      $this->_allow = $test();
    }else{
      $this->_allow = $test;
    }

  }
  public function option($optionName, $value, $target = 'a')
  {
    $this->_options[$target][$optionName][] = $value;
    return $this;
  }
  private function _formateOptions()
  {
    if (empty($this->_options)) {
      return array('', '', '');
    }

    $optionsString       = array();
    $optionsString['li'] = '';
    $optionsString['a']  = '';
    $optionsString['ul']  = '';

    foreach ($this->_options as $target => $options) {
      if (!isset($optionsString[$target])) {
        $optionsString[$target] = '';
      }
      foreach ($options as $optionName => $values) {
        $optionsString[$target] .= ' '.$optionName.'="'.implode(' ', $values).'"';
      }
    }
    return array($optionsString['li'], $optionsString['a'], $optionsString['ul']);
  }
  public function renderHtml()
  {
    if (!$this->_allow) {
      return '';
    }
    list($liOptions, $aOptions, $ulOptions) = $this->_formateOptions();

    $html = '<li'.$liOptions.'>';
    $html .= '<a href="'.$this->_uri.'"'.$aOptions.'>'.$this->_prepareLabel().'</a>';
    if (!empty($this->_child)) {
      // menu is container
      $html .= '<ul'.$ulOptions.'>';
      foreach ($this->_child as $menuItem) {
        $html .= $menuItem->renderHtml();
      }
      $html .= '</ul>';
    }

    $html .= '</li>';
    return $html;
  }
}
