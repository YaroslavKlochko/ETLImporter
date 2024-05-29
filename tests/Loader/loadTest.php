<?php

namespace Loader;

use PHPUnit\Framework\TestCase;

require_once 'src/Loader/load.php';

class loadTest extends TestCase
{
    public function testInsertForLoadData()
    {
        $pdoMock = $this->getMockBuilder(PDO::class)
            ->disableOriginalConstructor()
            ->getMock();

        $pdoStatementMock = $this->getMockBuilder(PDOStatement::class)
            ->getMock();

        $pdoMock->expects($this->exactly(2))
            ->method('prepare')
            ->willReturn($pdoStatementMock);

        loadData($pdoMock, 'test_table', [['id' => 1, 'name' => 'User', 'age' => 20]]);
    }

    public function testUpdateForLoadData()
    {
        $pdoMock = $this->getMockBuilder(PDO::class)
            ->disableOriginalConstructor()
            ->getMock();

        $pdoStatementMock = $this->getMockBuilder(PDOStatement::class)
            ->getMock();

        $pdoMock->expects($this->exactly(2))
            ->method('prepare')
            ->willReturn($pdoStatementMock);

        $pdoStatementMock->expects($this->any())
            ->method('fetchColumn')
            ->willReturn(1);

        loadData($pdoMock, 'test_table', [['id' => 1, 'name' => 'User', 'age' => 20]]);
    }
}
