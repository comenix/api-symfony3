<?php

namespace Hip\Content\ValueObject;

use Hateoas\Configuration\Annotation as Hateoas;
use Hip\Content\Model\ContentInterface;

/**
 * Class PostValueObject
 * @package Hip\Content\ValueObject
 *
 * @Hateoas\Relation(
 *     "self",
 *     href = @Hateoas\Route(
 *         "get_post",
 *         parameters={"id" = "expr(object.getId())"}
 *     )
 * )
 */
class PostValueObject implements ContentInterface
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
