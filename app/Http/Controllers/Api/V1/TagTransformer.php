<?php


namespace App\Http\Controllers\Api\V1;

use App\Model\TagModel;
use League\Fractal\TransformerAbstract;

class TagTransformer extends  TransformerAbstract
{
    public function transform(TagModel $tagModel){
        return [
            'id'=>$tagModel['id'],
            'tag_name'=>$tagModel['tag_name'],
            'category_id'=>$tagModel['category_id'],
            'tag_specs'=>$tagModel['tag_specs'],
            'pic'=>$tagModel['pic'],
            'is_delete'=>$tagModel['is_delete'],
            'add_time'=>$tagModel['add_time'],
            'update_time'=>$tagModel['update_time'],
        ];
    }


}