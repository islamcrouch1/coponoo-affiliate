<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\LearningSystem;
use App\User;
use App\Address;
use App\Stage;

use App\EdClass;
use App\Course;
use App\Chapter;
use App\Lesson;


use App\Product;
use App\Category;

use App\Post;
use App\Withdraw;

use App\Report;
use App\Order;
use App\Monitor;
use App\HomeworkService;



class Country extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'name_en', 'name_ar', 'code','currency','image',
    ];


    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function shipping_rates()
    {
        return $this->hasMany(ShippingRate::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }


    public function homework_services()
    {
        return $this->hasMany(HomeworkService::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }


    public function admin_nitifications()
    {
        return $this->hasMany(AdminNotification::class);
    }


    public function courses_orders()
    {
        return $this->hasMany(CourseOrder::class);
    }

    public function homeworks_orders()
    {
        return $this->hasMany(HomeWorkOrder::class);
    }


    public function reports()
    {
        return $this->hasMany(Report::class);
    }


    public function scopeWhenSearch($query , $search)
    {
        return $query->when($search , function($q) use($search) {
            return $q->where('name_ar' , 'like' , "%$search%")
            ->orWhere('name_en' , 'like' , "%$search%");
        });
    }


    public function learning_systems()
    {
        return $this->hasMany(LearningSystem::class);
    }

    public function ed_classes()
    {
        return $this->hasMany(EdClass::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function courses_categories()
    {
        return $this->hasMany(CoursesCategory::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }


    public function withdraws()
    {
        return $this->hasMany(Withdraw::class);
    }

    public function stages()
    {
        return $this->hasMany(Stage::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function monitors()
    {
        return $this->belongsToMany(Monitor::class);
    }
}
