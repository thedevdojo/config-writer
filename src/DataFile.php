<?php

namespace Devdojo\ConfigWriter;

use Devdojo\ConfigWriter\Contracts\DataFileInterface;

abstract class DataFile implements DataFileInterface
{
    /**
     * Abstract syntax tree
     *
     * @var mixed
     */
    protected $ast = [];

    /**
     * Get currently loaded AST
     *
     * @return \PhpParser\Node\Stmt[]|array|null
     */
    public function getAst()
    {
        return $this->ast;
    }
}
