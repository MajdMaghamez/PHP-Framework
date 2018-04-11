<?php namespace main\storage\seeds;

    use main\models\Seeder;

    class seed_users_group extends Seeder
    {
        protected $table = "`users_group`";
        protected $insertable = [ "`ID`", "`HOMEPAGE`", "`PHPVAR`", "`NAME`", "`DESCRIPTION`", "`ROLE`", "`PERMISSION`", "`SORT`", "`DELETED`", "`CREATED`" ];
        protected $bag =
        [
            [1, "'/Home'",  "'SUPER_ADMIN'",    "'Super Admin'",    "'Super Admin Role'",                       1, 0, 0, 0, "CURRENT_TIMESTAMP()" ],
            [2, "'/Home'",  "'ADMIN'",          "'Admin'",          "'Admin Role'",                             1, 0, 1, 0, "CURRENT_TIMESTAMP()" ],
            [3, "'/Home'",  "'DATA_ANALYST'",   "'Data Analyst'",   "'Data Analyst Role'",                      1, 0, 2, 0, "CURRENT_TIMESTAMP()" ],
            [4, "'/Home'",  "'USER'",           "'User'",           "'User'",                                   1, 0, 4, 0, "CURRENT_TIMESTAMP()" ],

            [101, "''",     "'USER_VIEW'",      "'View Users'",     "'To Display Users List.'",                 0, 1, 0, 0, "CURRENT_TIMESTAMP()" ],
            [102, "''",     "'USER_ADD'",       "'Add New Users'",  "'To Allow Adding new Users.'",             0, 1, 1, 0, "CURRENT_TIMESTAMP()" ],
            [103, "''",     "'USER_EDIT'",      "'Edit Users'",     "'To Allow Editing Users.'",                0, 1, 2, 0, "CURRENT_TIMESTAMP()" ],
            [104, "''",     "'USER_DELETE'",    "'Delete Users'",   "'To Allow Deleting Users'",                0, 1, 3, 0, "CURRENT_TIMESTAMP()" ]
        ];

        /**
         * seed_users_group constructor.
         */
        public function __construct ( )
        {
            parent::__construct ( $this->table, $this->insertable, $this->bag );
        }
    }