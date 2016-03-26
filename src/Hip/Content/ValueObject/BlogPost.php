<?php

namespace Hip\Content\ValueObject;

use Hateoas\Configuration\Annotation as Hateoas;
use Hip\Content\Model\ContentInterface;

/**
 * Class BlogPost
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
class BlogPost implements ContentInterface
{
    public $id;
    public $title;
    public $body;
    public $summary;

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
