<?php


namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ApiModel extends Model
{
    //    定义数据库表名
    protected $table = 'user';
    // 定义主键列名
    protected $primaryKey = 'id';
    // 定义可操作字段
    protected $fillable = ['user_name', 'password', 'number'];
    //lavarel自动管理created_at和updated_at
    public $timestamps = false;




}