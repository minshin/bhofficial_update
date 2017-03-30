<?php namespace Xeor\Comments\Models;

use DB;
use Auth;
use Model;
use Markdown;
use Debugbar;

class Comment extends Model
{
    use \October\Rain\Database\Traits\NestedTree;

    public $table = 'xeor_comments_comments';

    /**
     * Relations
     */
    public $hasMany = [
        'votes' => [
            'Xeor\Comments\Models\Vote',
        ],
    ];

    public function beforeSave()
    {
        $this->content_html = self::formatHtml($this->content);
    }

    public static function formatHtml($input, $preview = false)
    {
        $result = Markdown::parse(strip_tags(trim($input)));
        return $result;
    }

    /**
     * Used to test if a certain user has permission to edit post,
     * returns TRUE if the user is the owner or has other posts access.
     * @param User $user
     * @return bool
     */
    public function canEdit($userId)
    {
        return ($userId > 0) && ($this->user_id == $userId);
    }

    public function getStatistics($type = 'point') {

        $results = [
            'total' => 0,
            'data' => [],
        ];

        $data = Db::table('xeor_comments_votes')->where('comment_id', $this->id)->where('value_type', $type)->lists('value');
        if ($data) {
            asort($data, SORT_NUMERIC);
            $results['total'] = count($data);
            $results['data']  = array_count_values($data);
        }

        return $results;
    }

    public function getTotalVotes()
    {
        return Db::table('xeor_comments_votes')->where('comment_id', $this->id)->count();
    }

    public function getScore($rateType)
    {
        $score = 0;
        $totalArr = array();
        $valueType = $rateType == 'stars' ? 'percent' : 'point';
        $data = Db::table('xeor_comments_votes')->where('comment_id', $this->id)->where('value_type', $valueType)->lists('value');
        if (isset($data) && !empty($data)) {
            foreach ($data as $value) {
                $totalArr[] = (int) $value;
            }
        }
        if (!empty($totalArr)) {
            switch ($rateType) {
                case 'stars':
                    $score = round(array_sum($totalArr) / count($totalArr));
                    break;
                case 'number':
                    $score = array_sum($totalArr);
                    break;
                default:
                    $score = 0;
            }
        }
        return $score;
    }

    //
    // Scopes
    //

    /**
     * Allows filtering for specifc categories
     * @param  Illuminate\Query\Builder  $query      QueryBuilder
     * @param  array                     $types      List of types ids
     * @return Illuminate\Query\Builder              QueryBuilder
     */
    public function scopeFilterTypes($query, $types)
    {
        return $query->whereIn('type', $types);
    }

    public function scopeIsPublished($query)
    {
        return $query
            ->whereNotNull('published')
            ->where('published', '=', 1);
    }

    /**
     * Lists comments for the front end
     * @param  array $options Display options
     * @return self
     */
    public function scopeListFrontEnd($query, $options)
    {
        /*
         * Default options
         */
        extract(array_merge([
            'page'       => 1,
            'perPage'    => 30,
            'published'  => true
        ], $options));

        if ($published) {
            $query->isPublished();
        }

        /*
         * Sorting
         */
        list($sortField, $sortDirection) = [$sort, 'asc'];
        if ($sortField == 'torder') {
            $sortField = DB::raw('SUBSTRING(thread, 1, (LENGTH(thread) - 1))');
        }
        $query->orderBy($sortField, $sortDirection);

        $query->orderBy('id', 'asc'); //TODO
        return $query->paginate($perPage, $page);
    }
}