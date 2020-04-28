# bartlett/graph-plantuml-generator

Generate UML diagrams in [PlantUML](https://plantuml.com/) format.

> Note: This project is in beta stage! Feel free to report any issues you encounter.

## Features

The main features provided by this library are:

* build UML statements of a class diagram

## Install

The recommended way to install this library is [through composer](http://getcomposer.org).
If you don't know yet what is composer, have a look [on introduction](http://getcomposer.org/doc/00-intro.md).

```bash
composer require bartlett/graph-plantuml-generator
```

Additionally, you'll have to install PlantUML jar and Java Runtime.

while remaining users should install from [PlantUML Download](https://plantuml.com/fr/download) page.

You can also use the PlantUML demo server at http://www.plantuml.com/plantuml/uml/

## Quick Start

Once [installed](#install), you can use the following code to draw an UML class
diagram for your existing classes:

```php
<?php

use Bartlett\GraphUml\ClassDiagramBuilder;
use Bartlett\GraphPlantUml\PlantUmlGenerator;

use Graphp\Graph\Graph;

$generator = new PlantUmlGenerator();
$graph = new Graph();
$builder = new ClassDiagramBuilder(
    $generator,
    $graph,
    [
        'label-format' => 'default',
        'indent-string' => '  ',
    ]
);

$builder->createVertexClass(ClassDiagramBuilder::class);

// show UML diagram statements
echo $generator->render($graph);
```

## Documentation

TODO

## Resources

* Demo online [PlantUML Server](http://www.plantuml.com/plantuml/uml/).
* Official docker image of [PlantUML Server](https://hub.docker.com/r/plantuml/plantuml-server/) over Jetty or Tomcat.
* [PlantUML Server](https://github.com/plantuml/plantuml-server) is a web application to generate UML diagrams on-the-fly.
* [PlantText](https://www.planttext.com/) is UML online editor.
* [Kroki](https://github.com/yuzutech/kroki) creates diagrams from textual descriptions.
* [Real World PlantUML](https://real-world-plantuml.com/) examples.
* Composer package to provide [PlantUML executable](https://github.com/Jawira/plantuml) and jar.
