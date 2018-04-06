<?php namespace main\storage\tables;

    use main\models\Table;
    class tbl_users_permission extends Table
    {
        protected $columns      =
        [
            "ID"                =>
            [
                "COLUMN_NAME"       => "`ID`",
                "COLUMN_TYPE"       => "int(8)",
                "COLUMN_DEFAULT"    => "",
                "IS_NULLABLE"       => "not null",
                "EXTRA"             => "auto_increment"
            ],
            
            "USERID"            =>
            [
                "COLUMN_NAME"       => "`USERID`",
                "COLUMN_TYPE"       => "int(8)",
                "COLUMN_DEFAULT"    => "",
                "IS_NULLABLE"       => "not null",
                "EXTRA"             => ""
            ],
            
            "PERMISSIONID"      =>
            [
                "COLUMN_NAME"		=> "`PERMISSIONID`",
                "COLUMN_TYPE"		=> "tinyint(1)",
                "COLUMN_DEFAULT"	=> "default 0",
                "IS_NULLABLE"		=> "not null",
                "EXTRA"				=> ""
            ],

            "PERMISSION_VAR"    =>
            [
                "COLUMN_NAME"       => "`PERMISSION_VAR`",
                "COLUMN_TYPE"       => "varchar(20)",
                "COLUMN_DEFAULT"    => "",
                "IS_NULLABLE"       => "",
                "EXTRA"             => ""
            ],

            "PERMISSION_VALUE"  =>
            [
                "COLUMN_NAME"       => "`PERMISSION_VALUE`",
                "COLUMN_TYPE"       => "tinyint(1)",
                "COLUMN_DEFAULT"    => "default 0",
                "IS_NULLABLE"       => "not null",
                "EXTRA"             => ""
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
            $table  		= "users_permission";
            $columns   		= $this->columns;
            $primary    	= "PRIMARY KEY (`ID`)";
            $unique     	= "";
            
            parent::__construct ( $table, $columns, $primary, $unique );
        }
    }