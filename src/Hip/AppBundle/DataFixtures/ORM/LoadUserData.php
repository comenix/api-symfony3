<?php

namespace Hip\AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Hip\AppBundle\Entity\User;

/**
 *
USAGE:
bin/console doctrine:fixtures:load -n --env=dev
 *
 * Class LoadContentData
 * @package Hip\AppBundle\DataFixtures\ORM
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        $user = new User();
        $user
            ->setUsername('tester')
            ->setUsernameCanonical('tester')
            ->setEmail('test@example.com')
            ->setEmailCanonical('test@example.com')
            ->setEnabled(true)
            ->setSalt('5y2aja6xtnwogkwoosw84c8os804sc0')
            ->setPassword('$2y$13$EDLipNhk9kK1RxL94hmkR.Isug.4IVsKSQLbMqXKPqDy0tEM31Lq6')
            ->setLocked(false)
            ->setExpired(false)
            ->setRoles([])
            ->setCredentialsExpired(false);

        $manager->persist($user);
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
