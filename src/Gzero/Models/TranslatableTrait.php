<?php namespace Gzero\Models;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Trait TranslatableTrait
 *
 * @package    Gzero\Models
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */


trait TranslatableTrait {

    /**
     * With active translation in specific language or all languages
     *
     * @param      $query
     * @param Lang $lang
     *
     * @return mixed
     */
    public function scopeWithActiveTranslations($query)
    {
        return $query->with(
            array(
                'translations' => function ($query) {
                        $query->onlyActive();
                    }
            )
        );
    }

} 
