<!-- markdownlint-disable MD013 -->
# Draw application UML

In this example, we will learn how to personalize render of this package UML diagram.

```php
<?php
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
```

**NOTE** Usage of `getPrefix()` is not necessary here. We keep it, in case you'll have custom generator rather than the default one.

* We specify a transparent background color with `graph.bgcolor` attribute
* We specify the background color of `Bartlett\GraphPlantUml` namespace with `cluster.Bartlett\\GraphPlantUml.graph.bgcolor` attribute
* We specify the background color of `Bartlett\GraphUml\Generator` namespace with `cluster.Bartlett\\GraphUml.graph.bgcolor` attribute

All colors are defined at <https://plantuml.com/en/color>

Namespace separator character is escaped in the attribute name, while **cluster** identify a subgraph
