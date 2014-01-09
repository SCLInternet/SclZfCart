<?php

namespace SclZfCartTests\Mapper\Doctrine;

/**
 * @todo   Move this to a global module
 */
abstract class AbstractDatabaseTestCase extends \PHPUnit_Extensions_Database_TestCase
{
    /**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {
        // @todo Move this to an abstract class and use test database connection
        //       settings so cannot fuck up production environment.
        $pdo = new \PDO('sqlite:'. __DIR__ . '/../../../test.db');
        //$pdo = new \PDO('sqlite:' . \TestBootstrap::getDatabasePath());
        return $this->createDefaultDBConnection($pdo);
    }

    /*
    public function getSetUpOperation()
    {
        // If you want cascading truncates, false otherwise.
        // If unsure choose false.
        $cascadeTruncates = true;

        return new \PHPUnit_Extensions_Database_Operation_Composite(array(
            new TruncateOperation($cascadeTruncates),
            \PHPUnit_Extensions_Database_Operation_Factory::INSERT()
        ));
    }
    */

    /**
     * @return void
     */
    protected function setUpTestCase()
    {
    }

    protected function setUp()
    {
        parent::setUp();

        $this->setUpTestCase();
    }
}
