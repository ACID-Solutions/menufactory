## Menu Factory

Create complex menu without stress.

### How to install
Edit app/config/app.php
Add
```php
// 'providers'
'AcidSolutions\MenuFactory\MenuFactoryServiceProvider',
```
And
```php
// 'aliases'
'MenuFactory' => 'AcidSolutions\MenuFactory\MenuFactoryFacade',
```
### How to use

Call the factory
```php
$menu = MenuFactory::createMenu('MenuName');
```
Define one or more children
```
$menu->add('Menu without Child');
```
Get html render for one menu
```php
$menu->renderHtml();
// OR
MenuFactory::render('MenuName');
```

#### Pattern
Pattern is a decoration for label
```php
$menu->add('Menu without Child but with pattern')->pattern('<strong>__LABEL__</strong>');
# OR
$pattern = '<strong>__LABEL__</strong>';
$menu->add('Menu without Child but with pattern1')->pattern($pattern);
$menu->add('Menu without Child but with pattern2')->pattern($pattern);
$menu->add('Menu without Child but with pattern3')->pattern($pattern);
```

#### Chained multilevel
Create multilevel menu by chaining add

```php
$menu->add('Menu with chained child')->add('First level')->add('Second level')->add('third level')->add('Fourth level');
```

#### Multiple child with closure
Create Multiple children with closure, you've access to all options
```php
$menu->add('Menu with multiple child defined by closure', function ($menu) {
  $menu->add('first child');
  $menu->add('second child');
  $menu->add('third child');
});
```
More menu? OK Let's DO ITTTT

```php
$menu->add('Menu with multiple child with multiple child defined by closure', function ($menu) {
  $menu->add('first child', function ($menu) {
    $menu->add('first child');
    $menu->add('second child');
    $menu->add('third child');
  });
  $menu->add('second child', function ($menu) {
    $menu->add('first child');
    $menu->add('second child');
    $menu->add('third child');
  });
  $menu->add('third child', function ($menu) {
    $menu->add('first child');
    $menu->add('second child');
    $menu->add('third child');
  });
});
```

#### Allow access with Closure
Sometime you need to hide or show menu item to group of user. Use closure to defined it!
```php
// Using Sentry::check() for this example (it will check if user is auth)
$userAuth = Sentry::check();
$menu->add('Menu with allow function')->allow(function () use ($userAuth) {
  // You can do everything you want here
  return $userAuth;
});

$menu->add('Menu with allow function (gonna be hide)')->allow(function () use ($userAuth) {
  // You can do everything you want here
  return !$userAuth;
});

// Wait, why closure if i've the value?
$menu->add('Menu with allow function (gonna be hide)')->allow($userAuth);
```
#### Option on item
To Apply option to an item (class, click, bisous)

```php
$menu->add('Menu with Option')->option('class', 'btn');
```
Oh Shit i want to add `btn` class on the `a`, `btn-group` on the container `li` of the `a` and a `dropdown-menu` if this element have children...HOW!
```php
$menu->add('Menu with Option')
  ->option('class', 'btn')
  ->option('class', 'btn-group', 'li')
  ->option('class', 'dropdown-menu', 'ul');
```
#### What's about LInk?
Oh yes! links...

```php
$menu->add('Menu with uri')->uri('to_this_uri');
```
