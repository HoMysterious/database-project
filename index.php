<?php
/**
 * Created by PhpStorm.
 * User: HoMys
 * Date: 27/06/2016
 * Time: 04:24 PM
 */

require_once("include/init_mysql.php");
require_once("include/init_routes.php");
require_once("include/IntlDateTime.php");

session_start();

$db = new db();
$db->load_settings();

$PARAMETERS = array();

// Check if specified page parameter in url
$PARAMETERS['page'] = isset($_PARAMS['page']) ? intval($_PARAMS['page']) : 1;

if ($PARAMETERS['page'] < 1) {
    echo "Invalid Page";
    exit();
}

$PARAMETERS['title'] = $_BLOG_SETTINGS->blog_title;
$PARAMETERS['categories'] = $db->load_categories();
$PARAMETERS['curl'] = $_BLOG_SETTINGS->blog_url . '/';

// Check routing and initialize page_type
switch (count($_ROUTES)) {
    case 0:
        $PARAMETERS['page_type'] = 'home';
        $PARAMETERS['slug'] = 'home';
        $db->load_posts();
        include "template/index.php";
        break;
    case 1:
        $PARAMETERS['page_type'] = 'post';
        $PARAMETERS['slug'] = $_ROUTES[0];
        $PARAMETERS['curl'] .= '/' . $_ROUTES[0];
        $PARAMETERS['OBJECT'] = $db->load_single($PARAMETERS['slug']);
        if ($PARAMETERS['OBJECT']) {
            $PARAMETERS['title'] .= ' &mdash; ' . $PARAMETERS['OBJECT']->title;
            include "template/single.php";
        } else {
            _Not_Found();
        }
        break;
    case 2:
        $PARAMETERS['slug'] = urldecode($_ROUTES[1]);
        $PARAMETERS['curl'] .= $_ROUTES[0] . '/' . $_ROUTES[1];
        switch ($_ROUTES[0]) {
            case 'category':
                $PARAMETERS['page_type'] = 'category';
                $PARAMETERS['OBJECT'] = $db->load_category($PARAMETERS['slug']);
                if ($PARAMETERS['OBJECT']) {
                    $PARAMETERS['title'] .= ' &mdash; ' . $PARAMETERS['OBJECT']->title;
                    $db->load_category_posts($PARAMETERS['slug']);
                    include "template/index.php";
                } else {
                    _Not_Found();
                }
                break;
            case 'tag':
                $PARAMETERS['page_type'] = 'tag';
                $PARAMETERS['OBJECT'] = $db->load_tag($PARAMETERS['slug']);
                if ($PARAMETERS['OBJECT']) {
                    $PARAMETERS['title'] .= ' &mdash; ' . $PARAMETERS['OBJECT']->title;
                    $db->load_tag_posts($PARAMETERS['slug']);
                    include "template/index.php";
                } else {
                    _Not_Found();
                }
                break;
            case 'author':
                $PARAMETERS['page_type'] = 'author';
                $PARAMETERS['OBJECT'] = $db->load_author($PARAMETERS['slug']);
                if ($PARAMETERS['OBJECT']) {
                    $PARAMETERS['title'] .= ' &mdash; ' . $PARAMETERS['OBJECT']->username;
                    $db->load_author_posts($PARAMETERS['slug']);
                    include "template/index.php";
                } else {
                    _Not_Found();
                }
                break;
            case 'admin':
                if ($_ROUTES[1] == 'login') {
                    include "admin/login.php";
                } else if (!isset($_SESSION['logged_in'])) {
                    header('Location: ' . $_BLOG_SETTINGS->blog_url . '/admin/login');
                    exit();
                } else {
                    switch ($_ROUTES[1]) {
                        case 'logout':
                            unset($_SESSION['logged_in']);
                            unset($_SESSION['username']);
                            unset($_SESSION['user_id']);
                            header('Location: ' . $_BLOG_SETTINGS->blog_url);
                            exit();
                            break;
                        case 'add_post':
                            include "admin/addpost.php";
                            break;
                        case 'add_category':
                            include "admin/addcategory.php";
                            break;
                        case 'add_tag':
                            include "admin/addtag.php";
                            break;
                        case 'add_author':
                            include "admin/addauthor.php";
                            break;
                        case 'add_link':
                            include "admin/addlink.php";
                            break;
                        case 'edit_settings':
                            include "admin/editsettings.php";
                            break;
                        default:
                            _Not_Found();
                            break;
                    }
                }
                break;
            default:
                _Not_Found();
                break;
        }
        break;
    default:
        _Not_Found();
        break;
}

$db->close();

function _Not_Found()
{
    global $PARAMETERS;
    $PARAMETERS['title'] .= ' &mdash; 404 Not Found!';
    include "template/404.php";
}

function url()
{
    global $_BLOG_SETTINGS;

    echo $_BLOG_SETTINGS->blog_url;
}

?>