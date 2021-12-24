<?php declare(strict_types=1);
/**
 * This file is part of the GraPHP-PlantUML package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Laurent Laville
 */

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Bartlett\GraphUml\ClassDiagramBuilder;
use Bartlett\GraphPlantUml\PlantUmlGenerator;

use Graphp\Graph\Graph;

$generator = new PlantUmlGenerator();
$generator->setExecutable('vendor/bin/plantuml');
$graph = new Graph();
$builder = new ClassDiagramBuilder(
    $generator,
    $graph,
    [
        'label_format' => 'default',
    ]
);

$builder->createVertexClass(PlantUmlGenerator::class);

// personalize render
// https://plantuml.com/en/color
$graph->setAttribute('graph.bgcolor', 'transparent');
$graph->setAttribute('cluster.Bartlett\\GraphPlantUml.graph.bgcolor', 'lightsteelblue');
$graph->setAttribute('cluster.Bartlett\\GraphUml\\Generator.graph.bgcolor', 'SteelBlue');

// show UML diagram statements
echo $generator->createScript($graph);
// default format is PNG
$target = $generator->createImageFile($graph);
if (isset($argv[1])) {
    // target folder provided
    $from = $target;
    $target = rtrim($argv[1], DIRECTORY_SEPARATOR) . '/single_class.' . substr(strrchr($target, '.'), 1);
    if (!rename($from, $target)) {
        $target = null;
    }
} else {
    $cmdFormat = '';
}
echo (empty($target) ? 'no' : $target) . ' file generated' . PHP_EOL;
