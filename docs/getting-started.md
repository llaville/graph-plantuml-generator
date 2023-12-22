<!-- markdownlint-disable MD013 -->
# Getting started

## Requirements

* PHP 8.1 or greater
* [bartlett/graph-uml](https://github.com/llaville/graph-uml)
* [jawira/plantuml-encoding](https://github.com/jawira/plantuml-encoding)

## Installation

### With Composer

The recommended way to install this library is [through composer](http://getcomposer.org).
If you don't know yet what is composer, have a look [on introduction](http://getcomposer.org/doc/00-intro.md).

```shell
composer require bartlett/graph-plantuml-generator
```

### With Git

The GraPHP-PlantUML can be directly used from [GitHub](https://github.com/llaville/graph-plantuml-generator.git)
by cloning the repository into a directory of your choice.

```shell
git clone https://github.com/llaville/graph-plantuml-generator.git
```

Additionally, you'll have to install PlantUML jar and Java Runtime (java executable).
Users of Debian/Ubuntu-based distributions may simply invoke:

```bash
sudo apt update
sudo apt-get install openjdk-17-jre-headless
```

while remaining users should install from [PlantUML Download](https://plantuml.com/en/download) page.

You can also use the PlantUML demo server at <http://www.plantuml.com/plantuml/uml/>
