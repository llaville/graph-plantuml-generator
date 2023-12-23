<!-- markdownlint-disable MD013 -->
# Draw application UML

In this example, we will learn how to personalize render of this package UML diagram.

```php
<?php
use Bartlett\GraphPlantUml\PlantUmlGenerator;
use Bartlett\GraphUml\ClassDiagramBuilder;

use Graphp\Graph\Graph;

// personalize render
$options = [
    'label_format' => 'default',
    'graph.bgcolor' => 'transparent',
    // https://plantuml.com/en/color
    'cluster.Bartlett\\GraphPlantUml.graph.bgcolor' => 'LightSteelBlue',
    'cluster.Bartlett\\GraphUml\\Generator.graph.bgcolor' => 'LimeGreen',
];

$generator = new PlantUmlGenerator();
$generator->setExecutable('vendor/bin/plantuml');
$graph = new Graph();
$builder = new ClassDiagramBuilder($generator, $graph, $options);

$builder->createVertexClass(PlantUmlGenerator::class);

// show UML diagram statements
echo $generator->createScript($graph);

// default format is PNG, change it to SVG
$generator->setFormat($format = 'svg');

$target = $generator->createImageFile($graph);
echo (empty($target) ? 'no' : $target) . ' file generated' . PHP_EOL;
```

* We specify a transparent background color with `graph.bgcolor` attribute
* We specify the background color of `Bartlett\GraphPlantUml` namespace with `cluster.Bartlett\\GraphPlantUml.graph.bgcolor` attribute
* We specify the background color of `Bartlett\GraphUml\Generator` namespace with `cluster.Bartlett\\GraphUml.graph.bgcolor` attribute

All colors are defined at <https://plantuml.com/en/color>

Namespace separator character is escaped in the attribute name, while **cluster** identify a subgraph
