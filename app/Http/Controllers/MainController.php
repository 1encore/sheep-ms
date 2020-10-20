<?php

namespace App\Http\Controllers;

use App\Group;
use App\History;
use App\Sheep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MainController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }

    public function getGroupsWithSheep()
    {
        $data = Group::with('sheep')->get();
        return response()->json($data);
    }

    public function getDay()
    {
        $history = History::all()->last();
        return $history->day;
    }

    public function shuffleGroup()
    {
        $history = History::all()->last();
        $day = 1;
        if ($history != null) {
            $day = $history->day + 1;
        }
        /*
         * Chech if day is day to die then remove one sheep from groups
         */
        if ($day % 10 == 0) {
            $sheep = Sheep::inRandomOrder()->first();

            if ($sheep) {
                $history = new History;
                $history->group_id = $sheep->group_id;
                $history->sheep_id = $sheep->id;
                $history->is_child = false;
                $history->day = $day;
                $history->save();

                $sheep->delete();
            }
        }
        /*
         * Second go to start with sorting groups into
         * more than one sheep and one sheep
         */
        $groups = Group::with('sheep')->get();

        $oneSheepGroups = [];
        $manySheepGroups = [];
        foreach ($groups as $group) {
            if (count($group->sheep) > 1) {
                $manySheepGroups[] = $group;
            } else {
                $oneSheepGroups[] = $group;
            }
        }
        /*
         * Attach one element to groups
         * with more than one sheep
         */
        foreach ($manySheepGroups as $group) {
            $group->sheep()->create([
                'name' => 'Sheep ' . Str::random(8),
            ]);

            $history = new History;
            $history->group_id = $group->id;
            $history->sheep_id = DB::table('sheep')->max('id');
            $history->is_child = true;
            $history->day = $day;
            $history->save();
        }

        /*
         * Sort out sheep by min and max
         */
        $maxGroup = $groups[0];
        $minGroup = $groups[0];
        foreach ($groups as $group) {
            if (count($maxGroup->sheep) < count($group->sheep)) {
                $maxGroup = $group;
            }

            if (count($minGroup->sheep) > count($group->sheep)) {
                $minGroup = $group;
            }
        }
        /*
         * Associate one sheep from max group to min group
         */
        if ($maxGroup && $minGroup) {
            $randomSheep = $maxGroup->sheep[0];
            $randomSheep->group()
                ->associate($minGroup);
            $randomSheep->save();
        }

        /*
         * Return result to front
         */
        $data = Group::with('sheep')->get();
        return response()->json($data);
    }

    public function stat()
    {
        return view('result');
    }

    public function getTotal()
    {
        return Sheep::all()->count() + History::all()->where('is_child', '=', false)->count();
    }

    public function getAlive()
    {
        return Sheep::all()->count();
    }

    public function getDead()
    {
        return History::all()->where('is_child', '=', false)->count();
    }

    public function getMaxGroup()
    {
        $groups = Group::with('sheep')->get();
        $max = $groups[0]->sheep()->count();
        $id = $groups[0]->id;

        foreach ($groups as $group) {
            if ($max < $group->sheep()->count()) {
                $max = $group->sheep()->count();
                $id = $group->id;
            }
        }
        return $id;
    }

    public function getMinGroup()
    {
        $groups = Group::with('sheep')->get();
        $min = $groups[0]->sheep()->count();
        $id = $groups[0]->id;

        foreach ($groups as $group) {
            if ($min > $group->sheep()->count()) {
                $min = $group->sheep()->count();
                $id = $group->id;
            }
        }
        return $id;
    }
}
