<?php

namespace Hip\AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Exception\AlreadySubmittedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

use Hip\AppBundle\Entity\User;
use Hip\AppBundle\Exception\InvalidFormException;

/**
 *
 * Class UserController
 * @package Hip\AppBundle\Controller
 */
class UserController extends BaseController
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
        $this->provider = $this->get('hip.app_bundle.user_provider');
        return $this->fetchResponse($id);
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

            //TODO: return success message

            /*
            $routeOptions = [
                'id' => $user->getId(),
                '_format' => $request->get('_format')
            ];
            return $this->routeRedirectView('get_user', $routeOptions, Response::HTTP_CREATED);
            */

        } catch (InvalidFormException $e) {
            return $e->getForm();
        }
    }
}