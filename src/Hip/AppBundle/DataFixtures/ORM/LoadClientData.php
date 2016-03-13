<?php

namespace Hip\AppBundle\DataFixtures\ORM;

use Hip\AppBundle\Entity\Client;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OAuth2\OAuth2;

/**
 *
USAGE:
bin/console doctrine:fixtures:load -n --env=dev
bin/console doctrine:fixtures:load --fixtures=src/Hip/AppBundle/DataFixtures/ORM/LoadClientData.php
 *
 * Class LoadClientData
 * @package Hip\AppBundle\DataFixtures\ORM
 */
class LoadClientData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $client = new Client();
        $client->setRedirectUris(['http://hiphiparray.dev']);
        $client->setAllowedGrantTypes(
            [
                OAuth2::GRANT_TYPE_AUTH_CODE,
                OAuth2::GRANT_TYPE_USER_CREDENTIALS,
                OAuth2::GRANT_TYPE_REFRESH_TOKEN,
                OAuth2::GRANT_TYPE_IMPLICIT,
                OAuth2::GRANT_TYPE_CLIENT_CREDENTIALS,
            ]
        );

        $manager->persist($client);
        $manager->flush();
    }


    /**
     * @return int
     */
    public function getOrder()
    {
        return 100; // the order in which fixtures will be loaded
    }
}
