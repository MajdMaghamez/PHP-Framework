<?php namespace main\storage\tables;

	use main\models\Table;
	class tbl_selectfield_options extends Table
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

            "GROUP_ID"			=>
            [
                "COLUMN_NAME"		=> "`GROUP_ID`",
                "COLUMN_TYPE"		=> "int(8)",
                "COLUMN_DEFAULT"	=> "default 0",
                "IS_NULLABLE"		=> "not null",
                "EXTRA"				=> ""
            ],

            "VALUE"				=>
            [
                "COLUMN_NAME"		=> "`SELECTION`",
                "COLUMN_TYPE"		=> "int(11)",
                "COLUMN_DEFAULT"	=> "",
                "IS_NULLABLE"		=> "not null",
                "EXTRA"				=> ""
            ],

            "TEXT"				=>
            [
                "COLUMN_NAME"		=> "`TEXT`",
                "COLUMN_TYPE"		=> "varchar(255)",
                "COLUMN_DEFAULT"	=> "",
                "IS_NULLABLE"		=> "not null",
                "EXTRA"				=> ""
            ],

            "DELETED"			=>
            [
                "COLUMN_NAME"		=> "`DELETED`",
                "COLUMN_TYPE"		=> "int(1)",
                "COLUMN_DEFAULT"	=> "default 0",
                "IS_NULLABLE"		=> "not null",
                "EXTRA"				=> ""
            ]
		];
		
		public function __construct ( )
		{
			$table  		= "selectfield_options";
			$columns		= $this->columns;
			$primary    	= "PRIMARY KEY (`ID`)";
			$unique     	= "";
			
			parent::__construct ( $table, $columns, $primary, $unique );
		}
	}