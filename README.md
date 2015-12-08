This is a custom theme developed for auth2factor module.
This theme supports the following and works best with auth2factor module

- User defined questions for 2nd step authentication
- Pre defined questions for 2nd step authentication
- Email secret code for 2nd step authentication
- Ability to switch between multiple 2nd step authentication methods
- Ability to reset secret questions

To install this theme use composer

```
    composer require simplesamlphp/simplesamlphp-module-theme2factor
```

To configure this theme, the following configuration needs to be added to config.php

```
    'theme.use'     => 'theme2factor:2factor',
```

Some other considerations have been made in this theme such as turning off autocapitalize,
autocorrect and autocomplete of input elements.

The theme should also look good on mobile devices and respond.