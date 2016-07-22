# Apple style notifications

View Helper for showing flash messages.  <br/>
You must include the latest release of jQuery and Bootstrap. <br/> <br/>

## **Install**

Add in composer.json file and than run **composer update**

```javascript
"require": {
    "tasmaniski/zf2-flash-noty-messenger":"1.0.*"
}
```

The module should be registered in **config/application.config.php**

```javascript
'modules' => array(
    '...',
    'FlashNotyMessenger'
),
```

After that, copy 2 JS files from **vendor/tasmaniski/zf2-flash-noty-messenger/asset/** <br/>
and put it on path **public/js/noty/** <br/>

```shell

mkdir public/js/noty/
cp vendor/tasmaniski/zf2-flash-noty-messenger/asset/jquery.noty.packaged.js public/js/noty/jquery.noty.packaged.js
cp vendor/tasmaniski/zf2-flash-noty-messenger/asset/jquery.noty.config.js public/js/noty/jquery.noty.config.js
```

<br/>

## Setup

In layout.phtml somewhere at the end trigger fire()

```php

/**
 * The fire() method do
 *     Collect all messages from previous and current request
 *     clear current messages because we will show it
 *     add JS files
 *     add JS notifications
 */
<?php $this->flashNoty()->fire(); ?>

<!-- if you already don't have this line, must add it for including JS files -->
<?php echo $this->inlineScript() ?>
```

Example from my code

```php
//  at the end of layout.phtml

/* fire all messages */
<?php $this->flashNoty()->fire(); ?>

<!-- All Scripts to the bottom! -->
<?php echo $this->inlineScript()  // we call here inlineScript()
    ->appendFile($this->basePath('js/jquery.js'))
    ->appendFile($this->basePath('js/bootstrap.js')); ?>

```

<br/>

## **Use**

Use it in any controller.<br/>
Add messages in your controller and the messages will be showed (in redirected request or current)

```php
<?php
$this->flashMessenger()->addSuccessMessage('Success message, bravo!');
$this->flashMessenger()->addErrorMessage('Error with system, contact us.');
$this->flashMessenger()->addInfoMessage('Info message, to do whatever...');
$this->flashMessenger()->addWarningMessage('Warning message to be careful.');
```


