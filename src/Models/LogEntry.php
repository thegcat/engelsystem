<?php

namespace Engelsystem\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * @property int         $id
 * @property string      $level
 * @property string      $message
 * @property Carbon|null $created_at
 *
 * @method static QueryBuilder|LogEntry              whereId($value)
 * @method static QueryBuilder|Collection|LogEntry[] whereLevel($value)
 * @method static QueryBuilder|Collection|LogEntry[] whereMessage($value)
 * @method static QueryBuilder|Collection|LogEntry[] whereCreatedAt($value)
 */
class LogEntry extends BaseModel
{
    /** @var bool enable timestamps for created_at */
    public $timestamps = true;

    /** @var null Disable updated_at */
    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'level',
        'message',
    ];

    /**
     * @param $keyword
     * @return Builder[]|Collection|LogEntry[]
     */
    public static function filter($keyword = null)
    {
        $query = self::query()
            ->select()
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->limit(10000);

        if (!empty($keyword)) {
            $query
                ->where('level', '=', $keyword)
                ->orWhere('message', 'LIKE', '%' . $keyword . '%');
        }

        return $query->get();
    }
}
