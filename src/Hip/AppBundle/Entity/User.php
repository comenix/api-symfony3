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
     * @ORM\ManyToMany(targetEntity="Hip\AppBundle\Entity\Client")
     * @ORM\JoinTable(name="fos_user__to__oauth_clients",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="client_id", referencedColumnName="id")}
     * )
     * @var ArrayCollection
     */
    protected $allowedClients;

    public function __construct()
    {
        parent::__construct();
        $this->allowedClients = new ArrayCollection();
    }

    public function isAuthorizedClient(ClientInterface $client)
    {
        return $this->getAllowedClients()->contains($client);
    }

    public function addClient(ClientInterface $client)
    {
        if (!$this->allowedClients->contains($client)) {
            $this->allowedClients->add($client);
        }
    }

    public function getAllowedClients()
    {
        return $this->allowedClients;
    }
}
