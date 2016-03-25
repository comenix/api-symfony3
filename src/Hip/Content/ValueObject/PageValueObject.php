<?php

namespace Hip\Content\ValueObject;

use Hateoas\Configuration\Annotation as Hateoas;
use Hip\Content\Model\ContentInterface;

/**
 * Class PageValueObject
 * @package Hip\Content\ValueObject
 *
 * @Hateoas\Relation(
 *     "self",
 *     href = @Hateoas\Route(
 *         "get_page",
 *         parameters={"id" = "expr(object.getId())"}
 *     )
 * )
 */
class PageValueObject implements ContentInterface
{
    public $id;
    public $title;
    public $body;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getBody()
    {
        return $this->getBody();
    }
}
