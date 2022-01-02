<?php declare(strict_types=1);
/**
 * This file is part of the Graph-PlantUML package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Laurent Laville
 */

use Bartlett\GraphPlantUml\PlantUmlGenerator;
use Bartlett\GraphUml\Generator\GeneratorInterface;

function dataSource(): Generator
{
    $classes = [
        PlantUmlGenerator::class,
        GeneratorInterface::class,
    ];
    foreach ($classes as $class) {
        yield $class;
    }
}
