<?php

namespace AppBundle\Controller;

use AppBundle\Adapter\ProcesshareUserApiAdapter;
use AppBundle\Entity\ProcesshareUser;
use AppBundle\Repository\ProcesshareUserRepository;
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
            [
                'type' => array_rand(['lesser_than' => 'lesser_than', 'greater_than' => 'greater_than'], 1),
                'data' => $message
            ],
            $message ? Response::HTTP_OK : Response::HTTP_NOT_FOUND
        );
    }

    /**
     * @Post("/api/message/response", name="response message")
     */
    public function postMessageResponse(Request $request)
    {
        /** @var ProcesshareUserRepository $repo */
        $repo = $this->getDoctrine()->getRepository('AppBundle:ProcesshareUser');
        /** @var ProcesshareUser $processhareUser */
        $processhareUser = $repo->findOneBy(['username' => $request->get('user')]);

        $processhareUser->addScore();
        $em = $this->getDoctrine()->getManager();
        $em->persist($processhareUser);
        $em->flush();

        return new JsonResponse(
            ProcesshareUserApiAdapter::adapt($processhareUser),
            Response::HTTP_OK
        );
    }
}
