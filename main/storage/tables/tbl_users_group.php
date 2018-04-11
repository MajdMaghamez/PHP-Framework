<?php namespace main\storage\tables;

    use main\models\Table;
    class tbl_users_group extends Table
    {
        protected $columns      =
        [
            "ID"                =>
            [
                "COLUMN_NAME"       => "`ID`",
                "COLUMN_TYPE"       => "int(8)",
                "COLUMN_DEFAULT"    => "",
                "IS_NULLABLE"       => "not null",
                "EXTRA"             => ""
            ],

            "HOMEPAGE"          =>
            [
                "COLUMN_NAME"       => "`HOMEPAGE`",
                "COLUMN_TYPE"       => "varchar(255)",
                "COLUMN_DEFAULT"    => "",
                "IS_NULLABLE"       => "not null",
                "EXTRA"             => ""
            ],

            "PHPVAR"		    =>
            [
                "COLUMN_NAME"		=> "`PHPVAR`",
                "COLUMN_TYPE"		=> "varchar(50)",
                "COLUMN_DEFAULT"	=> "",
                "IS_NULLABLE"		=> "not null",
                "EXTRA"				=> ""
            ],

            "NAME"              =>
            [
                "COLUMN_NAME"       => "`NAME`",
                "COLUMN_TYPE"       => "varchar(50)",
                "COLUMN_DEFAULT"    => "",
                "IS_NULLABLE"       => "not null",
                "EXTRA"             => ""
            ],

            "DESCRIPTION"	    =>
            [
                "COLUMN_NAME"		=> "`DESCRIPTION`",
                "COLUMN_TYPE"		=> "varchar(155)",
                "COLUMN_DEFAULT"	=> "default null",
                "IS_NULLABLE"		=> "null",
                "EXTRA"				=> ""
            ],

            "ROLE"              =>
            [
                "COLUMN_NAME"		=> "`ROLE`",
                "COLUMN_TYPE"		=> "tinyint(1)",
                "COLUMN_DEFAULT"	=> "default 0",
                "IS_NULLABLE"		=> "not null",
                "EXTRA"				=> ""
            ],

            "PERMISSION"  =>
            [
                "COLUMN_NAME"		=> "`PERMISSION`",
                "COLUMN_TYPE"		=> "tinyint(1)",
                "COLUMN_DEFAULT"	=> "default 0",
                "IS_NULLABLE"		=> "not null",
                "EXTRA"				=> ""
            ],

            "SORT"              =>
            [
                "COLUMN_NAME"		=> "`SORT`",
                "COLUMN_TYPE"		=> "int(8)",
                "COLUMN_DEFAULT"	=> "",
                "IS_NULLABLE"		=> "not null",
                "EXTRA"				=> ""
            ],

            "DELETED"		    =>
            [
                "COLUMN_NAME"		=> "`DELETED`",
                "COLUMN_TYPE"		=> "tinyint(1)",
                "COLUMN_DEFAULT"	=> "default null",
                "IS_NULLABLE"		=> "null",
                "EXTRA"				=> ""
            ],

            "CREATED"		    =>
            [
                "COLUMN_NAME"		=> "`CREATED`",
                "COLUMN_TYPE"		=> "datetime(6)",
                "COLUMN_DEFAULT"	=> "default CURRENT_TIMESTAMP(6)",
                "IS_NULLABLE"		=> "not null",
                "EXTRA"				=> ""
            ]
        ];
    
        public function __construct ( )
        {
            $table  		= "users_group";
            $columns		= $this->columns;
            $primary       	= "";
            $unique     	= "";
            
            parent::__construct ( $table, $columns, $primary, $unique );
        }
    }