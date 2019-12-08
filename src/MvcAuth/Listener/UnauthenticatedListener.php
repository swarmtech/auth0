<?php

declare(strict_types=1);

namespace Swarmtech\Auth0\MvcAuth\Listener;

use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\MvcAuth\MvcAuthEvent;

class UnauthenticatedListener
{
    /**
     * Determine if we have an authentication failure, and, if so, return a 401 response
     *
     * @param MvcAuthEvent $mvcAuthEvent
     * @return null|ApiProblemResponse
     */
    public function __invoke(MvcAuthEvent $mvcAuthEvent)
    {
        if (!$mvcAuthEvent->hasAuthenticationResult()) {
            return;
        }

        $authResult = $mvcAuthEvent->getAuthenticationResult();

        if ($authResult->isValid()) {
            return;
        }

        $mvcEvent = $mvcAuthEvent->getMvcEvent();
        $messages = $authResult->getMessages();

        var_dump($messages); exit;

        $response = new ApiProblemResponse(new ApiProblem(401, $messages));
        $mvcEvent->setResponse($response);

        return $response;
    }
}
