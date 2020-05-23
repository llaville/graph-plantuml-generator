<?php

use Bartlett\GraphPlantUml\PlantUmlGenerator;
use Bartlett\GraphUml\ClassDiagramBuilder;
use Graphp\Graph\Graph;

class PlantUmlTest extends TestCase
{
    private $generator;
    private $builder;
    private $graph;

    public function setup(): void
    {
        $this->generator = new PlantUmlGenerator();
        $this->graph = new Graph();
        $this->builder = new ClassDiagramBuilder($this->generator, $this->graph);
    }

    public function testGraphEmpty()
    {
        $expected = <<<PUML
@startuml
@enduml

PUML;
        $this->assertEquals($expected, $this->generator->createScript($this->graph));
    }

    public function testGraphIsolatedVertices()
    {
        $this->builder->createVertexClass('A');
        $this->builder->createVertexClass('B');

        $expected = <<<PUML
@startuml
  class A << class >> {
    --
  }
  class B << class >> {
    --
  }
@enduml

PUML;

        $this->assertEquals($expected, $this->generator->createScript($this->graph));
    }

    public function testGraphConnectedVertices()
    {
        $this->builder->createVertexClass('C');

        $expected = <<<PUML
@startuml
  class C << class >> {
    --
    +count()
  }
  interface Countable << interface >> {
    --
    +{abstract}count()
  }
C ..|> Countable
@enduml

PUML;

        $this->assertEquals($expected, $this->generator->createScript($this->graph));
    }

    public function testGraphAttributes()
    {
        $this->graph->setAttribute('graph.bgcolor', 'transparent');
        $this->graph->setAttribute('graph.rankdir', 'LR');

        $expected = <<<PUML
@startuml

skinparam backgroundColor transparent
left to right direction
@enduml

PUML;

        $this->assertEquals($expected, $this->generator->createScript($this->graph));
    }

    public function testUnknownGraphAttributesWillBeDiscarded()
    {
        $this->graph->setAttribute('graph.bgcolor', 'transparent');
        $this->graph->setAttribute('graph.unknown', 'dummy');

        $expected = <<<PUML
@startuml

skinparam backgroundColor transparent
@enduml

PUML;

        $this->assertEquals($expected, $this->generator->createScript($this->graph));
    }

}
