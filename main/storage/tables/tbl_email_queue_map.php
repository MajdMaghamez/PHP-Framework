<?php namespace main\storage\tables;

    use main\models\Table;
	class tbl_email_queue_map extends Table
	{
		protected $columns      =
        [
            "ID"				=>
            [
                "COLUMN_NAME"	    =>	"`ID`",
                "COLUMN_TYPE"	    =>	"int(11)",
                "COLUMN_DEFAULT"    =>	"",
                "IS_NULLABLE"	    =>	"not null",
                "EXTRA"			    =>	"auto_increment"
            ],

            "QUEUE_ID"			=>
            [
                "COLUMN_NAME"	    =>	"`QUEUE_ID`",
                "COLUMN_TYPE"	    =>	"int(11)",
                "COLUMN_DEFAULT"    =>	"",
                "IS_NULLABLE"	    =>	"not null",
                "EXTRA"			    =>	""
            ],

            "QUEUE_KEY"			=>
            [
                "COLUMN_NAME"	    =>	"`QUEUE_KEY`",
                "COLUMN_TYPE"	    =>	"varchar(100)",
                "COLUMN_DEFAULT"    =>	"",
                "IS_NULLABLE"	    =>	"not null",
                "EXTRA"			    =>	""
            ],

            "QUEUE_VALUE"		=>
            [
                "COLUMN_NAME"	    =>	"`QUEUE_VALUE`",
                "COLUMN_TYPE"	    =>	"varchar(500)",
                "COLUMN_DEFAULT"    =>	"",
                "IS_NULLABLE"	    =>	"not null",
                "EXTRA"			    =>	""
            ],

            "QUEUE_ORDER"		=>
            [
                "COLUMN_NAME"	    =>	"`QUEUE_ORDER`",
                "COLUMN_TYPE"	    =>	"int(4)",
                "COLUMN_DEFAULT"    =>	"default 0",
                "IS_NULLABLE"	    =>	"not null",
                "EXTRA"			    =>	""
            ]
        ];
		
		public function  __construct ( )
		{
			$table  		= "email_queue_map";
			$columns		= $this->columns;
			$primary	    = "PRIMARY KEY (`ID`)";
			$unique     	= "";
			
			parent::__construct ( $table, $columns, $primary, $unique );
		}
	}