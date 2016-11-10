<?php
/**
 * Created by PhpStorm.
 * User: HoMys
 * Date: 27/06/2016
 * Time: 04:56 PM
 */

require_once("config.php");

class db
{
    private $db;
    private $result;
    private $category;
    private $links;
    private $author;
    private $tag;
    private $comments;
    private $count;

    function db()
    {
        $this->db = new mysqli(__DB_HOST, __DB_USER, __DB_PASS, __DB_NAME, __DB_PORT) or die("<h3>Can't connect to MySQL database. Check config.php file.");

        if ($this->db->connect_error)
            die('MySQL Connection Error (' . $this->db->connect_errno . ') ' .
                $this->db->connect_error);

        $this->db->set_charset("utf8");
    }

    function close()
    {
        $this->db->close();
    }

    function get_count()
    {
        return $this->count;
    }

    function get_error()
    {
        return $this->db->error;
    }

    function insert_id()
    {
        return $this->db->insert_id;
    }

    function query($SQL)
    {
        return $this->db->query($SQL);
    }

    function escape($string)
    {
        return $this->db->real_escape_string($string);
    }

    function next_row()
    {
        return $this->result->fetch_object();
    }

    function load_categories()
    {
        $SQL = 'SELECT * FROM `categories`';

        $this->category = $this->db->query($SQL);
    }

    function next_category()
    {
        return $this->category->fetch_object();
    }

    function load_authors()
    {
        $SQL = 'SELECT `username`, COUNT(`posts`.`id`) AS `posts_count` FROM `authors` LEFT JOIN `posts` ON `authors`.`id` = `posts`.`user_id` AND `posts`.`active` = TRUE GROUP BY `username`';

        $this->author = $this->db->query($SQL);
    }

    function next_author()
    {
        return $this->author->fetch_object();
    }

    function load_tags()
    {
        $SQL = 'SELECT `tags`.`id`, `tags`.`title`, `tags`.`name`, COUNT(`posts`.`id`) AS `posts_count` FROM `tags` LEFT JOIN `tag_relationship` ON `tags`.`id` = `tag_relationship`.`tag_id` LEFT JOIN `posts` ON `posts`.`id` = `tag_relationship`.`post_id` AND `posts`.`active` = TRUE GROUP BY `tags`.`id`, `tags`.`title`, `tags`.`name`';

        $this->tag = $this->db->query($SQL);
    }

    function next_tag()
    {
        return $this->tag->fetch_object();
    }

    function load_links()
    {
        $SQL = 'SELECT * FROM `links`';

        $this->links = $this->db->query($SQL);
    }

    function next_link()
    {
        return $this->links->fetch_object();
    }

    function load_comments($post_id)
    {
        $SQL = 'SELECT * FROM `comments` WHERE `post_id` = ' . $post_id;

        $this->comments = $this->db->query($SQL);
    }

    function next_comment()
    {
        return $this->comments->fetch_object();
    }

    function load_settings()
    {
        global $_BLOG_SETTINGS;
        $_BLOG_SETTINGS = new stdClass();

        $result = $this->db->query('SELECT * FROM `settings`');

        if ($result)
            $_BLOG_SETTINGS = $result->fetch_object();
        else
            die("Can't fetch settings from database.");
    }

    function load_posts()
    {
        global $_BLOG_SETTINGS, $PARAMETERS;

        $SQL = sprintf('SELECT * FROM `posts` WHERE `posts`.`active` = true ORDER BY `date` DESC LIMIT %d, %d',
            ($PARAMETERS['page'] - 1) * $_BLOG_SETTINGS->posts_per_page, $PARAMETERS['page'] * $_BLOG_SETTINGS->posts_per_page);

        $this->result = $this->db->query($SQL);
        $this->count = $this->db->query('SELECT COUNT(*) AS C FROM `posts`')->fetch_object()->C;
    }

    function load_single($slug)
    {
        $SQL = sprintf('SELECT * FROM `posts` WHERE `posts`.`id` = %s', $this->db->real_escape_string($slug));

        $r = $this->db->query($SQL);

        return $r ? $r->fetch_object() : false;
    }

