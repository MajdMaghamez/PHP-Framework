<?php namespace main\storage\seeds;

    use main\models\Seeder;

    class seed_selectfield_options extends Seeder
    {
        protected $table = "`selectfield_options`";
        protected $insertable = [ "`GROUP_ID`", "`SELECTION`", "`TEXT`" ];
        protected $bag =
        [
            [ 1, 1, "'What was the name of your elementary school?'" ],
            [ 1, 2, "'In What city were you born?'" ],
            [ 1, 3, "'What is your pet name?'" ],
            [ 1, 4, "'In What month did you get married?'" ],
            [ 1, 5, "'What is the name of your favorite teacher?'" ],

            [ 2, 1, "'What is your favorite ice cream flavor?'" ],
            [ 2, 2, "'In What city was your high school?'" ],
            [ 2, 3, "'What is your mother middle name?'" ],
            [ 2, 4, "'Who is your favorite cousin?'" ],
            [ 2, 5, "'what is your favorite fruit?'" ]
        ];

        /**
         * seed_selectfield_options constructor.
         */
        public function __construct ( )
        {
            parent::__construct ( $this->table, $this->insertable, $this->bag );
        }

    }