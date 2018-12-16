<?php

namespace FRohlfing\PackageSkeleton;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * FRohlfing\PackageSkeleton\PackageSkeleton
 *
 * @property integer $id
 * @property string $title
 * @property string $body
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static Builder|PackageSkeleton whereBody($value)
 * @method static Builder|PackageSkeleton whereCreatedAt($value)
 * @method static Builder|PackageSkeleton whereId($value)
 * @method static Builder|PackageSkeleton whereTitle($value)
 * @method static Builder|PackageSkeleton whereUpdatedAt($value)
 * @mixin Builder
 */
class PackageSkeleton extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'package_skeletons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'body'
    ];
}
