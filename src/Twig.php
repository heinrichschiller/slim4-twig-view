<?php

declare( strict_types = 1 );

namespace Slim\Views;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\ViewInterface;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\Loader\FilesystemLoader;

class Twig implements ViewInterface
{
    private Environment $environment;

    public function __construct($loader, array $options = [])
    {
        if( is_array($loader) ) {
            $loader = new ArrayLoader($loader);
        } else {
            $loader = new FilesystemLoader($loader);
        }

        $this->environment = new Environment($loader, $options);
    }

    public function render(Response $response, string $template, array $data = []): Response
    {
        $this->environment->render($template, $data);

        return $response;
    }
}