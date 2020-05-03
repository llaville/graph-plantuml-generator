<?php

require_once dirname(__DIR__,2) . '/vendor/autoload.php';

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
        'label-format' => 'default',
    ]
);

$builder->createVertexClass(PlantUmlGenerator::class);

// personalize render
$graph->setAttribute($generator->getName() . '.graph.bgcolor', 'transparent');
$graph->setAttribute($generator->getName() . '.subgraph.cluster_0.graph.bgcolor', 'limegreen');
$graph->setAttribute($generator->getName() . '.subgraph.cluster_1.graph.bgcolor', 'LightSteelBlue');

// show UML diagram statements
echo $generator->createScript($graph);
// default format is PNG
echo $generator->createImageFile($graph) . ' file generated' . PHP_EOL;
