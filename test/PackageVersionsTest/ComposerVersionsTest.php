<?php

namespace PackageVersionsTest;

use PackageVersions\ComposerVersions;
use PHPUnit_Framework_TestCase;

/**
 * @covers \PackageVersions\Versions
 */
final class ComposerVersionsTest extends PHPUnit_Framework_TestCase
{
    public function testValidVersions()
    {
        $lockData = json_decode(file_get_contents(__DIR__ . '/../../composer.lock'), true);

        $packages = array_merge($lockData['packages'], $lockData['packages-dev']);

        self::assertNotEmpty($packages);

        foreach ($packages as $package) {
            self::assertSame(
                $package['version'],
                ComposerVersions::getVersion($package['name'])
            );
        }
    }

    public function testInvalidVersionsAreRejected()
    {
        $this->setExpectedException(\OutOfBoundsException::class);

        ComposerVersions::getVersion(uniqid('', true) . '/' . uniqid('', true));
    }
}
