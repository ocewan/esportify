<?php
session_start();
require_once __DIR__ . '/../helpers/auth.php';

// Liste des contrôleurs autorisés
if (isset($_GET['controller'])) {
    switch ($_GET['controller']) {
        case 'login':
            require __DIR__ . '/../controllers/auth/process_login.php';
            break;
        case 'redirect_dashboard':
            require __DIR__ . '/../controllers/redirect_to_dashboard.php';
            break;
        case 'register':
            require __DIR__ . '/../controllers/auth/process_register.php';
            break;
        case 'edit_event':
            require __DIR__ . '/../controllers/events/process_edit_event.php';
            break;
        case 'create_event':
            require __DIR__ . '/../controllers/events/process_create_event.php';
            break;
        case 'validate_event':
            require __DIR__ . '/../controllers/events/process_validate_event.php';
            break;
        case 'update_user_role':
            require __DIR__ . '/../controllers/admin/update_user_role.php';
            break;
        case 'refuse_participant':
            require __DIR__ . '/../controllers/events/process_refuse_participant.php';
            break;
        case 'join_event':
            require __DIR__ . '/../controllers/events/process_join_event.php';
            break;
        case 'leave_event':
            require __DIR__ . '/../controllers/events/process_leave_event.php';
            break;
        case 'start_event':
            require __DIR__ . '/../controllers/events/process_start_event.php';
            break;
        case 'enter_event':
            require __DIR__ . '/../controllers/events/process_enter_event.php';
            break;
        case 'subscribe_newsletter':
            require __DIR__ . '/../controllers/newsletter/process_newsletter.php';
            break;
        case 'ajax_events':
            require_once __DIR__ . '/../controllers/events/ajax_events.php';
            exit;
        case 'event_details':
            require_once __DIR__ . '/../controllers/events/event_details.php';
            exit;

        default:
            http_response_code(404);
            echo "Contrôleur inconnu.";
            exit;
    }
    exit;
}

// Liste des pages autorisées
$page = $_GET['page'] ?? 'accueil';

switch ($page) {
    case 'home':
        require_login();
        require __DIR__ . '/../views/home.php';
        break;
    case 'contact':
        require __DIR__ . '/../views/contact.php';
        break;
    case 'joueur':
        require_role(2);
        require __DIR__ . '/../views/joueur/dashboard.php';
        break;
    case 'organisateur':
        require_role(3);
        require __DIR__ . '/../views/organisateur/dashboard.php';
        break;
    case 'admin':
        require_role(4);
        require __DIR__ . '/../views/admin/dashboard.php';
        break;
    case 'event_list':
        require __DIR__ . '/../views/event/list_event_page.php';
        break;
    case 'register':
        require __DIR__ . '/../views/register.php';
        break;
    case 'login':
        require __DIR__ . '/../views/login.php';
        break;
    case 'logout':
        require __DIR__ . '/../controllers/auth/process_logout.php';
        break;
    case 'edit_event':
        require_login(3);
        require __DIR__ . '/../views/partials/event/edit_event.php';
        break;
    case 'event':
        require __DIR__ . '/../views/event/event_page.php';
        break;

    case 'accueil':
    default:
        // Si connecté, rediriger vers home
        if (isset($_SESSION['user_id'])) {
            header('Location: /index.php?page=home');
            exit;
        }
        require __DIR__ . '/../views/accueil.php'; // page d'accueil publique
        break;
}
?>
