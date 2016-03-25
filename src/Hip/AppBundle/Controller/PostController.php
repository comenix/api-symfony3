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
 * Class PostController
 *
 * By using "implements ClassResourceInterface" we can omit the Class name from the action methods
 * "class PostController extends FOSRestController implements ClassResourceInterface"
 * For example, "getAction" instead of "getPostAction" and "cgetAction" instead of "getPostsAction"
 * see: http://symfony.com/doc/master/bundles/FOSRestBundle/5-automatic-route-generation_single-restful-controller.html#implicit-resource-name-definition
 *
 * Using this controller as the routing.yml resource, will tell Symfony to automatically generate proper REST routes
 * from this controller action names.
 * Notice "type: rest" option (in routing.yml) is required so that the RestBundle can find which routes are supported.
 * see: http://symfony.com/doc/master/bundles/FOSRestBundle/5-automatic-route-generation_single-restful-controller.html#single-restful-controller-routes
 *
 * @package Hip\AppBundle\Controller
 */
class PostController extends FOSRestController
{

    /**
     * Returns content when given a valid id
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Retrieves content by id",
     *  output = "Hip\AppBundle\Entity\Content",
     *  section="Posts",
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
    public function getPostAction($id)
    {
        return $this->get('hip.app_bundle.content_provider')->getPostContent($id);
    }
}
