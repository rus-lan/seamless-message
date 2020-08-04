<?php

namespace RusLan\SeamlessMessage\Bundle\Controller;

use RusLan\SeamlessMessage\Bundle\Model\Route\DTO\Action;
use RusLan\SeamlessMessage\Bundle\Model\User\Entity\User;
use RusLan\SeamlessMessage\Bundle\Provider\History\HistoryProviderAwareInterface;
use RusLan\SeamlessMessage\Bundle\Provider\History\HistoryProviderAwareTrait;
use RusLan\SeamlessMessage\Bundle\Routing\SeamlessMessageLoader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/** @method User|null getUser */
abstract class AbstractController extends BaseController implements HistoryProviderAwareInterface
{
    use HistoryProviderAwareTrait;

    /**
     * @return Response
     */
    final protected function responseNotFound(): Response
    {
        return $this->json([
            'ok' => false,
            'error_code' => Response::HTTP_BAD_REQUEST,
            'description' => "The command does not exist.",
        ], Response::HTTP_OK);
    }

    /**
     * @return Response
     */
    final protected function responseOk(): Response
    {
        return $this->json([
            'ok' => true,
            'result' => true,
        ], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return string|null
     */
    final protected function getBotName(Request $request): ?string
    {
        return ($_route = $request->request->get(SeamlessMessageLoader::FIELD_ROUTE))
            && ($_route instanceof Action)
            ? $_route->getBotName() : null;
    }

    /**
     * @param string $route
     * @return static
     */
    final protected function resetHistory(string $route): self
    {
        $route = ($route !== SeamlessMessageLoader::DEFAULT_ROUTER_NAME) ? $route : null;

        return $this->setHistory($route ? [sprintf('/%s', $route)] : []);
    }

    /**
     * @param array $routes
     * @return static
     */
    final protected function setHistory(array $routes = []): self
    {
        $this->getHistoryProvider()
            ->update($this->getUser()->setHistory($routes))
            ->flush()
        ;

        return $this;
    }
}
