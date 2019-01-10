<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $table = 'actions';
    public $timestamps = false;
    protected $fillable = ['icon',
        'title',
        'group_name',
        'is_active',
        'is_menu',
        'is_home',
        'link',
        'menu_order',
        'parent_id',
        'menu_parent_id',
        'route',
    ];

    public function actions()
    {
        return $this->hasMany(Action::class, "parent_id");
    }

    public function nodes()
    {
        return $this->hasMany(Action::class, "parent_id");
    }

    public function countActionsMenu()
    {
        return $this->hasOne(Action::class, "menu_parent_id")
            ->select(["id as value", "id as id", "menu_parent_id", \DB::raw("count(*) as actionsNo")])
            ->where("is_menu", 1)->where("is_active", 1)
            ->groupBy("menu_parent_id", "id");
    }

    public function countActions()
    {
        return $this->hasOne(Action::class, "parent_id")
            ->select(["id", "parent_id", \DB::raw("count(*) as actionsNo")])
            ->where("is_menu", 1)->where("is_active", 1)
            ->groupBy("menu_parent_id", "id");
    }


    public function parent()
    {
        return $this->hasOne(Action::class, "parent_id")->orderBy("id", "asc")->limit(1);
    }

    public function menuParent()
    {
        return $this->hasOne(Action::class, "menu_parent_id")->orderBy("id", "asc")->limit(1);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, "role_actions", "action_id", "role_id");
    }


    public function children()
    {
        return $this->hasMany(Action::class, "parent_id");
    }


    public static function getMenu()
    {
        return self::select(['id', 'icon', 'group_name as title', 'is_home', 'link'])->with(["children" => function ($q) {
            $q->where("is_menu", 1)->where("is_active", 1);
            $q->orderBy('menu_order', 'desc');
        }])
            ->where("is_menu", 1)
            ->where("is_active", 1)
            ->orderBy('menu_order')
            ->whereNull('menu_parent_id')
            ->get();
    }

    public static function getActionsMenu()
    {
        return self::select(['id', 'icon', 'group_name as text'])->with(["children" => function ($q) {
            $q->select(['id as value', 'id as id', 'title as text', 'parent_id']);
            $q->orderBy('menu_order', 'desc');
            $q->with(["children" => function ($k) {
                $k->select(['id as value', 'id as id', 'title as text', 'parent_id']);
                $k->orderBy('menu_order', 'desc');
            }]);
        }])->where("is_menu", 1)
            ->where("is_active", 1)
            ->whereNull('parent_id')
            ->orderBy('menu_order')
            ->get();
    }
}
