<?php
//alternativa => https://github.com/Xeoncross/1kb-PHP-MVC-Framework/blob/master/classes/view.php
class View
{

    /**
     * Render a view file
     *
     * @param string $view  The view file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = dirname(__DIR__) . "/Views/" . $view . "View.php";  // relative to Core directory

        if (is_readable($file)) {
            require dirname(__DIR__) . "/Views/headerView.php";
            require $file;
            require dirname(__DIR__) . "/Views/footerView.php";
        } else {
            throw new \Exception("$file not found");
        }
    }
    public static function fetch($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = dirname(__DIR__) . "/Fetch/" . $view . "Fetch.php";  // relative to Core directory

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }
}
