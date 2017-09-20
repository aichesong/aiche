<?php

namespace Camcima\MySqlDiff\Model;

class ChangedTable
{
    /**
     * @var Table
     */
    private $fromTable;

    /**
     * @var Table
     */
    private $toTable;

    /**
     * @var Column[]
     */
    private $newColumns = [];

    /**
     * @var Column[]
     */
    private $deletedColumns = [];

    /**
     * @var Column[]
     */
    private $changedColumns = [];

    /**
     * @var Column[]
     */
    private $changedPrimaryKeys = [];

    /**
     * @var bool
     */
    private $deletedPrimaryKey = false;

    /**
     * @var Index[]
     */
    private $newIndexes = [];

    /**
     * @var Index[]
     */
    private $deletedIndexes = [];

    /**
     * @var Index[]
     */
    private $changedIndexes = [];

    /**
     * @var ForeignKey[]
     */
    private $newForeignKeys = [];

    /**
     * @var ForeignKey[]
     */
    private $deletedForeignKeys = [];

    /**
     * @var ForeignKey[]
     */
    private $changedForeignKeys = [];

    /**
     * @param Table $fromTable
     * @param Table $toTable
     */
    public function __construct(Table $fromTable, Table $toTable)
    {
        $this->fromTable = $fromTable;
        $this->toTable = $toTable;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->toTable->getName();
    }

    /**
     * @return Table
     */
    public function getFromTable()
    {
        return $this->fromTable;
    }

    /**
     * @return Table
     */
    public function getToTable()
    {
        return $this->toTable;
    }

    /**
     * @return Column[]
     */
    public function getNewColumns()
    {
        return $this->newColumns;
    }

    /**
     * @param Column $newColumn
     */
    public function addNewColumn(Column $newColumn)
    {
        $this->newColumns[$newColumn->getName()] = $newColumn;

        if (isset($this->changedColumns[$newColumn->getName()])) {
            unset($this->changedColumns[$newColumn->getName()]);
        }
    }

    /**
     * @param $columnName
     *
     * @return bool
     */
    public function hasNewColumn($columnName)
    {
        return isset($this->newColumns[$columnName]);
    }

    /**
     * @return Column[]
     */
    public function getDeletedColumns()
    {
        return $this->deletedColumns;
    }

    /**
     * @param Column $deletedColumn
     */
    public function addDeletedColumn(Column $deletedColumn)
    {
        $this->deletedColumns[$deletedColumn->getName()] = $deletedColumn;
    }

    /**
     * @return Column[]
     */
    public function getChangedColumns()
    {
        return $this->changedColumns;
    }

    /**
     * @param Column $changedColumn
     */
    public function addChangedColumn(Column $changedColumn)
    {
        if (!isset($this->changedColumns[$changedColumn->getName()])) {
            $this->changedColumns[$changedColumn->getName()] = $changedColumn;
        }
    }

    /**
     * @return Column[]
     */
    public function getChangedPrimaryKeys()
    {
        return $this->changedPrimaryKeys;
    }

    /**
     * @param Column[] $changedPrimaryKeys
     */
    public function setChangedPrimaryKeys($changedPrimaryKeys)
    {
        $this->changedPrimaryKeys = $changedPrimaryKeys;
    }

    /**
     * @return bool
     */
    public function isDeletedPrimaryKey()
    {
        return $this->deletedPrimaryKey;
    }

    /**
     * @param bool $deletedPrimaryKey
     */
    public function setDeletedPrimaryKey($deletedPrimaryKey)
    {
        $this->deletedPrimaryKey = $deletedPrimaryKey;
    }

    /**
     * @return Index[]
     */
    public function getNewIndexes()
    {
        return $this->newIndexes;
    }

    /**
     * @param Index $newIndex
     */
    public function addNewIndex(Index $newIndex)
    {
        $this->newIndexes[$newIndex->getName()] = $newIndex;
    }

    /**
     * @return Index[]
     */
    public function getDeletedIndexes()
    {
        return $this->deletedIndexes;
    }

    /**
     * @param Index $deletedIndex
     */
    public function addDeletedIndex(Index $deletedIndex)
    {
        $this->deletedIndexes[$deletedIndex->getName()] = $deletedIndex;
    }

    /**
     * @return Index[]
     */
    public function getChangedIndexes()
    {
        return $this->changedIndexes;
    }

    /**
     * @param Index $changedIndex
     */
    public function addChangedIndex(Index $changedIndex)
    {
        $this->changedIndexes[$changedIndex->getName()] = $changedIndex;
    }

