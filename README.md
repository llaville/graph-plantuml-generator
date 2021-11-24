[![Latest Stable Version](https://img.shields.io/packagist/v/bartlett/graph-plantuml-generator.svg?style=flat-square)](https://packagist.org/packages/bartlett/graph-plantuml-generator)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.1-8892BF.svg?style=flat-square)](https://php.net/)
![License](https://img.shields.io/github/license/llaville/graph-plantuml-generator)
[![Mega-Linter](https://github.com/llaville/graph-plantuml-generator/actions/workflows/mega-linter.yml/badge.svg)](https://github.com/llaville/graph-plantuml-generator/actions/workflows/mega-linter.yml)

# bartlett/graph-plantuml-generator

Generate UML diagrams in [PlantUML](https://plantuml.com/) format.

> Note: This project is in beta stage! Feel free to report any issues you encounter.

## Features

The main features provided by this library are:

* build UML statements of a class diagram
* build image in one of the [supported formats](https://plantuml.com/en/command-line) with local `plantuml.jar` executable

## Install

The recommended way to install this library is [through composer](http://getcomposer.org).
If you don't know yet what is composer, have a look [on introduction](http://getcomposer.org/doc/00-intro.md).

```bash
composer require bartlett/graph-plantuml-generator
```

Additionally, you'll have to install PlantUML jar and Java Runtime (java executable).
Users of Debian/Ubuntu-based distributions may simply invoke:

```bash
$ sudo apt update
$ sudo apt-get install openjdk-11-jre-headless
```

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
echo $generator->createImageFile($graph) . ' file generated' . PHP_EOL;
```

That should give such output:

![Single Class UML](./docs/single_class.png)

**NOTE** You can use `$generator->getPrefix()` (that will return blank, because its not used here),
for each `setAttribute` if you want to keep the same syntax for whatever generator.

## Documentation

Full documentation is written in MarkDown format, and HTML export is possible with [Daux.io](https://github.com/dauxio/daux.io).
See output results at http://bartlett.laurent-laville.org/graph-uml/ or raw `*.md` files in `docs` folder.

**Table of Contents**

* **Features**
  - [Formatters](docs/01_Features/Formatters.md)

* **Cookbook**
  - [Personalize render](docs/02_Cookbook/Draw_App_Logo.md)

## Resources

* Demo online [PlantUML Server](http://www.plantuml.com/plantuml/uml/).
* Official docker image of [PlantUML Server](https://hub.docker.com/r/plantuml/plantuml-server/) over Jetty or Tomcat.
* [PlantUML Server](https://github.com/plantuml/plantuml-server) is a web application to generate UML diagrams on-the-fly.
* [PlantText](https://www.planttext.com/) is UML online editor.
* [Kroki](https://github.com/yuzutech/kroki) creates diagrams from textual descriptions.
* [Real World PlantUML](https://real-world-plantuml.com/) examples.
* Composer package to provide [PlantUML executable](https://github.com/Jawira/plantuml) and jar.
* [PlantUML Language Reference Guide (pdf)](http://plantuml.com/PlantUML_Language_Reference_Guide.pdf).
* [PlantUML encoding functions for PHP](https://github.com/jawira/plantuml-encoding).
* [Markdown native diagrams with PlantUML](https://blog.anoff.io/2018-07-31-diagrams-with-plantuml/) in GitLab or GitHub.

## Contributors

* Laurent Laville (Lead Developer)
