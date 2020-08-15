<?php

/*
Flare, a fully featured and easy to use crew centre, designed for Infinite Flight.
Copyright (C) 2020  Lucas Rebato

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/

class News
{

    private static $_db;

    private static function init()
    {

        self::$_db = DB::getInstance();

    }

    public static function get()
    {

        self::init();

        $result = self::$_db->get('news', array('status', '=', 1), array('dateposted', 'DESC'));

        $x = 0;
        $news = array();

        if ($result->count() < 1) {
            return array();
        }

        while ($x < $result->count()) {
            $newdata = array(
                'id' => $result->results()[$x]->id,
                'title' => $result->results()[$x]->subject,
                'author' => $result->results()[$x]->author,
                'content' => $result->results()[$x]->content,
                'dateposted' => $result->results()[$x]->dateposted
            );
            $news[$x] = $newdata;
            $x++;
        }
        return $news;

    }

    public static function archive($id)
    {

        self::init();

        self::$_db->update('news', $id, 'id', array(
            'status' => 2
        ));

    }

    public static function edit($id, $fields) 
    {

        self::init();

        self::$_db->update('news', $id, 'id', $fields);

    }

    public static function new($fields) 
    {

        self::init();

        self::$_db->insert('news', $fields);

    }

}