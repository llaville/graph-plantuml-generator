<?php declare(strict_types=1);
/**
 * This file is part of the Graph-PlantUML package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Laurent Laville
 */

use Bartlett\GraphUml\Filter\NamespaceFilterInterface;
use Bartlett\GraphUml\Generator\GeneratorInterface;

use Graphp\Graph\Graph;

$callback = function (Generator $vertices, GeneratorInterface $generator, Graph $graph, array $options) {
    foreach ($vertices as $fqcn) {
        $this->createVertexClass($fqcn);

        $namespaceFilter = $options['namespace_filter'];
        if ($namespaceFilter instanceof NamespaceFilterInterface) {
            $cluster = $namespaceFilter->filter($fqcn);
            if (null !== $cluster) {
                $graph->setAttribute(
                    $generator->getPrefix() . sprintf('cluster.%s.graph.bgcolor', $cluster),
                    'white'
                );
            }
        }
    }
};