    function load_category($category)
    {
        $SQL = sprintf('SELECT * FROM `categories` WHERE `categories`.`name` = \'%s\'', $this->db->real_escape_string($category));

        $r = $this->db->query($SQL);

        return $r ? $r->fetch_object() : false;
    }

    function load_category_posts($category)
    {
        global $_BLOG_SETTINGS, $PARAMETERS;

        $SQL = sprintf('SELECT `posts`.* FROM `posts` INNER JOIN `category_relationship` ON `posts`.`id` = `category_relationship`.`post_id` INNER JOIN `categories` ON `categories`.`id` = `category_relationship`.`category_id` WHERE `posts`.`active` = true AND `categories`.`name` = \'%s\'  ORDER BY `date` DESC LIMIT %d, %d',
            $this->db->real_escape_string($category), ($PARAMETERS['page'] - 1) * $_BLOG_SETTINGS->posts_per_page, $PARAMETERS['page'] * $_BLOG_SETTINGS->posts_per_page);

        $this->result = $this->db->query($SQL);
        $this->count = $this->db->query(sprintf('SELECT COUNT(*) AS C FROM `posts` INNER JOIN `category_relationship` ON `posts`.`id` = `category_relationship`.`post_id` INNER JOIN `categories` ON `categories`.`id` = `category_relationship`.`category_id` WHERE `posts`.`active` = true AND `categories`.`name` = \'%s\'',
            $this->db->real_escape_string($category)))->fetch_object()->C;
    }

    function load_tag($tag)
    {
        $SQL = sprintf('SELECT * FROM `tags` WHERE `tags`.`name` = \'%s\'', $this->db->real_escape_string($tag));

        $r = $this->db->query($SQL);

        return $r ? $r->fetch_object() : false;
    }

    function load_tag_posts($tag)
    {
        global $_BLOG_SETTINGS, $PARAMETERS;

        $SQL = sprintf('SELECT `posts`.* FROM `posts` INNER JOIN `tag_relationship` ON `posts`.`id` = `tag_relationship`.`post_id` INNER JOIN `tags` ON `tags`.`id` = `tag_relationship`.`tag_id` WHERE `posts`.`active` = true AND `tags`.`name` = \'%s\' ORDER BY `date` DESC LIMIT %d, %d',
            $this->db->real_escape_string($tag), ($PARAMETERS['page'] - 1) * $_BLOG_SETTINGS->posts_per_page, $PARAMETERS['page'] * $_BLOG_SETTINGS->posts_per_page);

        $this->result = $this->db->query($SQL);

        $this->count = $this->db->query(sprintf('SELECT COUNT(*) AS C FROM `posts` INNER JOIN `tag_relationship` ON `posts`.`id` = `tag_relationship`.`post_id` INNER JOIN `tags` ON `tags`.`id` = `tag_relationship`.`tag_id` WHERE `posts`.`active` = true AND `tags`.`name` = \'%s\'',
            $this->db->real_escape_string($tag)))->fetch_object()->C;
    }

    function load_author($author)
    {
        $SQL = sprintf('SELECT * FROM `authors` WHERE `authors`.`username` = \'%s\'', $this->db->real_escape_string($author));

        $r = $this->db->query($SQL);

        return $r ? $r->fetch_object() : false;
    }

    function load_author_posts($author)
    {
        global $_BLOG_SETTINGS, $PARAMETERS;

        $SQL = sprintf('SELECT `posts`.* FROM `posts` INNER JOIN `authors` ON `posts`.`user_id` = `authors`.`id` WHERE `posts`.`active` = true AND `authors`.`username` = \'%s\' ORDER BY `date` DESC LIMIT %d, %d',
            $this->db->real_escape_string($author), ($PARAMETERS['page'] - 1) * $_BLOG_SETTINGS->posts_per_page, $PARAMETERS['page'] * $_BLOG_SETTINGS->posts_per_page);

        $this->result = $this->db->query($SQL);
        $this->count = $this->db->query(sprintf('SELECT COUNT(*) AS C FROM `posts` INNER JOIN `authors` ON `posts`.`user_id` = `authors`.`id` WHERE `posts`.`active` = true AND `authors`.`username` = \'%s\'',
            $this->db->real_escape_string($author)))->fetch_object()->C;
    }
}