<?php

namespace Peg\Bundles\ApiBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\SharedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Peg\Bundles\ApiBundle\Document\CommentEvent;
use Peg\Bundles\ApiBundle\Document\Event;
use Peg\Bundles\ApiBundle\Document\Peg;

class LoadInitialPegs extends AbstractFixture implements SharedFixtureInterface
{
    public static $shortcodes = [
        'catalyst',
        'flexman',
        'giant',
        'mike',
        'monique',
        'puppetmaster',
        'ramon',
        'skoop',
        'tacticus',
        'voltra',
    ];

    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $eventReflection = new \ReflectionClass(Event::class);
        $happenedAtReflProp = $eventReflection->getProperty('happenedAt');
        $happenedAtReflProp->setAccessible(true);

        foreach (self::$shortcodes as $shortcode) {
            $peg = Peg::register($shortcode);
            $pegBornEvent = CommentEvent::create($peg, 'PegCreated', 'A Peg has been born! Give it a nice lifetime');

            $happenedAtReflProp->setValue($pegBornEvent, (new \DateTimeImmutable('-2 days'))->format(\DateTime::ATOM));

            $this->addReference('peg:' . $shortcode, $peg);
            $this->addReference('peg:birth:' . $shortcode, $pegBornEvent);
            $manager->persist($peg);
            $manager->persist($pegBornEvent);
        }

        $manager->flush();
    }
}
