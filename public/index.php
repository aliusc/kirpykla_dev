<?php

define('DS', DIRECTORY_SEPARATOR);

define('ROOT', getcwd().DS.'..');
echo ROOT.DS.'config'.DS.'database.php';
require_once ROOT.DS.'config'.DS.'database.php';
require_once ROOT.DS.'config'.DS.'objects.php';

$page = !empty($_GET['page']) ? $_GET['page'] : 'index';
if (!empty($page)) {

    $data = array(
        'index' => array('model' => 'kirpykla', 'view' => 'head', 'controller' => 'welcome'),
        'kirpejai' => array('model' => 'AboutModel', 'view' => 'AboutView', 'controller' => 'AboutController'),
        'portfolio' => array('model' => 'PortfolioModel', 'view' => 'PortfolioView', 'controller' => 'PortfolioController')
    );

    foreach($data as $key => $components){
        if ($page == $key) {
            $model = $components['model'];
            $view = $components['view'];
            $controller = $components['controller'];
            break;
        }
    }

    if (isset($model)) {
        echo "-----;jau cia;-------";
        $m = new $model();
//        $c = new $controller();
        $v = new $view($model);
//        echo $v->output();
    }
}

function __autoload($class_name){
    echo "<b>$class_name</b>";
    echo $lib_path = ROOT . DS . 'lib'.DS.$class_name . '.php';
    echo $controller_path = ROOT . DS . 'controllers'.DS.strtolower($class_name) . '.php';
    echo $model_path = ROOT . DS . 'models'.DS.strtolower($class_name) . '.php';
echo '<br>';
    if(file_exists($lib_path)){
        require_once ($lib_path);
    } else if (file_exists($controller_path)){
        require_once ($controller_path);
    } else if(file_exists($model_path)){
        require_once ($model_path);
    } else {
        throw new Exception("File {$class_name} cannot be found!");
    }

}