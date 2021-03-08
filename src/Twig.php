<?php

declare( strict_types = 1 );

namespace Slim\Views;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\ViewInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Twig implements ViewInterface
{
    /**
     * @var Environment
     */
    private Environment $environment;

    /**
     * @param string $loader Path to templates
     * @param array $options Twig options
     */
    public function __construct(string $loader, array $options = [])
    {
        $loader = new FilesystemLoader($loader);

        $this->environment = new Environment($loader, $options);
    }

    /**
     * Output rendered template
     * 
     * @param Response $response
     * @param string $template Name of the template
     * @param array $data Template variables
     */
    public function render(Response $response, string $template, array $data = []): Response
    {
        $html = $this->environment->render($template, $data);
        $response->getBody()->write($html);

        return $response;
    }
}