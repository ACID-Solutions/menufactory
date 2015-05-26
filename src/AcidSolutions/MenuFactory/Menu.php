<?php namespace AcidSolutions\MenuFactory;

use \Closure;
/**
* Menu
*/
class Menu
{

  private $_child   = array();
  private $_options = array();

  public function add($name = '', $params = null)
  {
    if (!is_string($name)) {
      throw new Exception("Child name must be a string", 1);
    }
    $child = new MenuItem($name, $params);
    $this->_child[] = $child;
    if ($params instanceof Closure) {
      $params($child);
    }
    return $child;
  }

  public function option($optionName, $value)
  {
    $this->_options[$optionName][] = $value;
    return $this;
  }
  private function _formateOptions()
  {
    if (empty($this->_options)) {
      return '';
    }

    $optionsString = '';
    foreach ($this->_options as $optionName => $values) {
      $optionsString .= ' '.$optionName.'="'.implode(' ', $values).'"';
    }
    return $optionsString;
  }
  public function renderHtml()
  {
    $options = $this->_formateOptions();
    $html = '<ul'.$options.'>';

    foreach ($this->_child as $menuItem) {
      $html .= $menuItem->renderHtml();
    }

    $html .= '</ul>';

    return $html;
  }
}