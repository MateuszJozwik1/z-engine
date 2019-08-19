<?php
/**
 * Z-Engine framework
 *
 * @copyright Copyright 2019, Lisachenko Alexander <lisachenko.it@gmail.com>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 *
 */

namespace ZEngine;

use FFI\CData;

class Executor
{
    /**
     * Contains a hashtable with all registered classes
     *
     * @var HashTable|ValueEntry[string]
     */
    public HashTable $classTable;

    /**
     * Contains a hashtable with all registered functions
     *
     * @var HashTable|ValueEntry[]
     */
    public HashTable $functionTable;

    /**
     * Holds an internal pointer to the executor_globals structure
     */
    public CData $pointer;

    public function __construct(CData $pointer)
    {
        $this->pointer       = $pointer;
        $this->classTable    = new HashTable($pointer->class_table);
        $this->functionTable = new HashTable($pointer->function_table);
    }

    /**
     * Returns an execution state with scope, variables, etc.
     */
    public function getExecutionState(): ExecutionDataEntry
    {
        // current_execute_data refers to the getExecutionState itself, so we move to the previous item
        $executionState = new ExecutionDataEntry($this->pointer->current_execute_data->prev_execute_data);

        return $executionState;
    }
}