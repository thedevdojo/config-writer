<?php

namespace Devdojo\ConfigWriter;

use Exception;
use Devdojo\ConfigWriter\DataWriter\FileWriter;
use Illuminate\Config\Repository as RepositoryBase;

class Repository extends RepositoryBase
{
    /**
     * The config rewriter object.
     *
     * @var Devdojo\ConfigWriter\FileWriter
     */
    protected $writer;

    /**
     * Create a new configuration repository.
     *
     * @param  Devdojo\ConfigWriter\FileWriter $writer
     * @param  array $items
     * @return void
     */
    public function __construct(FileWriter $writer, array $items = [])
    {
        parent::__construct($items);
        $this->writer = $writer;
    }

    /**
     * Write a given configuration value to file.
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function write(string $key, $value): bool
    {
        list($filename, $item) = $this->getFileAndReturnConfigProperty($key);

        $result = $this->writer->write($item, $value, $filename);

        if(!$result) throw new Exception('File could not be written to');

        $this->set($key, $value);

        return $result;
    }

    private function getFileAndReturnConfigProperty(string $key): array
    {
        $pathParts = explode('.', $key);
        $path = base_path('config');
        $foundFile = null;
        $remainingKey = '';

        for ($i = 0; $i < count($pathParts); $i++) {
            $path .= '/' . $pathParts[$i];
            $testPath = $path . '.php';
            if (file_exists($testPath)) {
                $foundFile = $testPath;
                $remainingKey = implode('.', array_slice($pathParts, $i + 1));
                break;
            }
        }

        if (!$foundFile) {
            throw new Exception("Configuration file for '{$key}' not found.");
        }

        return [$foundFile, $remainingKey];
    }

    /**
     * Split key into 2 parts. The first part will be the filename
     * 
     * @param string $key
     * @return array
     */
    private function parseKey(string $key): array
    {
        return preg_split('/\./', $key, 2);
    }
}