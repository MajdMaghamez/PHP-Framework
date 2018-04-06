<?php namespace main\frameworkHelper;

    use main\storage\database;

    class datatableHelper
    {
        /**
         * @param array $request
         * @param string $table
         * @param string $primary
         * @param array $columns
         * @return array
         */
        public static function simple ( $request, $table, $primary, $columns )
        {
            $limit  = self::limit   ( $request );
            $order  = self::order   ( $request, $columns );
            $where  = self::filter  ( $request, $columns );

            $sql_select = "SELECT `" . implode( "`, `", self::pluck( $columns, 'db' ) ) . "` FROM `" . $table . "` " . $where["WHERE"] . " " . $order . $limit;
            $data       = database::runSelectQuery( $sql_select, $where["PARAMS"] );

            $res_filter_length  = "SELECT COUNT(`{$primary}`) as `FL` FROM `" . $table . "` " . $where["WHERE"];
            $filter_total       = database::runSelectQuery( $res_filter_length, $where["PARAMS"] );
            ! empty ( $filter_total ) ? $res_filter_total = $filter_total[0]["FL"] : $res_filter_total = 0;

            $res_total_length   = "SELECT COUNT(`{$primary}`) as `TL` FROM `" . $table . "` " . $where["WHERE"];
            $record_total       = database::runSelectQuery( $res_total_length, $where["PARAMS"] );
            ! empty ( $record_total ) ? $res_record_total = $record_total[0]["TL"] : $res_record_total = 0;

            return
            [
                "draw"              => isset ( $request['draw'] ) ? intval ( $request['draw'] ) : 0,
                "recordsTotal"      => intval ( $res_record_total ),
                "recordsFiltered"   => intval ( $res_filter_total ),
                "data"              => self::dataOutput ( $columns, $data )
            ];
        }

        /**
         * @param array $request
         * @param string $table
         * @param string $primary
         * @param array $columns
         * @param null $where_result
         * @param null $where_all
         * @return array
         */
        public static function complex ( $request, $table, $primary, $columns, $where_result = null, $where_all = null )
        {
            $where_all_sql = '';
            $limit  = self::limit   ( $request );
            $order  = self::order   ( $request, $columns );
            $where  = self::filter  ( $request, $columns );

            $where_result   = self::_flaten( $where_result );
            $where_all      = self::_flaten( $where_all );

            if ( $where_result )
                $where["WHERE"] = $where["WHERE"] ? $where["WHERE"] . ' AND ' . $where_result : 'WHERE ' . $where_result;

            if ( $where_all )
            {
                $where["WHERE"] = $where["WHERE"] ? $where["WHERE"] . ' AND ' . $where_all : 'WHERE ' . $where_all;
                $where_all_sql  = 'WHERE ' . $where_all;
            }

            $sql_select = "SELECT `" . implode ( "`, `", self::PLUCK ( $columns, 'db' ) ) . "` FROM `" . $table . "` " . $where["WHERE"] . " " . $order . $limit;
            $data       = database::runSelectQuery( $sql_select, $where["PARAMS"] );

            $res_filter_length  = "SELECT COUNT(`{$primary}`) as `FL` FROM `" . $table . "` " . $where["WHERE"];
            $filter_total       = database::runSelectQuery( $res_filter_length, $where["PARAMS"] );
            ! empty ( $filter_total ) ? $res_filter_total = $filter_total[0]["FL"] : $res_filter_total = 0;

            $res_total_length   = "SELECT COUNT(`{$primary}`) as `TL` FROM `" . $table . "` " . $where_all_sql;
            $record_total       = database::runSelectQuery( $res_total_length, $where["PARAMS"] );
            ! empty ( $record_total ) ? $res_record_total = $record_total[0]["TL"] : $res_record_total = 0;

            return
            [
                "draw"              => isset ( $request['draw'] ) ? intval ( $request['draw'] ) : 0,
                "recordsTotal"      => intval ( $res_record_total ),
                "recordsFiltered"   => intval ( $res_filter_total ),
                "data"              => self::dataOutput ( $columns, $data )
            ];
        }

        /**
         * @param array $columns
         * @param array $data
         * @return array
         */
        public static function dataOutput ( $columns, $data )
        {
            $output = array ( );
            if ( isset ( $data ) )
            {
                foreach ( $data as $key => $value )
                {
                    $row = array ( );

                    foreach ( $columns as $col => $item )
                    {
                        $column = $columns [$col];

                        if ( isset ( $column ["formatter"] ) )
                        {
                            $row [$column['dt']] = $column ['formatter'] ( $data[$key][$column['db']], $data[$key] );
                        }
                        else
                        {
                            $row [$column['dt']] = $data[$key][$columns[$col]['db']];
                        }
                    }
                    $output [] = $row;
                }
            }
            return $output;
        }

        /**
         * @param $request
         * @return string
         */
        public static function limit ( $request )
        {
            $limit = '';

            if ( isset ( $request ['start'] ) && $request ['length'] != -1 )
            {
                $limit = " LIMIT " . intval ( $request['start'] ) . ", " . intval ( $request ['length'] );
            }

            return $limit;
        }

        /**
         * @param array  $request
         * @param array $columns
         * @return string
         */
        public static function order ( $request, $columns )
        {
            $order = '';

            if ( isset ( $request ['order'] ) && count ( $request ['order'] ) )
            {
                $orderBy = array ( );
                $dt_columns = self::pluck( $columns, 'dt' );

                foreach ( $request ['order'] as $key => $item )
                {
                    $column_index = intval ( $request['order'][$key]['column'] );
                    $request_column = $request ['columns'][$column_index];

                    $column_index = array_search ( $request_column ['data'], $dt_columns );
                    $column = $columns [$column_index];

                    if ( $request_column ['orderable'] == 'true' )
                    {
                        $directory = $request ['order'][$key]['dir'] == 'asc' ? 'ASC' : 'DESC';
                        array_push( $orderBy, "`" . $column ['db'] . "`" . $directory );
                    }
                }

                $order = "ORDER BY " . implode( ', ', $orderBy );
            }

            return $order;
        }

        /**
         * @param array $request
         * @param array $columns
         * @return mixed
         */
        public static function filter ( $request, $columns )
        {
            $global_search  = array ( );
            $column_search  = array ( );
            $binding        = array ( );

            $dt_columns = self::pluck( $columns, 'dt' );

            if ( isset ( $request['search'] ) && $request ['search']['value'] != '' )
            {
                $str = $request['search']['value'];

                foreach ( $request['columns'] as $key => $item )
                {
                    $request_column = $request ['columns'][$key];
                    $column_index   = array_search ( $request_column['data'], $dt_columns );
                    $column         = $columns [$column_index];

                    if ( $request_column['searchable'] == 'true' )
                    {
                        $binding [":binding_" . $key ] = [ "TYPE" => "STR", "VALUE" => "%" . $str . "%" ];
                        array_push( $global_search, "`" . $column['db'] . "` LIKE :binding_" . $key );
                    }
                }
            }

            if ( isset ( $request ['columns'] ) )
            {
                foreach ( $request ['columns'] as $key => $item )
                {
                    $request_column = $request['columns'][$key];
                    $column_index   = array_search ( $request_column['data'], $dt_columns );
                    $column         = $columns [ $column_index ];

                    $str            = $request_column['search']['value'];

                    if ( $request_column ['searchable'] == 'true' && $str != '' )
                    {
                        $binding [ ":binding_" . $key ] = [ "TYPE" => "STR", "VALUE" => "%" . $str . "%" ];
                        array_push ( $column_search, "`" . $column['db'] . "` LIKE :binding_" . $key );
                    }
                }
            }

            $result ["WHERE"] = "";
            $result ["PARAMS"]= $binding;

            if ( ! empty ( $global_search ) )
                $result ["WHERE"] = '(' . implode( ' OR ', $global_search ) . ')';

            if ( ! empty ( $column_search ) )
            {
                $result ["WHERE"] = $result ["WHERE"] === '' ?
                    implode( ' AND ', $column_search ) :
                    $result ["WHERE"] . ' AND ' . implode( ' AND ', $column_search );
            }

            if ( $result ["WHERE"] !== '' )
                $result ["WHERE"] = "WHERE " . $result ["WHERE"];

            return $result;
        }

        /**
         * @param array $array
         * @param string $prop
         * @return array
         */
        public static function pluck ( $array, $prop )
        {
            $out = array ( );
            foreach ( $array as $key => $item )
            {
                array_push ( $out, $array[$key][$prop] );
            }
            return $out;
        }

        /**
         * @param $a
         * @param string $join
         * @return string
         */
        public static function _flaten ( $a , $join = ' AND ' )
        {
            if ( ! isset ( $a ) )
            {
                return '';
            }
            else if ( isset ( $a ) && is_array( $a ) )
            {
                return implode( $join, $a );
            }

            return $a;
        }

    }