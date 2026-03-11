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

    case 'admin':
        if (isset($_SESSION['user_nivel']) && $_SESSION['user_nivel'] == 'admin') {
            include 'views/dashboard_admin.php';
        } else {
            header('Location: /login');
        }
        break;

    case 'logout':
        session_destroy();
        header('Location: /home');
        break;

    default:
        // Handle other routes or 404
        echo "404 - Not Found";
        break;
}
?>