<!-- markdownlint-disable MD013 MD024 -->
# Change Log

All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/),
using the [Keep a CHANGELOG](http://keepachangelog.com) principles.

## [Unreleased]

## [1.2.1] - 2022-01-04

### Fixed

`bartlett/graph-uml` package compatibility with `graphp/graph` (commit 04461a7) and `graphp/graphviz` (commit 5872f6b)

## [1.2.0] - 2022-01-02

### Changed

- `.github/workflows/gh-pages.yml` workflow to generate dynamically UML graphs
- simplify examples now `resources/graph-uml/build.php` script exists

### Fixed

- Layout Vertex for PHP Extensions graph.
- Default Formatter for PHP Extensions graph.

## [1.1.0] - 2021-12-24

### Changed

- `Bartlett\GraphPlantUml\PlantUmlGenerator::createImageFile` returns now the command used to generate image file rather than temporary file
- update all examples to generate image in target folder, if provided as first argument

## [1.0.1] - 2021-12-01

### Fixed

- Use `AbstractFormatter::getParameterDefaultValue` to handle default value of optional parameters in function signatures.

## [1.0.0] - 2021-12-01

### Added

- GitHub workflow to build/deploy documentation with mkdocs/[mkdocs-material](https://github.com/squidfunk/mkdocs-material)
- GitHub workflow to run [Mega-Linter](https://github.com/megalinter/megalinter) QA tool

### Changed

- switch LICENSE from BSD 3-Clause "New" or "Revised" License to MIT

## [1.0.0-rc.3] - 2021-11-20

### Changed

- Allow installation with PHP 8
- Remove `graphp/graphviz` fork usage since `bartlett/graph-uml` 1.0.0-rc.3

### Fixed

- `php-extensions` example about namespace group

## [1.0.0-rc.2] - 2020-09-10

- sync with `bartlett/graph-uml` 1.0.0-rc.2
  - See <https://github.com/llaville/graph-uml/blob/master/CHANGELOG.md#100-rc2---2020-09-10>

## [1.0.0-rc.1] - 2020-05-30

### Fixed

- minor documentation updates

## [1.0.0-beta.1] - 2020-05-26

### Added

- add some unit tests case
- add documentation in MarkDown format.

### Changed

- change case of options names
from [Kebab case](https://en.wikipedia.org/wiki/Letter_case#Special_case_styles) to [Snake case](https://en.wikipedia.org/wiki/Snake_case)

### Fixed

- minor other QA (thanks to all tools available in <https://github.com/jakzal/phpqa>)
- when `group` attribute is not explicitly specified, there is no namespace

## [0.4.0] - 2020-05-14

### Added

- add encoding (base64 safe url) optional behavior to `createScript` function.

### Changed

- better support to subgraph cluster attributes
  - require now [bartlett/graph-uml](https://github.com/llaville/graph-uml) version 0.8 or greater
  - see `examples/graphuml-architecture/plantuml.php` to learn how to use

## [0.3.0] - 2020-05-12

### Added

- add support to `show-properties` and `show-methods` options

## [0.2.1] - 2020-05-11

### Changed

- avoid blank line after `@startuml` when there are no skin parameters or graph orientation
- avoid blank line at end of operations list of each entity
- fix wrong indentation with class constants
- avoid extra blank between visibility and stereotype of each field (class property)

## [0.2.0] - 2020-05-05

### Added

- add support to graph orientation and background-colors.

## [0.1.1] - 2020-05-03

### Fixed

- subgraph with namespaces are not correctly renderer

## [0.1.0] - 2020-05-03

preview release features include :

- build UML [Class diagram](https://en.wikipedia.org/wiki/Class_diagram)
- provides `plantuml.jar` to draw images locally (with help of <https://github.com/jawira/plantuml> project)
