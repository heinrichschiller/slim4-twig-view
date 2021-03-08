# slim4-twig-view

This class is a Slim Framework view helper built on top of the Twig templating component.
Twig is a modern template engine for PHP

## Twig Mainpage
https://twig.symfony.com/

## Installation

```bash
composer require heinrichschiller/slim4-twig-view
```

## Usage

Add the Twig settings in your Slim settings:

```php
...
'twig' => [
        'loader' => ROOT_DIR . 'resources/views',
        'options' => [
            'cache' => ROOT_DIR . 'var/caches/twig',
            'auto_reload' => true // true, for development only
        ]
    ]
...
```
Create the views-Directory and create the index.html file in the views-Directory, like this:

```html
<h1>Hello, {{ world }}</h1>
```
Next, define Twig-Container like this:

```php
...

ViewInterface::class => function(ContainerInterface $container): ViewInterface
{
    $loader = $container->get('settings')['twig']['loader'];
    $options = $container->get('settings')['twig']['options'];

    return new Twig($loader, $options);
}

...
```

And create a container injection, like this:

```php
...

IndexAction::class => function(ContainerInterface $container): IndexAction
{
    return new IndexAction(
        $container->get(ViewInterface::class),
    );
}

...
```

At last create the action, like this:

```php

// IndexAction.php

declare( strict_types = 1 );

namespace App\Actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\View\Mustache;

class IndexAction
{
    private ViewInterface $view;

    public function __construct(ViewInterface $view)
    {
        $this->view = $view;
    }

    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $response = $this->view->render($response, 'index.html', ['world' => 'World!']);

        return $response;
    }
}

```

Now call your IndexAction and if you were successful you will see this result.


<h1>Hello, World!</h1>

## More about Twig?
Read [Twig Webpage](https://twig.symfony.com/) for more information.

## Testing

```bash
phpunit
```

Have fun!