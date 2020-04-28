<?php

require_once dirname(__DIR__,2) . '/vendor/autoload.php';

use Bartlett\GraphUml;
use Bartlett\GraphPlantUml\PlantUmlGenerator;

use Graphp\Graph\Graph;

$generator = new PlantUmlGenerator();
$graph = new Graph();
$builder = new GraphUml\ClassDiagramBuilder(
    $generator,
    $graph,
    [
        'label-format' => 'default',
        'indent-string' => '  ',
    ]
);

$builder->createVertexClass(PlantUmlGenerator::class);
$builder->createVertexClass(GraphUml\Formatter\HtmlFormatter::class);
$builder->createVertexClass(GraphUml\Formatter\RecordFormatter::class);
$builder->createVertexClass(GraphUml\Formatter\FormatterInterface::class);
$builder->createVertexClass(GraphUml\ClassDiagramBuilder::class);
$builder->createVertexClass(GraphUml\ClassDiagramBuilderInterface::class);

// show UML diagram statements
echo $generator->render($graph);
