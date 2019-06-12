<?php


class Recursion
{

    public function  Montage($link,$id,$categories){
        foreach($categories as $category){
            if($id == 1 ){
                return $link;
            }elseif ($category->id == $id){
                $id = $category ->pid;
                if($link == null){
                    $link = $category->title;
                }
                else{
                    $link = $category->title .'->'.$link;
                }
            }
        }
        return $this->Montage($link,$id,$categories);
    }



}