<?php namespace main\storage\seeds;

    use main\models\Seeder;

    class seed_users_group extends Seeder
    {
        protected $table = "`users_group`";
        protected $insertable = [ "`ID`", "`HOMEPAGE`", "`PHPVAR`", "`NAME`", "`DESCRIPTION`", "`ROLE`", "`PERMISSION`", "`SORT`", "`DELETED`", "`CREATED`" ];
        protected $bag =
        [
            [1, "'/Home'",  "'SUPER_ADMIN'",    "'Super Admin'",    "'A master role with full access to all available features.'",                  1, 0, 0, 0, "CURRENT_TIMESTAMP()" ],
            [2, "'/Home'",  "'ADMIN'",          "'Admin'",          "'A role with access to System level features.'",                               1, 0, 1, 0, "CURRENT_TIMESTAMP()" ],
            [3, "'/Home'",  "'DATA_ANALYST'",   "'Data Analyst'",   "'A role with access to Reports, and Statistics data.'",                        1, 0, 2, 0, "CURRENT_TIMESTAMP()" ],
            [4, "'/Home'",  "'USER'",           "'User'",           "'A general level of access set by default to users who register publicly.'",   1, 0, 4, 0, "CURRENT_TIMESTAMP()" ],

            [101, "''",     "'USER_VIEW'",      "'View Users'",     "'Access to Users List.'",                  0, 1, 0, 0, "CURRENT_TIMESTAMP()" ],
            [102, "''",     "'USER_ADD'",       "'Add Users'",      "'Access to Add new Users'",                0, 1, 1, 0, "CURRENT_TIMESTAMP()" ],
            [103, "''",     "'USER_EDIT'",      "'Edit Users'",     "'Access to Edit Users.'",                  0, 1, 2, 0, "CURRENT_TIMESTAMP()" ],
            [104, "''",     "'USER_DELETE'",    "'Delete Users'",   "'Access to Delete Users'",                 0, 1, 3, 0, "CURRENT_TIMESTAMP()" ]
        ];

        /**
         * seed_users_group constructor.
         */
        public function __construct ( )
        {
            parent::__construct ( $this->table, $this->insertable, $this->bag );
        }
    }