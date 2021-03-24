<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    const TRUNCATE_LIMIT = 250;

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Return article body truncated by words and with repaired HTML tags. TODO: сделать обрезание не по длине, а по словам.
     *
     * @return string
     */
    public function getTruncatedBodyAttribute(): string
    {
        $string = trim($this->body);
        $i = 0;
        $tags = [];


        preg_match_all('/<[^>]+>([^<]*)/', $string, $tagMatches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);

        foreach ($tagMatches as $tagMatch) {
            if ($tagMatch[0][1] - $i >= self::TRUNCATE_LIMIT) {
                break;
            }

            $tag = substr(strtok($tagMatch[0][0], " \t\n\r\0\x0B>"), 1);

            if ($tag[0] != '/') {
                $tags[] = $tag;
            } elseif (end($tags) == substr($tag, 1)) {
                array_pop($tags);
            }

            $i += $tagMatch[1][1] - $tagMatch[0][1];
        }

        return substr($string, 0, $length = min(strlen($string), self::TRUNCATE_LIMIT + $i)) . (count($tags = array_reverse($tags)) ? '</' . implode('></', $tags) . '>' : '') . '...';
    }
}
