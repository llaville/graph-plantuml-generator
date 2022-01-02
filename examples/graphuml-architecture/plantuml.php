<?php declare(strict_types=1);
/**
 * This file is part of the Graph-PlantUML package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Laurent Laville
 */

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Bartlett\GraphUml;
use Bartlett\GraphPlantUml\PlantUmlGenerator;

use Graphp\Graph\Graph;

$generator = new PlantUmlGenerator();
$generator->setExecutable('vendor/bin/plantuml');
$graph = new Graph();
$builder = new GraphUml\ClassDiagramBuilder(
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
$graph->setAttribute('cluster.Bartlett\\GraphPlantUml.graph.bgcolor', 'LightSteelBlue');
$graph->setAttribute('cluster.Bartlett\\GraphUml\\Generator.graph.bgcolor', 'LimeGreen');

// show UML diagram statements
echo $generator->createScript($graph);

// default format is PNG, change it to SVG
$generator->setFormat($format = 'svg');

$target = $generator->createImageFile($graph);
echo (empty($target) ? 'no' : $target) . ' file generated' . PHP_EOL;
