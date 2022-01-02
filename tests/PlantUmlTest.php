<?php declare(strict_types=1);
/**
 * This file is part of the Graph-PlantUML package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Laurent Laville
 */

use Bartlett\GraphPlantUml\PlantUmlGenerator;
use Bartlett\GraphUml\ClassDiagramBuilder;
use Graphp\Graph\Graph;

/**
 * @author Laurent Laville
 */
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
        // editorconfig-checker-disable
        $expected = <<<PUML
@startuml
@enduml

PUML;
        // editorconfig-checker-enable

        $this->assertEquals($expected, $this->generator->createScript($this->graph));
    }

    public function testGraphIsolatedVertices()
    {
        $this->builder->createVertexClass('A');
        $this->builder->createVertexClass('B');

        // editorconfig-checker-disable
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
        // editorconfig-checker-enable

        $this->assertEquals($expected, $this->generator->createScript($this->graph));
    }

    public function testGraphConnectedVertices()
    {
        $this->builder->createVertexClass('C');

        // editorconfig-checker-disable
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
        // editorconfig-checker-enable

        $this->assertEquals($expected, $this->generator->createScript($this->graph));
    }

    public function testGraphAttributes()
    {
        $this->graph->setAttribute('graph.bgcolor', 'transparent');
        $this->graph->setAttribute('graph.rankdir', 'LR');

        // editorconfig-checker-disable
        $expected = <<<PUML
@startuml

skinparam backgroundColor transparent
left to right direction
@enduml

PUML;
        // editorconfig-checker-enable

        $this->assertEquals($expected, $this->generator->createScript($this->graph));
    }

    public function testUnknownGraphAttributesWillBeDiscarded()
    {
        $this->graph->setAttribute('graph.bgcolor', 'transparent');
        $this->graph->setAttribute('graph.unknown', 'dummy');

        // editorconfig-checker-disable
        $expected = <<<PUML
@startuml

skinparam backgroundColor transparent
@enduml

PUML;
        // editorconfig-checker-enable

        $this->assertEquals($expected, $this->generator->createScript($this->graph));
    }

}
