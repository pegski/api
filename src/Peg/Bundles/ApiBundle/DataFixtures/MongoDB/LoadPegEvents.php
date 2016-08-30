<?php

namespace Peg\Bundles\ApiBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\SharedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Peg\Bundles\ApiBundle\Document\Event;
use Peg\Bundles\ApiBundle\Document\Peg;
use Peg\Bundles\ApiBundle\Document\PictureEvent;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class LoadPegEvents extends AbstractFixture implements SharedFixtureInterface, DependentFixtureInterface
{
    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array
     */
    public function getDependencies()
    {
        return [LoadInitialPegs::class];
    }

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

        foreach (LoadInitialPegs::$shortcodes as $shortcode) {

            /** @var Peg $peg */
            $peg = $this->getReference('peg:' . $shortcode);

            $basePath = "/pics/$shortcode";
            $path = dirname(dirname(dirname(dirname(dirname(dirname(__DIR__)))))) . "/web$basePath";
            if (!is_dir($path)) {
                continue;
            }

            $finder = new Finder();
            $finder->files()->in($path)->sortByName();

            $fileCount = $finder->count();

            // We can't use $fileNo => $file in the foreach loop, as Finder returns the file name as the index, so use
            // manual index no
            $fileNo = 0;
            foreach ($finder as $file) {
                ++$fileNo;

                $comment = null;
                if ($shortcode == 'skoop') {
                    $comment = $this->getCommentForSkoop($file);
                }

                $relativePath = preg_replace('#^.*' . $basePath . '#', $basePath, $file);
                $pictureEvent = PictureEvent::create($peg, 'You know… a picture', $relativePath, 'WeCamp', $comment);

                $happenedAtString = '-' . ($fileCount - $fileNo) . ' hours';
                $happenedAtDateTime = new \DateTimeImmutable($happenedAtString);
                $happenedAtValueString = $happenedAtDateTime->format(\DateTime::ATOM);
                $happenedAtReflProp->setValue($pictureEvent, $happenedAtValueString);

                $manager->persist($pictureEvent);
            }
        }

        $manager->flush();
    }

    private function getCommentForSkoop(SplFileInfo $file)
    {
        switch ($file->getFilename()) {
            case '0.jpg':
                return 'Preparing myself ...';
            case '1.jpg':
                return 'I\'m ready and beautiful';
            case '2.jpg':
                return 'It\'s beer o\'clock';
            case '3.jpg':
                return 'var_dump or die()';
            case '4.jpg':
                return 'Hoping everything is OK';
            case '5.jpg':
                return 'Late code review';
            case '6.jpg':
                return 'Special treatment';
            case '7.jpg':
                return 'I\'m done for today';
        }
    }
}
