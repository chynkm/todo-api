<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use Symfony\Component\Yaml\Yaml;

final class SwaggerAction
{
    /**
     * @var PhpRenderer
     */
    private $renderer;

    /**
     * @param PhpRenderer $renderer
     */
    public function __construct(PhpRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface{
        $yamlFile = __DIR__ . '/../../resources/docs/task.yaml';

        $viewData = [
            'spec' => json_encode(Yaml::parseFile($yamlFile)),
        ];

        return $this->renderer->render($response, 'docs/swagger.php', $viewData);
    }
}
