<?php
// index.php
session_start();
require_once 'config/database.php';

// Simple Router
$url = isset($_GET['url']) ? $_GET['url'] : 'home';
$url = rtrim($url, '/');

$db = (new Database())->getConnection();

// Basic Layout Components
function render_header($title = "Aula Direta")
{
    include 'views/header.php';
}

function render_footer()
{
    include 'views/footer.php';
}

// Logic to determine which view to load
switch ($url) {
    case 'home':
    case '':
        include 'models/Course.php';
        $courseModel = new Course($db);
        $courses = $courseModel->getAll();
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
        header('Location: /home');
        break;

    case 'blog':
        include 'views/blog.php';
        break;

    case 'post':
        if (isset($_GET['slug'])) {
            include 'views/blog_post.php';
        } else {
            header('Location: /blog');
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
                } else {
                    include 'views/dashboard_admin.php';
                }
            } else {
                include 'views/dashboard_client.php';
            }
        } else {
            header('Location: /login');
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
        header('Location: /cart');
        break;

    case 'remove-cart':
        if (isset($_GET['id'])) {
            include 'controllers/CartController.php';
            $cart = new CartController();
            $cart->remove($_GET['id']);
        }
        header('Location: /cart');
        break;

    case 'checkout':
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
        include 'controllers/CartController.php';
        $cart = new CartController();
        if ($cart->checkoutSimulation($db, $_SESSION['user_id'])) {
            $_SESSION['msg'] = "Sua matrícula foi realizada com sucesso!";
            header('Location: /admin');
        } else {
            $_SESSION['error'] = "Erro ao processar matrícula.";
            header('Location: /cart');
        }
        break;

    default:
        // Handle other routes or 404
        echo "404 - Not Found";
        break;
}
?>