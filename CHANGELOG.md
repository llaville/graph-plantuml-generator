# Change Log

All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/),
using the [Keep a CHANGELOG](http://keepachangelog.com) principles.

## [Unreleased]

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
