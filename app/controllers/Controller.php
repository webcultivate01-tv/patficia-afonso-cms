<?php
class Controller {
    protected function render(string $view, array $data = [], bool $standalone = false): void {
        extract($data);
        $viewFile = __DIR__ . "/../views/{$view}.php";
        if ($standalone) {
            require $viewFile;
        } else {
            require __DIR__ . '/../views/layouts/main.php';
        }
    }
}
