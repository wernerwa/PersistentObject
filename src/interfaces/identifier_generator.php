<?php
/**
 * File containing the ezcPersistentIdentifierGenerator class
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
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * The interface between the class that generates unique identifiers when creating new objects
 * and the session.
 *
 * Implement this interface if you want a new strategy for generating unique identifier.
 * This interface is not intended to be exposed to the application.
 *
 * Implementations should accept any parameters through a associative array in the
 * constructor:
 * <code>
 * public function __construct( array $params );
 * </code>
 *
 * The structure of the parameters is array( 'parameter_name' => 'parameter_value' ).
 *
 * @package PersistentObject
 * @version //autogen//
 */
abstract class ezcPersistentIdentifierGenerator
{

    /**
     * Returns true if the object is persistent already.
     *
     * Called in the beginning of the save and update methods.
     *
     * Persistent objects that are being saved must not exist in the database already.
     *
     * The default implementation checks if the id is null.
     * This is suitable for all implementations where the id is generated by
     * the database or by the implementation of preSave().
     *
     * @param ezcPersistentObjectDefinition $def
     * @param ezcDbHandler $db
     * @param array(key=>value) $state
     * @return bool True if the object is not persistent, yet.
     */
    public function checkPersistence( ezcPersistentObjectDefinition $def, ezcDbHandler $db, array $state )
    {
        $idValue = $state[$def->idProperty->propertyName];

        // check that this object is stored to db already
        if ( $idValue !== null )
        {
            return true;
        }
        return false;
    }

    /**
     * Called prior to executing the insert query that saves the data to the database.
     *
     * All the data has been set on the query prior to calling this method.
     *
     * @param ezcPersistentObjectDefinition $def
     * @param ezcDbHandler $db
     * @param ezcQueryInsert $q
     * @return void
     */
    abstract public function preSave( ezcPersistentObjectDefinition $def, ezcDbHandler $db, ezcQueryInsert $q );

    /**
     * Returns the value of the generated identifier for the new object.
     *
     * Called right after execution of the insert query.
     * Returns null if it was not possible to generate a new ID.
     *
     * @param ezcPersistentObjectDefinition $def
     * @param ezcDbHandler $db
     * @return int
     */
    abstract public function postSave( ezcPersistentObjectDefinition $def, ezcDbHandler $db );
}

?>
