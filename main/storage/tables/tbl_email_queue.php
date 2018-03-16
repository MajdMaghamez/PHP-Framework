<?php namespace main\storage\tables;

    use main\models\Table;
	class tbl_email_queue extends Table
	{
		protected $columns		=
        [
            "ID"				=>
            [
                "COLUMN_NAME"	    =>	"`ID`",
                "COLUMN_TYPE"	    =>	"int(11)",
                "COLUMN_DEFAULT"    =>	"",
                "IS_NULLABLE"	    =>	"not null",
                "EXTRA"			    =>	"auto_increment"
            ],

            "USER_ID"			=>
            [
                "COLUMN_NAME"	    =>	"`USER_ID`",
                "COLUMN_TYPE"	    =>	"int(11)",
                "COLUMN_DEFAULT"    =>	"",
                "IS_NULLABLE"	    => 	"not null",
                "EXTRA"			    =>	""
            ],

            "MAIL_SUBJECT"		=>
            [
                "COLUMN_NAME"	    =>	"`MAIL_SUBJECT`",
                "COLUMN_TYPE"	    =>	"varchar(100)",
                "COLUMN_DEFAULT"    =>	"",
                "IS_NULLABLE"	    =>	"not null",
                "EXTRA"			    =>	""
            ],

            "TEMPLATE_HTML"		=>
            [
                "COLUMN_NAME"	    =>	"`TEMPLATE_HTML`",
                "COLUMN_TYPE"	    =>	"text",
                "COLUMN_DEFAULT"    =>	"",
                "IS_NULLABLE"	    => 	"not null",
                "EXTRA"			    =>	""
            ],

            "TEMPLATE_TEXT"		=>
            [
                "COLUMN_NAME"	    =>	"`TEMPLATE_TEXT`",
                "COLUMN_TYPE"	    => 	"text",
                "COLUMN_DEFAULT"    => 	"",
                "IS_NULLABLE"	    =>	"not null",
                "EXTRA"			    => 	""
            ],

            "ATTACHMENT"		=>
            [
                "COLUMN_NAME"	    =>	"`ATTACHMENT`",
                "COLUMN_TYPE"	    =>	"varchar(100)",
                "COLUMN_DEFAULT"    =>	"null",
                "IS_NULLABLE"	    =>	"null",
                "EXTRA"			    =>	""
            ],

            "CREATED"			=>
            [
                "COLUMN_NAME"	    =>	"`CREATED`",
                "COLUMN_TYPE"	    =>	"datetime(6)",
                "COLUMN_DEFAULT"    =>	"default CURRENT_TIMESTAMP(6)",
                "IS_NULLABLE"	    => 	"not null",
                "EXTRA"			    =>	""
            ]
        ];
		
		public function __construct ( )
		{
			$table		= "email_queue";
			$columns	= $this->columns;
			$primary	= "PRIMARY KEY (`ID`)";
			$unique	    = "";
			
			parent::__construct ( $table, $columns, $primary, $unique );
		}
	}