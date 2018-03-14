<?php namespace main\storage\tables;

    use main\models\Table;
    class tbl_user_permissions extends Table
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
            $table  		= "user_permissions";
            $columns   		= $this->columns;
            $primary    	= "PRIMARY KEY (`ID`)";
            $unique     	= "";
            
            parent::__construct ( $table, $columns, $primary, $unique );
        }
    }