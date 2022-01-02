<?php declare(strict_types=1);
/**
 * This file is part of the Graph-UML package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @since Release 1.2.0
 * @author Laurent Laville
 */

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Bartlett\GraphPlantUml\PlantUmlGenerator;
use Bartlett\GraphUml\ClassDiagramBuilder;

use Graphp\Graph\Graph;

$script = $_SERVER['argv'][1] ?? null;

if (!$script) {
    throw new LogicException("Unable to build a graph UML for unknown script.");
}
$script = basename($script, '.php');

require_once implode(DIRECTORY_SEPARATOR, [__DIR__, 'datasource', $script])  . '.php';
require_once implode(DIRECTORY_SEPARATOR, [__DIR__, 'filter', $script])  . '.php';
require_once implode(DIRECTORY_SEPARATOR, [__DIR__, 'callback', $script])  . '.php';
require_once implode(DIRECTORY_SEPARATOR, [__DIR__, 'options', $script])  . '.php';

$generator = new PlantUmlGenerator();
$generator->setExecutable('vendor/bin/plantuml');
$graph = new Graph();
$builder = new ClassDiagramBuilder($generator, $graph, $options);

try {
    $builder->createVerticesFromCallable($callback, dataSource());
} catch (Exception $e) {
    echo 'Unable to build graph UML : ' . $e->getMessage() . PHP_EOL;
    die();
}

// https://plantuml.com/en/color
$graph->setAttribute($generator->getPrefix() . 'graph.bgcolor', $options['graph.bgcolor'] ?? 'transparent');

// writes plantuml statements to file
$folder = $_SERVER['argv'][2] ?? null;
$output = rtrim($folder, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $script . '.puml';
file_put_contents($output, $generator->createScript($graph));

// default format is PNG, change it to SVG
$generator->setFormat($format = 'svg');

$target = $generator->createImageFile($graph);
if (isset($folder)) {
    // target folder provided
    $from = $target;
    $target = rtrim($folder, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $script . '.plantuml.' . $format;
    if (!rename($from, $target)) {
        $target = null;
    }
}
echo (empty($target) ? 'no' : $target) . ' file generated' . PHP_EOL;
