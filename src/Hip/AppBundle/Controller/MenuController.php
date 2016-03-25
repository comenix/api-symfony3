<?php

namespace Hip\AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Exception\AlreadySubmittedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Hip\AppBundle\Entity\Content;
use Hip\AppBundle\Exception\InvalidFormException;

/**
 * Class MenuController
 *
 * By using "implements ClassResourceInterface" we can omit the Class name from the action methods
 * "class MenuController extends FOSRestController implements ClassResourceInterface"
 * For example, "getAction" instead of "getMenuAction" and "cgetAction" instead of "getMenusAction"
 * see: http://symfony.com/doc/master/bundles/FOSRestBundle/5-automatic-route-generation_single-restful-controller.html#implicit-resource-name-definition
 *
 * Using this controller as the routing.yml resource, will tell Symfony to automatically generate proper REST routes
 * from this controller action names.
 * Notice "type: rest" option (in routing.yml) is required so that the RestBundle can find which routes are supported.
 * see: http://symfony.com/doc/master/bundles/FOSRestBundle/5-automatic-route-generation_single-restful-controller.html#single-restful-controller-routes
 *
 * @package Hip\AppBundle\Controller
 */
class MenuController extends FOSRestController
{

    /**
     * Returns menu when given a valid id
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Retrieves menu titles",
     *  section="Menus",
     *  statusCodes={
     *         200="Returned when successful",
     *         404="Returned when the requested Menu is not found"
     *     }
     * )
     *
     * @View()
     *
     * @return array
     *
     * @throws NotFoundHttpException
     */
    public function getMenuAction()
    {
        return $this->get('hip.app_bundle.content_provider')->getPageTitles();
    }


}
