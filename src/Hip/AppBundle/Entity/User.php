<?php
namespace Hip\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\OAuthServerBundle\Model\ClientInterface;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity(repositoryClass="Hip\User\Repository\UserRepository")
 * @ORM\Table(name="fos_user")
 *
 * @Hateoas\Relation(
 *     "self",
 *     href = @Hateoas\Route(
 *         "get_user",
 *         parameters={"id" = "expr(object.getId())"}
 *     )
 * )
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Content
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
}