    /**
     * @return ForeignKey[]
     */
    public function getNewForeignKeys()
    {
        return $this->newForeignKeys;
    }

    /**
     * @param ForeignKey $newForeignKey
     */
    public function addNewForeignKey(ForeignKey $newForeignKey)
    {
        $this->newForeignKeys[$newForeignKey->getName()] = $newForeignKey;
    }

    /**
     * @return ForeignKey[]
     */
    public function getDeletedForeignKeys()
    {
        return $this->deletedForeignKeys;
    }

    /**
     * @param ForeignKey $deletedForeignKey
     */
    public function addDeletedForeignKey(ForeignKey $deletedForeignKey)
    {
        $this->deletedForeignKeys[$deletedForeignKey->getName()] = $deletedForeignKey;
    }

    /**
     * @return ForeignKey[]
     */
    public function getChangedForeignKeys()
    {
        return $this->changedForeignKeys;
    }

    /**
     * @param ForeignKey $changedForeignKey
     */
    public function addChangedForeignKey(ForeignKey $changedForeignKey)
    {
        $this->changedForeignKeys[$changedForeignKey->getName()] = $changedForeignKey;
    }

    /**
     * @return string
     */
    public function generateAlterScript()
    {
        $tableChanges = [];
	
		$from_pk = $this->fromTable->getPrimaryKeys();
        if ($this->deletedPrimaryKey || (!empty($from_pk) && !empty($this->changedPrimaryKeys))) {
            $tableChanges[] = 'DROP PRIMARY KEY';
        }

        foreach ($this->deletedForeignKeys as $deletedForeignKey) {
            $tableChanges[] = sprintf('DROP FOREIGN KEY `%s`', $deletedForeignKey->getName());
        }

        foreach ($this->changedForeignKeys as $changedForeignKey) {
            $tableChanges[] = sprintf('DROP FOREIGN KEY `%s`', $changedForeignKey->getName());
        }

        foreach ($this->deletedIndexes as $deletedIndex) {
            $tableChanges[] = sprintf('DROP INDEX `%s`', $deletedIndex->getName());
        }

        foreach ($this->changedIndexes as $changedIndex) {
            $tableChanges[] = sprintf('DROP INDEX `%s`', $changedIndex->getName());
        }
		

        $columnStatements = [];

        foreach ($this->changedColumns as $changedColumn) {
            $columnStatements[$changedColumn->getOrder()] = sprintf('CHANGE COLUMN `%s` %s %s', $changedColumn->getName(), $changedColumn->generateCreationScript(), $this->getAfterClause($changedColumn));
        }

        foreach ($this->newColumns as $newColumn) {
            $columnStatements[$newColumn->getOrder()] = sprintf('ADD COLUMN %s %s', $newColumn->generateCreationScript(), $this->getAfterClause($newColumn));
        }

        ksort($columnStatements);

        foreach ($columnStatements as $columnStatement) {
            $tableChanges[] = $columnStatement;
        }

        if (!empty($this->changedPrimaryKeys)) {
            $primaryKeyColumnNames = [];
            foreach ($this->changedPrimaryKeys as $primaryKeyColumn) {
                $primaryKeyColumnNames[] = sprintf('`%s`', $primaryKeyColumn->getName());
            }

            $tableChanges[] = sprintf('ADD PRIMARY KEY (%s)', implode(',', $primaryKeyColumnNames));
        }

        foreach ($this->changedIndexes as $changedIndex) {
            $tableChanges[] = sprintf('ADD %s', $changedIndex->generateCreationScript());
        }

        foreach ($this->newIndexes as $newIndex) {
            $tableChanges[] = sprintf('ADD %s', $newIndex->generateCreationScript());
        }

        foreach ($this->changedForeignKeys as $changedForeignKey) {
            $tableChanges[] = sprintf('ADD %s', $changedForeignKey->generateCreationScript());
        }

        foreach ($this->newForeignKeys as $newForeignKey) {
            $tableChanges[] = sprintf('ADD %s', $newForeignKey->generateCreationScript());
        }

        $alterScript = sprintf('ALTER TABLE `%s`%s  %s;', $this->getName(), PHP_EOL, implode(',' . PHP_EOL . '  ', $tableChanges));

        return $alterScript;
    }

    /**
     * @param Column $column
     *
     * @return string
     */
    private function getAfterClause(Column $column)
    {
        if ($column->getPreviousColumn() instanceof Column) {
            return sprintf('AFTER `%s`', $column->getPreviousColumn()->getName());
        }

        return 'FIRST';
    }
}
