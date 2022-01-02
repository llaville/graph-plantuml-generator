<?php declare(strict_types=1);
/**
 * This file is part of the Graph-PlantUML package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Laurent Laville
 */

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * TestClass to place utility functions in.
 */
class TestCase extends \PHPUnit\Framework\TestCase
{

}

class A
{

}

class B
{

}

class C implements Countable
{
    public function count()
    {
        return 0;
    }
}
