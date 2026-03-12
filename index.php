<?php
// index.php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'config/database.php';

$base_url = "https://auladireta.com.br/index.php?url=";

// Simple Router
$url = isset($_GET['url']) ? $_GET['url'] : 'home';
$url = rtrim($url, '/');

$db = (new Database())->getConnection();

// Basic Layout Components
function render_header($title = "Aula Direta")
{
    global $db, $page_title;
    include 'views/header.php';
}

function render_footer()
{
    global $db;
    include 'views/footer.php';
}

// Logic to determine which view to load
switch ($url) {
    case 'home':
    case '':
        include 'models/Course.php';
        $courseModel = new Course($db);
        $courses = $courseModel->getAll(true);
        include 'views/home.php';
        break;

    case 'login':
        include 'views/login.php';
        break;

    case 'register':
        include 'views/register.php';
        break;

    case 'logout':
        session_destroy();
        session_write_close();
        header('Location: ' . $base_url . 'home');
        break;

    case 'blog':
        include 'views/blog.php';
        break;

    case 'quem-somos':
        include 'views/quem_somos.php';
        break;

    case 'politica-privacidade':
        include 'views/politica_privacidade.php';
        break;

    case 'post':
        if (isset($_GET['slug'])) {
            include 'views/blog_post.php';
        } else {
            session_write_close();
            header('Location: ' . $base_url . 'blog');
        }
        break;

    case 'admin':
        if (isset($_SESSION['user_id'])) {
            $view = isset($_GET['view']) ? $_GET['view'] : 'dashboard';
            if ($_SESSION['user_nivel'] == 'admin') {
                if ($view == 'blog') {
                    include 'views/admin_blog.php';
                } elseif ($view == 'blog_form') {
                    include 'views/admin_blog_form.php';
                } elseif ($view == 'comments') {
                    include 'views/admin_comments.php';
                } elseif ($view == 'courses') {
                    include 'views/admin_courses.php';
                } elseif ($view == 'course_form') {
                    include 'views/admin_course_form.php';
                } else {
                    include 'views/dashboard_admin.php';
                }
            } else {
                include 'views/dashboard_client.php';
            }
        } else {
            session_write_close();
            header('Location: ' . $base_url . 'login');
        }
        break;

    case 'cart':
        include 'views/cart.php';
        break;

    case 'add-cart':
        if (isset($_GET['id'])) {
            include 'models/Course.php';
            include 'controllers/CartController.php';
            $courseModel = new Course($db);
            $course = $courseModel->getById($_GET['id']);
            if ($course) {
                $cart = new CartController();
                $cart->add($course['id'], $course['preco_vista'], $course['titulo']);
            }
        }
        session_write_close();
        header('Location: ' . $base_url . 'cart');
        break;

    case 'remove-cart':
        if (isset($_GET['id'])) {
            include 'controllers/CartController.php';
            $cart = new CartController();
            $cart->remove($_GET['id']);
        }
        session_write_close();
        header('Location: ' . $base_url . 'cart');
        break;

    case 'checkout':
        if (!isset($_SESSION['user_id'])) {
            session_write_close();
            header('Location: ' . $base_url . 'login');
            exit();
        }
        include 'controllers/CartController.php';
        $cart = new CartController();
        if ($cart->checkoutSimulation($db, $_SESSION['user_id'])) {
            $_SESSION['msg'] = "Sua matrícula foi realizada com sucesso!";
            session_write_close();
            header('Location: ' . $base_url . 'admin');
        } else {
            $_SESSION['error'] = "Erro ao processar matrícula.";
            session_write_close();
            header('Location: ' . $base_url . 'cart');
        }
        break;

    default:
        // Handle other routes or 404
        echo "404 - Not Found";
        break;
}
?>