# Change Log

All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/),
using the [Keep a CHANGELOG](http://keepachangelog.com) principles.

## [Unreleased]

### Added

* add some unit tests case

### Changed

* change case of options names
from [Kebab case](https://en.wikipedia.org/wiki/Letter_case#Special_case_styles) to [Snake case](https://en.wikipedia.org/wiki/Snake_case)

### Fixed

* minor other QA (thanks to all tools available in https://github.com/jakzal/phpqa)

## [0.4.0] - 2020-05-14

### Added

* add encoding (base64 safe url) optional behavior to `createScript` function.

### Changed

* better support to subgraph cluster attributes
  - require now [bartlett/graph-uml](https://github.com/llaville/graph-uml) version 0.8 or greater
  - see `examples/graphuml-architecture/plantuml.php` to learn how to use

## [0.3.0] - 2020-05-12

### Added

* add support to `show-properties` and `show-methods` options

## [0.2.1] - 2020-05-11

### Changed

* avoid blank line after `@startuml` when there are no skin parameters or graph orientation
* avoid blank line at end of operations list of each entity
* fix wrong indentation with class constants
* avoid extra blank between visibility and stereotype of each field (class property)

## [0.2.0] - 2020-05-05

### Added

* add support to graph orientation and background-colors.

## [0.1.1] - 2020-05-03

### Fixed

* subgraph with namespaces are not correctly renderer

## [0.1.0] - 2020-05-03

preview release features include :

* build UML [Class diagram](https://en.wikipedia.org/wiki/Class_diagram)
* provides `plantuml.jar` to draw images locally (with help of https://github.com/jawira/plantuml project)
