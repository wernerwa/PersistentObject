<?php
/**
 * File containing the ezcPersistentObjectColumns class.
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package PersistentObject
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * ezcPersistentObjectColumns class.
 *
 * @access private
 *
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentObjectColumns extends ArrayObject
{
    /**
     * Stores the column objects.
     *
     * @var ezcPersistentObjectProperty[]
     */
    private $columns;

    /**
     * Create a new instance.
     * Implicitly done in constructor of
     *
     * @return void
     */
    public function __construct()
    {
        $this->columns = array();
        parent::__construct( $this->columns );
    }

    /**
     * See SPL interface ArrayAccess.
     *
     * @param string $offset
     * @param ezcPersistentObjectProperty $value
     * @return void
     */
    public function offsetSet( $offset, $value ): void
    {
        if ( ( $value instanceof ezcPersistentObjectProperty ) === false && ( $value instanceof ezcPersistentObjectIdProperty ) === false )
        {
            throw new ezcBaseValueException( 'value', $value, 'ezcPersistentObjectProperty' );
        }
        if ( !is_string( $offset ) || strlen( $offset ) < 1 )
        {
            throw new ezcBaseValueException( 'offset', $offset, 'string, length > 0' );
        }
        parent::offsetSet( $offset, $value );
    }

    /**
     * See SPL class ArrayObject.
     * Performs additional value checks on the array.
     *
     * @param ezcPersistentObjectProperty[] $array New relations array.
     * @return void
     */
    public function exchangeArray( $array ): array
    {
        foreach ( $array as $offset => $value )
        {
            if ( ( $value instanceof ezcPersistentObjectProperty ) === false && ( $value instanceof ezcPersistentObjectIdProperty ) === false )
            {
                throw new ezcBaseValueException( 'value', $value, 'ezcPersistentObjectProperty' );
            }
            if ( !is_string( $offset ) || strlen( $offset ) < 1 )
            {
                throw new ezcBaseValueException( 'offset', $offset, 'string, length > 0' );
            }
        }
        return parent::exchangeArray( $array );
    }

    /**
     * See SPL class ArrayObject.
     * Performs check if only 0 is used as a flag.
     *
     * @param int $flags Must be 0.
     * @return void
     */
    public function setFlags( $flags ): void
    {
        if ( $flags !== 0 )
        {
            throw new ezcBaseValueException( 'flags', $flags, '0' );
        }
    }

    /**
     * Appending is not supported.
     *
     * @param mixed $value
     * @return void
     */
    public function append( $value ): void
    {
        throw new Exception( 'Operation append is not supported by this object.' );
    }

    /**
     * Sets the state on deserialization.
     *
     * @param array $state
     * @return ezcPersistentObjectColumns
     */
    public static function __set_state( array $state )
    {
        $columns = new ezcPersistentObjectColumns();
        if ( isset( $state['columns'] ) && sizeof( $state ) === 1 )
        {
            $columns->exchangeArray( $state['columns'] );
        }
        else
        {
            // Old style exports
            $columns->exchangeArray( $state );
        }
        return $columns;
    }
}

?>
