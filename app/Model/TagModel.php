<?php


namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TagModel extends Model
{
    //    定义数据库表名
    protected $table = 'tag';
    // 定义主键列名
    protected $primaryKey = 'id';
    // 定义可操作字段
    protected $fillable = ['tag_name','category_id', 'tag_specs', 'is_delete','pic','add_time','update_time'];
    //lavarel自动管理created_at和updated_at
    public $timestamps = false;

    public function test()
    {
        return $this->hasOne('App\TestModel', 'api');
    }


}