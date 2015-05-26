<?php namespace AcidSolutions\MenuFactory;

use \Exception;
/**
* MenuManager
*/
class MenuFactory
{
  /**
   * @var array
   */
  private static $_menu = array();

  /**
   * Create a new Menu
   * @param $menuIdentifier String
   * @return MenuItem
   */
  public static function createMenu($menuIdentifier='')
  {
    if (empty($menuIdentifier)) {
      throw new Exception("Menu identifier can't be empty", 1);
    }

    if (static::has($menuIdentifier)) {
      throw new Exception("Menu already exists", 1);

    }
    return static::$_menu[$menuIdentifier] = new Menu();
  }

  /**
   * Check if a menu exists with the given name
   * @param $menuIdentifier String
   * @return boolean
   */
  public static function has($menuIdentifier)
  {
    return (isset(static::$_menu[$menuIdentifier]));
  }

  public static function getMenu($menuIdentifier)
  {
    if (static::has($menuIdentifier)) {
      return static::$_menu[$menuIdentifier];
    }
    throw new Exception("Menu doesn't exist", 1);
  }

  /**
   * Render the menu to html
   * @param $menuIdentifier String
   * @return html
   */
  public static function render($menuIdentifier='')
  {
    return static::getMenu($menuIdentifier)->renderHtml();
  }
}