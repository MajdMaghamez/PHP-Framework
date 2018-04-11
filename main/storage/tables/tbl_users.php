<?php namespace main\storage\tables;

    use main\models\Table;
	class tbl_users extends Table
	{
		protected $columns		=
        [
            "ID"				=>
            [
                "COLUMN_NAME"		=> "`ID`",
                "COLUMN_TYPE"		=> "int(8)",
                "COLUMN_DEFAULT"	=> "",
                "IS_NULLABLE"		=> "not null",
                "EXTRA"				=> "auto_increment"
            ],

            "FIRSTNAME"			=>
            [
                "COLUMN_NAME"		=> "`FIRSTNAME`",
                "COLUMN_TYPE"		=> "varchar(155)",
                "COLUMN_DEFAULT"	=> "",
                "IS_NULLABLE"		=> "not null",
                "EXTRA"				=> ""
            ],

            "LASTNAME"			=>
            [
                "COLUMN_NAME"		=> "`LASTNAME`",
                "COLUMN_TYPE"		=> "varchar(155)",
                "COLUMN_DEFAULT"	=> "",
                "IS_NULLABLE"		=> "not null",
                "EXTRA"				=> ""
            ],

            "EMAIL"				=>
            [
                "COLUMN_NAME"		=> "`EMAIL`",
                "COLUMN_TYPE"		=> "varchar(255)",
                "COLUMN_DEFAULT"	=> "",
                "IS_NULLABLE"		=> "not null",
                "EXTRA"				=> ""
            ],

            "PASSWORD"			=>
            [
                "COLUMN_NAME"		=> "`PASSWORD`",
                "COLUMN_TYPE"		=> "varchar(255)",
                "COLUMN_DEFAULT"	=> "",
                "IS_NULLABLE"		=> "not null",
                "EXTRA"				=> ""
            ],

            "QUESTIONID1"       =>
            [
                "COLUMN_NAME"		=> "`QUESTIONID1`",
                "COLUMN_TYPE"		=> "int(8)",
                "COLUMN_DEFAULT"	=> "default 0",
                "IS_NULLABLE"		=> "not null",
                "EXTRA"				=> ""
            ],

            "ANSWER1"           =>
            [
                "COLUMN_NAME"		=> "`ANSWER1`",
                "COLUMN_TYPE"		=> "varchar(255)",
                "COLUMN_DEFAULT"	=> "null",
                "IS_NULLABLE"		=> "null",
                "EXTRA"				=> ""
            ],

            "QUESTIONID2"       =>
            [
                "COLUMN_NAME"		=> "`QUESTIONID2`",
                "COLUMN_TYPE"		=> "int(8)",
                "COLUMN_DEFAULT"	=> "default 0",
                "IS_NULLABLE"		=> "not null",
                "EXTRA"				=> ""
            ],

            "ANSWER2"           =>
            [
                "COLUMN_NAME"		=> "`ANSWER2`",
                "COLUMN_TYPE"		=> "varchar(255)",
                "COLUMN_DEFAULT"	=> "null",
                "IS_NULLABLE"		=> "null",
                "EXTRA"				=> ""
            ],

            "ACTIVE"			=>
            [
                "COLUMN_NAME"		=> "`ACTIVE`",
                "COLUMN_TYPE"		=> "tinyint(1)",
                "COLUMN_DEFAULT"	=> "default 1",
                "IS_NULLABLE"		=> "not null",
                "EXTRA"				=> ""
            ],

            "FAILED"			=>
            [
                "COLUMN_NAME"		=> "`FAILED`",
                "COLUMN_TYPE"		=> "tinyint(2)",
                "COLUMN_DEFAULT"	=> "default 0",
                "IS_NULLABLE"		=> "not null",
                "EXTRA"				=> ""
            ],

            "VERIFIED"			=>
            [
                "COLUMN_NAME"		=> "`VERIFIED`",
                "COLUMN_TYPE"		=> "tinyint(1)",
                "COLUMN_DEFAULT"	=> "default 0",
                "IS_NULLABLE"		=> "not null",
                "EXTRA"				=> ""
            ],

            "VERIFY_TOKEN"      =>
            [
                "COLUMN_NAME"       => "`VERIFY_TOKEN`",
                "COLUMN_TYPE"       => "varchar(255)",
                "COLUMN_DEFAULT"    => "null",
                "IS_NULLABLE"       => "null",
                "EXTRA"             => ""
            ],

            "LAST_LOGGED_IP"	=>
            [
                "COLUMN_NAME"		=> "`LAST_LOGGED_IP`",
                "COLUMN_TYPE"		=> "varchar(155)",
                "COLUMN_DEFAULT"	=> "null",
                "IS_NULLABLE"		=> "null",
                "EXTRA"				=> ""
            ],

            "LAST_LOGGED_IN"    =>
            [
                "COLUMN_NAME"       => "`LAST_LOGGED_IN`",
                "COLUMN_TYPE"       => "datetime(6)",
                "COLUMN_DEFAULT"    => "null",
                "IS_NULLABLE"       => "null",
                "EXTRA"             => ""
            ],

            "CREATED"			=>
            [
                "COLUMN_NAME"		=> "`CREATED`",
                "COLUMN_TYPE"		=> "datetime(6)",
                "COLUMN_DEFAULT"	=> "",
                "IS_NULLABLE"		=> "not null",
                "EXTRA"				=> ""
            ],

            "CREATED_BY"        =>
            [
                "COLUMN_NAME"       => "`CREATED_BY`",
                "COLUMN_TYPE"       => "int(8)",
                "COLUMN_DEFAULT"    => "default 0",
                "IS_NULLABLE"       => "",
                "EXTRA"             => ""
            ],

            "UPDATED"			=>
            [
                "COLUMN_NAME"		=> "`UPDATED`",
                "COLUMN_TYPE"		=> "datetime(6)",
                "COLUMN_DEFAULT"	=> "default CURRENT_TIMESTAMP(6)",
                "IS_NULLABLE"		=> "not null",
                "EXTRA"				=> ""
            ],

            "ROLE"              =>
            [
                "COLUMN_NAME"       => "`ROLE`",
                "COLUMN_TYPE"       => "tinyint(2)",
                "COLUMN_DEFAULT"    => "default 4",
                "IS_NULLABLE"       => "not null",
                "EXTRA"             => ""
            ],

            "DELETED"           =>
            [
                "COLUMN_NAME"       => "`DELETED`",
                "COLUMN_TYPE"       => "tinyint(1)",
                "COLUMN_DEFAULT"    => "default 0",
                "IS_NULLABLE"       => "not null",
                "EXTRA"             => ""
            ],

            "CHANGE_PASSWORD"   =>
            [
                "COLUMN_NAME"       => "`CHANGE_PASSWORD`",
                "COLUMN_TYPE"       => "tinyint(1)",
                "COLUMN_DEFAULT"    => "default 0",
                "IS_NULLABLE"       => "not null",
                "EXTRA"             => ""
            ],

            "PASSWORD_TOKEN"    =>
            [
                "COLUMN_NAME"       => "`PASSWORD_TOKEN`",
                "COLUMN_TYPE"       => "varchar(255)",
                "COLUMN_DEFAULT"    => "null",
                "IS_NULLABLE"       => "null",
                "EXTRA"             => ""
            ],

            "TOKEN_CREATED"     =>
            [
                "COLUMN_NAME"       => "`TOKEN_CREATED`",
                "COLUMN_TYPE"       => "datetime(6)",
                "COLUMN_DEFAULT"    => "null",
                "IS_NULLABLE"       => "null",
                "EXTRA"             => ""
            ],

            "HOME_DIRECTORY"	=>
            [
                "COLUMN_NAME"		=> "`HOME_DIR`",
                "COLUMN_TYPE"		=> "varchar(60)",
                "COLUMN_DEFAULT"	=> "null",
                "IS_NULLABLE"		=> "null",
                "EXTRA"				=> ""
            ],

            "PICTURE_DIR"       =>
            [
                "COLUMN_NAME"       => "`PICTURE`",
                "COLUMN_TYPE"       => "varchar(60)",
                "COLUMN_DEFAULT"    => "null",
                "IS_NULLABLE"       => "null",
                "EXTRA"             => ""
            ]
        ];
		
		public function __construct ( )
		{
			$table  		= "users";
			$columns		= $this->columns;
			$primary    	= "PRIMARY KEY (`ID`), ";
			$unique     	= "UNIQUE KEY `EMAIL` (`EMAIL`)";
			
			parent::__construct ( $table, $columns, $primary, $unique );
		}
	}