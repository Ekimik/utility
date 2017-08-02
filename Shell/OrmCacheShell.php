<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.0.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Shell;

use Cake\Database\SchemaCache;

/**
 * ORM Cache Shell.
 *
 * Provides a CLI interface to the ORM metadata caching features.
 * This tool is intended to be used by deployment scripts so that you
 * can prevent thundering herd effects on the metadata cache when new
 * versions of your application are deployed, or when migrations
 * requiring updated metadata are required.
 */
class OrmCacheShell extends SchemaCacheShell
{

    /**
     * @inheritDoc
     */
    public function initialize()
    {
        parent::initialize();

        trigger_error('OrmCache shell is deprecated, use SchemaCache shell instead.', E_USER_DEPRECATED);
    }
}
