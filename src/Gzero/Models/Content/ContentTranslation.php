<?php namespace Gzero\Models\Content;

use Gzero\Models\AbstractTranslation;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class ContentTranslation
 *
 * @package    Gzero\Models\Content
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class ContentTranslation extends AbstractTranslation {

    protected $fillable = array(
        'lang_code',
        'title',
        'body',
        'seo_title',
        'seo_description',
        'url',
        'is_current'
    );

    public static $rules = array();

    /**
     * Represents content relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function content()
    {
        return $this->belongsTo('Gzero\Models\Content\Content');
    }

    /**
     * Represents lang relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lang()
    {
        return $this->belongsTo('Gzero\Models\Lang');
    }

}
