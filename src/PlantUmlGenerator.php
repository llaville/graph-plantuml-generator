<?php
declare(strict_types=1);

namespace Bartlett\GraphPlantUml;

use Bartlett\GraphPlantUml\Formatter\DefaultFormatter;
use Bartlett\GraphUml\Formatter\FormatterInterface;
use Bartlett\GraphUml\Generator\AbstractGenerator;
use Bartlett\GraphUml\Generator\GeneratorInterface;

use Graphp\Graph\EdgeDirected;
use Graphp\Graph\Entity;
use Graphp\Graph\Graph;
use Graphp\Graph\Vertex;

class PlantUmlGenerator extends AbstractGenerator implements GeneratorInterface
{
    private const EOL = PHP_EOL;

    public function __construct()
    {
        /**
         * Usually, your java executables should be located in your $PATH
         * environment variable and invoking a mere `java` is sufficient. If you
         * have no access to your $PATH variable, use this method to set the path
         * to your java runtime executable.
         *
         * This should contain '.exe' on windows.
         * - /full/path/to/bin/java
         * - java.exe
         * - c:\path\to\bin\java.exe
         */
        $this->setExecutable('java -jar plantuml.jar');
        // (invoke 'java -jar plantuml.jar -help' for details on available formats)
        $this->setFormat('png');
    }

    public function setOptions(array $values): void
    {
        $options = $values;

        // String to use as namespace separator (because PlantUML does not allow native PHP Namespace separator)
        if (!isset($options['namespace-separator'])) {
            $options['namespace-separator'] = '.';
        }

        parent::setOptions($options);
    }

    public function getFormatter(): FormatterInterface
    {
        return new DefaultFormatter($this->options);
    }

    public function getName(): string
    {
        return 'plantuml';
    }

    public function createScript(Graph $graph): string
    {
        // build an array to map vertex hashes to vertex IDs for output
        $groups = [];
        foreach ($graph->getVertices() as $vertex) {
            if ($vertex instanceof Vertex) {
                $groups[$vertex->getAttribute('group', 0)][] = $vertex;
            }
        }

        $script = ['@startuml'];

        $script[] = $this->getLayoutGraph($graph)['label'] ?? '';

        if (count($groups) > 1) {
            // add subgraph cluster attributes
            $clusters = array(
                'graph' => $this->getName() . '.subgraph.cluster_%d.graph.',
                'node'  => $this->getName() . '.subgraph.cluster_%d.node.',
                'edge'  => $this->getName() . '.subgraph.cluster_%d.edge.',
            );
            $gid = 0;
            // put each group of vertices in a separate subgraph cluster
            foreach ($groups as $group => $vertices) {
                $prefix = $clusters['graph'];
                $layout = $this->getAttributesPrefixed($graph, sprintf($prefix, $gid));
                $bgColor = ($layout['bgcolor'] ?? '');
                if (!empty($bgColor)) {
                    $bgColor = ' #' . ltrim($bgColor, "#");
                }
                $script[] = 'namespace ' . str_replace('\\', $this->options['namespace-separator'], $group) . $bgColor . ' {';
                foreach ($vertices as $vertex) {
                    $script[] = $this->getLayoutVertex($vertex)['label'] ?? '';
                }
                $script[] = '}';
                $gid++;
            }
        } else {
            foreach ($graph->getVertices() as $vertex) {
                $script[] = $this->getLayoutVertex($vertex)['label'] ?? '';
            }
        }

        // add all edges as directed edges
        foreach ($graph->getEdges() as $currentEdge) {
            $script[] = $this->getLayoutEdge($currentEdge)['label'] ?? '';
        }

        $script[] = '@enduml';
        $script[] = '';

        return implode(PHP_EOL, $script);
    }

    public function createImageFile(Graph $graph, string $cmdFormat = ''): string
    {
        if (empty($cmdFormat)) {
            // default command format, when none provided
            $cmdFormat = sprintf(
                '%s -t%s %s -filename %s',
                self::CMD_EXECUTABLE,
                self::CMD_FORMAT,
                self::CMD_TEMP_FILE,
                self::CMD_OUTPUT_FILE
            );
        }

        return parent::createImageFile($graph, $cmdFormat);
    }

    private function getLayoutGraph(Graph $graph): array
    {
        $layout = $this->getAttributesPrefixed($graph, $this->getName() . '.graph.');

        if (isset($layout['bgcolor'])) {
            $layout['bgcolor'] = ltrim($layout['bgcolor'], "#");
            $dashPrefix = strcasecmp($layout['bgcolor'], 'transparent') === 0 ? '' : '#';
            $layout['label'] = 'skinparam backgroundColor ' . $dashPrefix . $layout['bgcolor'];
        }

        return $layout;
    }

    private function getLayoutVertex(Vertex $vertex): array
    {
        $layout = $this->getAttributesPrefixed($vertex, $this->getName() . '.');

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
        $layout = $this->getAttributesPrefixed($edge, $this->getName() . '.');

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

    /**
     * @param Entity $entity
     * @param string $prefix
     * @return array
     */
    private function getAttributesPrefixed(Entity $entity, $prefix): array
    {
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
