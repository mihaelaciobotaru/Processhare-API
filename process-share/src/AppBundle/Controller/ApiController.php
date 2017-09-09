<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ProcesshareUser;
use AppBundle\Service\Provider\MessageProvider;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    /**
     * @Get("/api/message", name="homepage")
     */
    public function indexAction()
    {
        /** @var MessageProvider $providers */
        $providers = $this->get('message_providers');
        $message = $providers->getMessage();

        return new JsonResponse(
            $message,
            $message ? Response::HTTP_OK : Response::HTTP_NOT_FOUND
        );
    }

    /**
     * @Post("/api/message/response", name="response message")
     */
    public function postMessageResponse(Request $request)
    {
        return new JsonResponse(["user_id" => $request->get('user_id'), 'reward' => 0.01], Response::HTTP_OK);
    }

    /**
     * @Post("/api/login", name="login")
     */
    public function login(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository('AppBundle:EmagUser');
        $emagUser = $repo->findOneBy(['username' => $request->get('user')]);

        return new JsonResponse(
            $emagUser,
            $emagUser ? Response::HTTP_OK : Response::HTTP_UNAUTHORIZED
        );
    }
}
