<?php
declare(strict_types=1);

namespace Bartlett\GraphPlantUml;

use Bartlett\GraphPlantUml\Formatter\DefaultFormatter;
use Bartlett\GraphUml\Formatter\FormatterInterface;
use Bartlett\GraphUml\Generator\AbstractGeneratorTrait;
use Bartlett\GraphUml\Generator\GeneratorInterface;

use Graphp\Graph\EdgeDirected;
use Graphp\Graph\Entity;
use Graphp\Graph\Graph;
use Graphp\Graph\Vertex;

class PlantUmlGenerator implements GeneratorInterface
{
    private const EOL = PHP_EOL;

    use AbstractGeneratorTrait {
        setOptions as declareOptions;
    }

    public function setOptions(array $values): void
    {
        $options = $values;

        // String to use as namespace separator (because PlantUML does not allow native PHP Namespace separator)
        if (!isset($options['namespace-separator'])) {
            $options['namespace-separator'] = '.';
        }

        $this->declareOptions($options);
    }

    public function getFormatter(): FormatterInterface
    {
        return new DefaultFormatter($this->options);
    }

    public function getName(): string
    {
        return 'plantuml';
    }

    public function render(Graph $graph): string
    {
        // build an array to map vertex hashes to vertex IDs for output
        $groups = [];
        foreach ($graph->getVertices() as $vertex) {
            if ($vertex instanceof Vertex) {
                $groups[$vertex->getAttribute('group', 0)][] = $vertex;
            }
        }

        $script = ['@startuml'];

        if (count($groups) > 1) {
            $indent = str_repeat($this->options['indent-string'], 2);
            // put each group of vertices in a separate subgraph cluster
            foreach ($groups as $group => $vertices) {
                $script[] = 'namespace ' . str_replace('\\', $this->options['namespace-separator'], $group) . ' {';
                foreach ($vertices as $vertex) {
                    $script[] = $this->getLayoutVertex($vertex)['label'] ?? '';
                }
                $script[] = '}';
            }
        } else {
            //$script[] = 'namespace global {';
            foreach ($graph->getVertices() as $vertex) {
                $script[] = $this->getLayoutVertex($vertex)['label'] ?? '';
            }
            //$script[] = '}';
        }

        // add all edges as directed edges
        foreach ($graph->getEdges() as $currentEdge) {
            $script[] = $this->getLayoutEdge($currentEdge)['label'] ?? '';
        }

        $script[] = '@enduml';
        $script[] = '';

        return implode(PHP_EOL, $script);
    }

    private function getLayoutVertex(Vertex $vertex): array
    {
        $layout = $this->getAttributesPrefixed($vertex);

        $shortName = explode('\\', $vertex->getAttribute('id'));
        $shortName = array_pop($shortName);

        $stereotype = $vertex->getAttribute('stereotype', 'class');

        $indent = $this->options['indent-string'];

        $label = $indent
            . "$stereotype $shortName "
            . '<< ' . $stereotype . ' >> '
            . '{'
            . self::EOL
            . $layout['label_' . $this->getFormatter()->getFormat()]
            . self::EOL
            . $indent . '}'
        ;

        $layout['label'] = $label;

        return $layout;
    }

    private function getLayoutEdge(EdgeDirected $edge): array
    {
        $layout = $this->getAttributesPrefixed($edge);

        if ($layout['style'] === 'dashed') {
            // implementation
            $edgeop = '..|>';
        } else {
            // inheritance
            $edgeop = '--|>';
        }

        $layout['label'] = (str_replace('\\', '.', $edge->getVertexStart()->getAttribute('id')))
            . " $edgeop "
            . (str_replace('\\', '.', $edge->getVertexEnd()->getAttribute('id')))
        ;

        return $layout;
    }

    private function getAttributesPrefixed(Entity $entity): array
    {
        $prefix = $this->getName() . '.';

        $len = \strlen($prefix);
        $attributes = [];
        foreach ($entity->getAttributes() as $name => $value) {
            if (\strpos($name, $prefix) === 0) {
                $attributes[substr($name, $len)] = $value;
            }
        }

        return $attributes;
    }
}
