<?php

/*
Flare, a fully featured and easy to use crew centre, designed for Infinite Flight.
Copyright (C) 2020  Lucas Rebato

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/

class Rank
{

    private static $_db;

    private static function init()
    {

        self::$_db = DB::newInstance();

    }

    public static function calc($hours, $returnid = false)
    {

        self::init();

        $finalRank = self::$_db->get('ranks', array('id', '>', '0'), array('timereq', 'desc'));

        if ($hours >= $finalRank->first()->timereq) {
            return $finalRank->first()->name;
        }

        $rank = self::$_db->get('ranks', array('timereq', '<=', $hours), array('timereq', 'desc'));

        if ($returnid) {
            return $rank->first()->id;
        }
        
        return $rank->first()->name;

    }

    public static function getId($hours)
    {

        self::init();

        return self::calc($hours, true);

    }

    public static function getName($hours)
    {

        self::init();

        return self::calc($hours, false);

    }

    public static function add($name, $timereq) 
    {

        self::init();

        self::$_db->insert('ranks', array(
            'name' => $name,
            'timereq' => $timereq
        ));

    }

    public static function removeRank($name) 
    {

        self::$_db->delete('ranks', array('name', '=', $name));

    }

    public static function getFirstRank()
    {

        self::init();
        $rank = self::$_db->get('ranks', array('id', '>', '0'), array('timereq', 'asc'));
        return $rank->first()->name;

    }

    public static function idToName($id) 
    {

        self::init();
        $rank = self::$_db->get('ranks', array('id', '=', $id));
        return $rank->first()->name;

    }
    
    public static function nameToId($name) 
    {

        self::init();
        $rank = self::$_db->get('ranks', array('name', '=', $name));
        return $rank->first()->id;

    }

    public static function fetchAllNames() 
    {

        self::init();
        return self::$_db->getAll('ranks');

    }

}