<?php
  class Db {

    private static $instance = NULL;

    public function __construct() {}

    private function __clone() {}

    public static function getInstance() 
    {
      if (!isset(self::$instance))
      {
          self::$instance = mssql_connect($_SERVER['DB_HOSTNAME'], $_SERVER['DB_USERNAME'], $_SERVER['DB_PASSWORD']);
          mssql_select_db($_SERVER['DB_DATABASE'], self::$instance);
      }
      return self::$instance;
    }

    public function getConnection() 
    {
      if (!isset(self::$instance))
      {
          self::$instance = mssql_connect($_SERVER['DB_HOSTNAME'], $_SERVER['DB_USERNAME'], $_SERVER['DB_PASSWORD']);
          mssql_select_db($_SERVER['DB_DATABASE'], self::$instance);
      }
      return self::$instance;
    }

    public function RunQuery($sql, $kill = 0)
    {
        $conn = $this -> getInstance();

        $response = [];

        $stmt = mssql_query ( $sql , $conn );
        
        if( gettype($stmt) != "boolean" )
        {
            while($row = mssql_fetch_assoc($stmt))
            {
                array_push($response, $row);
                if($kill == 2)
                    die(var_dump($response));
            }
        }
        else
        {
            // Error 
        }

        if(count($response) > 1)
            return $response;
        else if(isset($response[0]))
            return $response[0];
        else
            return $response;
    }

    public function RunInsert($sql, $kill = 0)
    {
        $conn = $this -> getInstance();

        $response = [];

        $stmt = mssql_query ( $sql , $conn );

        if( $stmt === false )
        { 
            $this -> Failed(self::INVALIDQUERYEC);
        }
        else
        {
            return true;
        }
    }

    public function RunDelete($sql, $kill = 0)
    {
        $conn = $this -> getInstance();

        $response = [];

        $stmt = mssql_query ( $sql , $conn );

        if( $stmt === false )
        { 
            $this -> Failed(self::INVALIDQUERYEC);
        }
        else
        {
            return true;
        }
    }

    public function ExecuteProcedure($sql,$args)
    {
        $conn = $this -> getInstance();
        
        $proc = mssql_init($sql, $conn);

        mssql_bind($proc, '@student', $args, SQLTEXT);

        // Execute the statement
        $result = mssql_execute($proc);

        mssql_free_statement($proc);

        $response = [];
        while($row = mssql_fetch_assoc($result))
        {
            array_push($response, $row);
        }

        if(count($response) > 1)
            return $response;
        else if(isset($response[0]))
            return $response[0];
        else
            return $response;
    }

    public function ExecuteStoredProcedureSingleArg($sql,$arg,$param)
    {
        $conn = $this -> getInstance();
        
        $proc = mssql_init($sql, $conn);

        mssql_bind($proc, $param, $arg, SQLTEXT);

        // Execute the statement
        $result = mssql_execute($proc);

        mssql_free_statement($proc);

        $response = [];
        while($row = mssql_fetch_assoc($result))
        {
            array_push($response, $row);
        }

        if(count($response) > 1)
            return $response;
        else if(isset($response[0]))
            return $response[0];
        else
            return $response;
    }

    public function ExecuteStoredProcedureSingleInt($sql,$arg,$param)
    {
        $conn = $this -> getInstance();
        
        $proc = mssql_init($sql, $conn);

        mssql_bind($proc, $param, $arg, SQLINT1);

        // Execute the statement
        $result = mssql_execute($proc);

        mssql_free_statement($proc);

        $response = [];
        while($row = mssql_fetch_assoc($result))
        {
            array_push($response, $row);
        }

        if(count($response) > 1)
            return $response;
        else if(isset($response[0]))
            return $response[0];
        else
            return $response;
    }

    public function ExecuteStoredProcedure($proc,$arg,$param)
    {
        $conn = $this -> getInstance();
        
        $stmt = mssql_init($proc, $conn);
        mssql_bind($stmt, $param, $arg, SQLTEXT);
        // Execute the statement
        $result = mssql_execute($stmt);
        $response = [];
        while($row = mssql_fetch_assoc($result))
        {
            array_push($response, $row);
        }
        if(count($response) > 1)
            return $response;
        else if(isset($response[0]))
            return $response[0];
        else
            return $response;
    }

    public function ExecuteStoredProcedureMultiArg($proc,$params,$args)
    {
        $conn = $this -> getInstance();
        
        $stmt = mssql_init($proc, $conn);
        foreach ($params as $key => $param) 
        {
            mssql_bind($stmt, $param, $args[$key], SQLVARCHAR);
        }

        // Execute the statement
        $result = mssql_execute($stmt);

        mssql_free_statement($stmt);

        mssql_free_statement($proc);

        $response = [];
        while($row = mssql_fetch_assoc($result))
        {
            array_push($response, $row);
        }

        if(count($response) > 1)
            return $response;
        else if(isset($response[0]))
            return $response[0];
        else
            return $response;
    }

    public function ExecuteStoredProcedureNoArg($sql)
    {
        $conn = $this -> getInstance();
        
        $proc = mssql_init($sql, $conn);

        // Execute the statement
        $result = mssql_execute($proc);

        mssql_free_statement($proc);

        $response = [];
        while($row = mssql_fetch_assoc($result))
        {
            array_push($response, $row);
        }

        if(count($response) > 1)
            return $response;
        else if(isset($response[0]))
            return $response[0];
        else
            return $response;
    }

    public function ExecuteStoredProcedureSingleVarchar($sql,$arg,$param)
    {
        $conn = $this -> getInstance();
        
        $proc = mssql_init($sql);

        mssql_bind($proc, $param, $arg, SQLVARCHAR);

        // Execute the statement
        $result = mssql_execute($proc);

        mssql_free_statement($proc);

        $response = [];

        while($row = mssql_fetch_assoc($result))
            array_push($response, $row);

        if(count($response) > 1)
            return $response;
        else if(isset($response[0]))
            return $response[0];
        else
            return $response;
    }
  }
?>