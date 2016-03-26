<?php

namespace Hip\AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Exception\AlreadySubmittedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Hip\AppBundle\Entity\User;
use Hip\AppBundle\Exception\InvalidFormException;

/**
 * Class UserController
 *
 * By using "implements ClassResourceInterface" we can omit the Class name from the action methods
 * "class ContentController extends FOSRestController implements ClassResourceInterface"
 * For example, "getAction" instead of "getContentAction" and "cgetAction" instead of "getContentsAction"
 * see: http://symfony.com/doc/master/bundles/FOSRestBundle/5-automatic-route-generation_single-restful-controller.html#implicit-resource-name-definition
 *
 * Using this controller as the routing.yml resource, will tell Symfony to automatically generate proper REST routes
 * from this controller action names.
 * Notice "type: rest" option (in routing.yml) is required so that the RestBundle can find which routes are supported.
 * see: http://symfony.com/doc/master/bundles/FOSRestBundle/5-automatic-route-generation_single-restful-controller.html#single-restful-controller-routes
 *
 * @package Hip\AppBundle\Controller
 */
class UserController extends FOSRestController
{

    /**
     * Returns user when given a valid id
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Retrieves user by id",
     *  output = "Hip\AppBundle\Entity\User",
     *  section="Users",
     *  statusCodes={
     *         200="Returned when successful",
     *         404="Returned when the requested User is not found"
     *     }
     * )
     *
     * @View()
     *
     * @param $id
     *
     * @return \Hip\AppBundle\Entity\User
     *
     * @throws NotFoundHttpException
     */
    public function getUserAction($id)
    {
        return $this->get('hip.app_bundle.user_provider')->fetchResponse($id);
    }

    /**
     * Returns user when given a valid id
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Retrieves user by id",
     *  output = "Hip\AppBundle\Entity\User",
     *  section="Users",
     *  statusCodes={
     *         200="Returned when successful",
     *         404="Returned when the requested User is not found"
     *     }
     * )
     *
     * @View()
     *
     * @param $id
     *
     * @return \Hip\AppBundle\Entity\User
     *
     * @throws NotFoundHttpException
     */
    public function getProfileAction($id)
    {
        return $this->get('hip.app_bundle.user_provider')->fetchResponse($id);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Creates a new User",
     *  input = "Hip\User\Form\Type\UserFormType",
     *  output = "Hip\AppBundle\Entity\User",
     *  section="Users",
     *  statusCodes={
     *         201="Returned when a new User has been successfully created",
     *         400="Returned when the posted data is invalid"
     *     }
     * )
     *
     * @View()
     *
     * @param Request $request
     * @return \FOS\RestBundle\View\View|null
     *
     * @throws AlreadySubmittedException
     * @throws InvalidOptionsException
     */
    public function postRegisterAction(Request $request)
    {
        try {
            /** @var User $user */
            $user = $this->get('hip.app_bundle.user_dispatcher')->post($request->request->all());

            $eventResponse = $this->get('hip.app_bundle.user_events')->registrationInitialise($user, $request);
            if ($eventResponse !== null) {
                return $eventResponse;
            }

            return new JsonResponse(['result' => 'ok'], JsonResponse::HTTP_CREATED);

        } catch (InvalidFormException $e) {
            return $e->getForm();
        }
    }
}
