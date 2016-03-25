<?php

/**
 * Class FormHandlerTest
 *
 * "extends \Codeception\TestCase\Test" so we have easy access to the service container
 */
class ContentFormTest extends \Symfony\Component\Form\Test\TypeTestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {

    }

    // tests

    /**
     * Based on: http://symfony.com/doc/current/cookbook/form/unit_testing.html
     */
    public function testSubmitValidData()
    {
        $formData = [
            'title' => 'test',
            'body'  => 'test2'
        ];

        $form = $this->factory->create(\Hip\Content\Form\Type\ContentType::class, new \Hip\AppBundle\Entity\Content());

        $object = new \Hip\AppBundle\Entity\Content();
        $object
            ->setTitle($formData['title'])
            ->setBody($formData['body']);

        // submit the data to the form directly
        $form->submit($formData);

        static::assertTrue($form->isSynchronized());
        static::assertEquals($object, $form->getData());

        $view     = $form->createView();
        $children = $view->children;

        static::assertArrayHasKey('title', $children);
        static::assertArrayHasKey('body', $children);
    }
}
