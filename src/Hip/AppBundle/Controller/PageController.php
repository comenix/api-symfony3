<?php

namespace Hip\AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PageController
 *
 * By using "implements ClassResourceInterface" we can omit the Class name from the action methods
 * "class PageController extends FOSRestController implements ClassResourceInterface"
 * For example, "getAction" instead of "getPageAction" and "cgetAction" instead of "getPagesAction"
 * see: http://symfony.com/doc/master/bundles/FOSRestBundle/5-automatic-route-generation_single-restful-controller.html#implicit-resource-name-definition
 *
 * Using this controller as the routing.yml resource, will tell Symfony to automatically generate proper REST routes
 * from this controller action names.
 * Notice "type: rest" option (in routing.yml) is required so that the RestBundle can find which routes are supported.
 * see: http://symfony.com/doc/master/bundles/FOSRestBundle/5-automatic-route-generation_single-restful-controller.html#single-restful-controller-routes
 *
 * @package Hip\AppBundle\Controller
 */
class PageController extends FOSRestController
{

    /**
     * Returns content when given a valid id
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Retrieves content by id",
     *  output = "Hip\AppBundle\Entity\Content",
     *  section="Pages",
     *  statusCodes={
     *         200="Returned when successful",
     *         404="Returned when the requested Content is not found"
     *     }
     * )
     *
     * @View()
     *
     * @param $id
     *
     * @return \Hip\AppBundle\Entity\Content
     *
     * @throws NotFoundHttpException
     */
    public function getPageAction($id)
    {
        return $this->get('hip.app_bundle.content_provider')->getPageContent($id);
    }

    /**
     * Returns content when given a valid id
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Retrieves content by id",
     *  output = "Hip\AppBundle\Entity\Content",
     *  section="Pages",
     *  statusCodes={
     *         200="Returned when successful",
     *         404="Returned when the requested Content is not found"
     *     }
     * )
     *
     * @View()
     *
     * @param $id
     *
     * @return \Hip\AppBundle\Entity\Content
     *
     * @throws NotFoundHttpException
     */
    public function getPageHomeAction()
    {
        return $this->get('hip.app_bundle.content_provider')->getHomePageContent();
    }
}
