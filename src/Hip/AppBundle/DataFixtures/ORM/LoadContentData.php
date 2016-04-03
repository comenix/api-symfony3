<?php

namespace Hip\AppBundle\DataFixtures\ORM;

use Hip\AppBundle\Entity\Content;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 *
USAGE:
bin/console doctrine:fixtures:load -n --env=dev
 *
 * Class LoadContentData
 * @package Hip\AppBundle\DataFixtures\ORM
 */
class LoadContentData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $data) {
            $content = new Content();
            $content
                ->setTitle($data['title'])
                ->setBody($data['body']);

            $manager->persist($content);
            $this->addReference($data['reference'], $content);
        }

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 100; // the order in which fixtures will be loaded
    }

    /**
     * @return array
     */
    private function getData()
    {
        return [
            1 => ['title' => 'Veggies es bonus', 'body' => 'Veggies es bonus vobis, proinde vos postulo essum magis kohlrabi welsh onion daikon amaranth tatsoi tomatillo melon azuki bean garlic.
Gumbo beet greens corn soko endive gumbo gourd. Parsley shallot courgette tatsoi pea sprouts fava bean collard greens dandelion okra wakame tomato.
Grape silver beet watercress potato tigernut corn groundnut. Chickweed okra pea winter purslane coriander yarrow sweet pepper radish garlic.', 'reference' => 'content-1'],
            2 => ['title' => 'Turnip greens', 'body' => 'Turnip greens yarrow ricebean rutabaga endive cauliflower sea lettuce kohlrabi amaranth water spinach avocado daikon napa cabbage asparagus winter purslane kale. Celery potato scallion desert raisin.', 'reference' => 'content-2'],
            3 => ['title' => 'Nori grape', 'body' => 'Nori grape silver beet broccoli kombu beet greens fava bean potato quandong celery. Salsify taro garlic gram celery bitterleaf wattle collard greens nori. Grape wattle kombu beetroot brussels sprout chard apple.', 'reference' => 'content-3'],
            4 => ['title' => 'Pea horseradish', 'body' => 'Pea horseradish azuki bean lettuce avocado asparagus okra. Kohlrabi radish okra azuki bean corn fava bean mustard tigernut green bean celtuce collard greens avocado quandong fennel gumbo black-eyed pea.', 'reference' => 'content-4'],
        ];
    }
}
