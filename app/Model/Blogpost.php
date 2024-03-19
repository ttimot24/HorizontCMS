<?php

namespace App\Model;

use \Illuminate\Database\Eloquent\Model;
use \App\Model\Trait\HasAuthor;
use \App\Model\Trait\Draftable;
use App\Model\Trait\HasImage;
use App\Model\Trait\Searchable;

class Blogpost extends Model
{

    use HasImage;
    use HasAuthor;
    use Draftable;
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'summary', 'text', 'category_id', 'comments_enabled', 'active',
    ];

    protected $search = ['title', 'summary', 'text'];

    protected $defaultImage = "resources/images/icons/newspaper.png";

    protected $imageDir = "storage/images/blogposts";


    public static function findBySlug($slug)
    {

        $blogpost = self::where('slug', $slug)->get()->first();

        if ($blogpost != NULL) {
            return $blogpost;
        } else {

            foreach (self::where('slug', NULL)->orWhere('slug', "")->get() as $blogpost) {
                if (str_slug($blogpost->title) == $slug) {
                    return $blogpost;
                }
            }
        }

        return NULL;
    }

    //TODO Use local scope
    public static function getPublished($num = null, $order = 'ASC')
    {
        return self::where('active', '>', 0)->orderBy('created_at', $order)->paginate($num);
    }

    //TODO Use local scope
    public static function getDrafts($num = null, $order = 'ASC')
    {
        return self::where('active', 0)->get()->orderBy('created_at', $order)->paginate($num);
    }

    //TODO Use local scope
    public static function getFeatured($num = null, $order = 'ASC')
    {
        return self::where('active', 2)->orderBy('created_at', $order)->paginate($num);
    }

    public function category()
    {

        return $this->hasOne(BlogpostCategory::class, 'id', 'category_id'); //In db it has to be category_id else it won't work because Laravel priority is attr -> function
    }


    public function comments()
    {
        return $this->hasMany(BlogpostComment::class, 'blogpost_id', 'id');
    }


    public function getSlug()
    {
        return empty($this->slug) ? str_slug($this->title) : $this->slug;
    }

    public function getExcerpt($char_num = 255)
    {

        return empty($this->summary) ? substr(strip_tags($this->text), 0, $char_num) : $this->summary;
    }

    public function getTotalCharacterCount()
    {
        return strlen(strip_tags($this->text));
    }

    public function getTotalWordCount()
    {
        return str_word_count(strip_tags($this->text));
    }

    public function getReadingTime()
    {
        return ($this->getTotalWordCount() / 200) * 60;
    }

    public function isPublished()
    {
        return $this->active > 0;
    }

    public function isFeatured()
    {
        return $this->active == 2;
    }
}
