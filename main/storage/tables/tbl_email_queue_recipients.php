<?php namespace main\storage\tables;

    use main\models\Table;
	class tbl_email_queue_recipients extends Table
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
                "EXTRA"			    => 	""
            ],

            "RECIPIENT_TYPE"	=>
            [
                "COLUMN_NAME"	    =>	"`RECIPIENT_TYPE`",
                "COLUMN_TYPE"	    =>	"tinyint(1)",
                "COLUMN_DEFAULT"    =>	"default 0",
                "IS_NULLABLE"	    =>	"not null",
                "EXTRA"			    =>	""
            ],

            "EMAIL"				=>
            [
                "COLUMN_NAME"	    =>	"`EMAIL`",
                "COLUMN_TYPE"	    =>	"varchar(100)",
                "COLUMN_DEFAULT"    =>	"",
                "IS_NULLABLE"	    =>	"not null",
                "EXTRA"			    =>	""
            ],

            "NAME"			    =>
            [
                "COLUMN_NAME"	    =>	"`NAME`",
                "COLUMN_TYPE"	    =>	"varchar(100)",
                "COLUMN_DEFAULT"    =>	"null",
                "IS_NULLABLE"	    =>	"null",
                "EXTRA"			    =>	""
            ]
        ];

		public function __construct ( )
		{
			$table  		= "email_queue_recipients";
			$columns		= $this->columns;
			$primary    	= "PRIMARY KEY (`ID`)";
			$unique     	= "";
			
			parent::__construct ( $table, $columns, $primary, $unique );
		}
	}