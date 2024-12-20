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

use Webmozart\Assert\InvalidArgumentException;

if ($_SERVER['argc'] == 1) {
    echo '=====================================================================', PHP_EOL;
    echo 'Usage: php examples/plantuml.php <example-dirname>', PHP_EOL;
    echo '                                 <output-folder>', PHP_EOL;
    echo '                                 <format:png|svg>', PHP_EOL;
    echo '                                 <write-statement-to-file>', PHP_EOL;
    echo '=====================================================================', PHP_EOL;
    exit();
}

$example = $_SERVER['argv'][1] ?? null;
$folder = $_SERVER['argv'][2] ?? sys_get_temp_dir();
$format = $_SERVER['argv'][3] ?? 'svg';
$writeGraphStatement = $_SERVER['argv'][4] ?? false;

$baseDir = __DIR__ . DIRECTORY_SEPARATOR . $example . DIRECTORY_SEPARATOR;
$available = is_dir($baseDir) && file_exists($baseDir);

if (empty($example) || !$available) {
    throw new RuntimeException(sprintf('Example "%s" does not exists.', $example));
}

$resources = [
    $baseDir . 'bootstrap.php',     // autoloader or any other resource to include before run this script
    $baseDir . 'datasource.php',    // list of files or classes to parse
    $baseDir . 'options.php',       // all options to customize the Graph
];

$isAutoloadFound = false;

foreach ($resources as $resource) {
    if (file_exists($resource)) {
        $variable = basename($resource, '.php');
        $$variable = require $resource;
    }
    if (isset($bootstrap) && !$isAutoloadFound) {
        $isAutoloadFound = true;
        $bootstrap();
    }
}
if (!isset($datasource)) {
    $datasource = fn() => [];
}

$generator = new PlantUmlGenerator('vendor/bin/plantuml', $format);
$graph = new Graph();
$builder = new ClassDiagramBuilder($generator, $graph, $options ?? []);

foreach ($datasource() as $i => $source) {
    try {
        if ('php-extensions' === $example) {
            $attributes = ($i === 0) ? ['fillcolor' => 'burlywood3'] : [];
            $builder->createVertexExtension($source, $attributes);
        } else {
            $builder->createVertexClass($source, $options ?? []);
        }
    } catch (InvalidArgumentException $e) {
        printf('Data source #%d: %s' . PHP_EOL, $i, $e->getMessage());
        exit(255);
    }
}

if ($writeGraphStatement) {
    // writes graphviz statements to file
    $output = rtrim($folder, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $example . '.puml';
    file_put_contents($output, $generator->createScript($graph));
}

$target = $generator->createImageFile($graph);

$from = $target;
$target = rtrim($folder, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $example . '.plantuml.' . $format;
if (!rename($from, $target)) {
    $target = null;
}
echo (empty($target) ? 'no' : $target) . ' file generated' . PHP_EOL;
