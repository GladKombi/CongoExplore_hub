<?php

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        $this->startSession();
        extract($data, EXTR_OVERWRITE);
        $content = $this->loadView($view, $data);
        require __DIR__ . '/../Views/layout.php';
    }

    protected function render(string $view, array $data = []): void
    {
        extract($data, EXTR_OVERWRITE);
        require __DIR__ . '/../Views/' . $view . '.php';
    }

    protected function loadView(string $view, array $data = []): string
    {
        extract($data, EXTR_OVERWRITE);
        ob_start();
        require __DIR__ . '/../Views/' . $view . '.php';
        return ob_get_clean();
    }

    protected function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function redirect(string $path = ''): void
    {
        $this->startSession();
        $path = ltrim($path, '/');
        header('Location: ' . BASE_URL . $path);
        exit;
    }

    protected function loginUser(array $user): void
    {
        $this->startSession();
        $_SESSION['user'] = [
            'id' => $user['id'],
            'nom' => $user['nom'],
            'prenom' => $user['prenom'],
            'email' => $user['email'],
            'role' => $user['role'],
            'photo_profil' => $user['photo_profil'] ?? null,
        ];
    }

    protected function logoutUser(): void
    {
        $this->startSession();
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }

        session_destroy();
    }

    protected function getUser(): ?array
    {
        $this->startSession();
        return $_SESSION['user'] ?? null;
    }

    protected function getUserRole(): ?string
    {
        $user = $this->getUser();
        return $user['role'] ?? null;
    }

    protected function hasRole(array $roles): bool
    {
        $role = $this->getUserRole();
        return $role !== null && in_array($role, $roles, true);
    }

    protected function isAuthenticated(): bool
    {
        $this->startSession();
        return !empty($_SESSION['user']);
    }

    protected function requireAuth(): void
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('login');
        }
    }

    protected function requireRole(array $roles): void
    {
        $this->requireAuth();
        if (!$this->hasRole($roles)) {
            $this->redirect('dashboard');
        }
    }
}
