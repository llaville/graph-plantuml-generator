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
$graph->setAttribute($generator->getName() . '.cluster.Bartlett\\GraphPlantUml.graph.bgcolor', 'LightSteelBlue');
$graph->setAttribute($generator->getName() . '.cluster.Bartlett\\GraphUml\\Generator.graph.bgcolor', 'limegreen');

// show UML diagram statements
echo $generator->createScript($graph);
// show UML diagram statements encoded version (easier to use in URL with GET method)
echo $generator->createScript($graph, true) . PHP_EOL;
// default format is PNG
echo $generator->createImageFile($graph) . ' file generated' . PHP_EOL;
