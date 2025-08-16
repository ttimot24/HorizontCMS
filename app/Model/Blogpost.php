<?php

namespace App\Model;

use \Illuminate\Database\Eloquent\Model;
use \App\Model\Trait\HasAuthor;
use \App\Model\Trait\Draftable;
use App\Model\Trait\HasImage;
use App\Model\Trait\IsActive;
use App\Model\Trait\PaginateSortAndFilter;

class Blogpost extends Model
{

    use HasImage;
    use HasAuthor;
    use Draftable;
    use PaginateSortAndFilter;
    use IsActive;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','slug', 'summary', 'text', 'category_id', 'author_id', 'comments_enabled', 'active',
    ];

    public static $rules = [
        'title' => 'required',
        'summary' => 'max:255',
        'category_id' => 'required'
    ];

    protected $filterableFields  = ['title', 'summary', 'text'];

    protected $defaultImage = "resources/images/icons/newspaper.png";
    

    //TODO Use https://github.com/spatie/laravel-sluggable
    public static function findBySlug($slug)
    {

        $blogpost = self::where('slug', $slug)->get()->first();

        if (isset($blogpost)) {
            return $blogpost;
        } else {

            //FIXME Use find
            foreach (self::where('slug', null)->orWhere('slug', "")->get() as $blogpost) {
                if (str_slug($blogpost->title) == $slug) {
                    return $blogpost;
                }
            }
        }

        return null;
    }

    //TODO Use local scope
    public static function getPublished($num = null, $order = 'ASC')
    {
        return self::active()->orderBy('created_at', $order)->paginate($num);
    }

    //TODO Use local scope
    public static function getDrafts($num = null, $order = 'ASC')
    {
        return self::inactive()->get()->orderBy('created_at', $order)->paginate($num);
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
        return $this->isActive();
    }

    public function isFeatured()
    {
        return $this->active == 2;
    }
}
