<?php
require_once __DIR__ . '/../Models/Utilisateur.php';

class LoginController extends Controller
{
    public function index(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processLogin();
            return;
        }

        if ($this->isAuthenticated()) {
            $this->redirect('');
        }

        $this->render('login/index', ['title' => 'Connexion', 'error' => null]);
    }

    private function processLogin(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            $this->render('login/index', ['title' => 'Connexion', 'error' => 'Veuillez remplir tous les champs.']);
            return;
        }

        $model = new Utilisateur();
        $utilisateur = $model->findByEmail($email);

        if (!$utilisateur) {
            $this->render('login/index', ['title' => 'Connexion', 'error' => 'Email ou mot de passe invalide. (User not found)']);
            return;
        }

        $hash = $utilisateur['mot_de_passe'];

        if ($password === $hash || password_verify($password, $hash)) {
            $this->loginUser($utilisateur);
            $this->redirect('dashboard');
            return;
        }

        $this->render('login/index', ['title' => 'Connexion', 'error' => 'Email ou mot de passe invalide.']);
    }

    public function logout(): void
    {
        $this->logoutUser();
        $this->redirect('login');
    }
}
