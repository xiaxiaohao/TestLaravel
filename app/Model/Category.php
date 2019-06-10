<?php


namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //    定义数据库表名
//    protected $table = 'tag_category';
//    // 定义主键列名
//    protected $primaryKey = 'id';
//    // 定义可操作字段
//    protected $fillable = ['title', 'is_delete'];
//    //lavarel自动管理created_at和updated_at
//    public $timestamps = false;
//
//    public function test()
//    {
//        return $this->hasOne('App\TestModel', 'api');
//    }

    protected $table = 'tag_category';

    public $fillable = ['title','pid'];

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function childs() {
        return $this->hasMany('App\Model\Category','pid','id') ;
    }

    public $timestamps = false;
}