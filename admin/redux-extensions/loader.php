<?php

if(!function_exists('redux_register_instagram_gallery')) {
    function redux_register_instagram_gallery($ReduxFramework) {
        $path    = dirname(__FILE__) . '/extensions/';
        $folders = scandir($path, 1);
        foreach ($folders as $folder) {
            if($folder === '.' or $folder === '..' or !is_dir($path . $folder)) {
                continue;
            }
            $extension_class = 'ReduxFramework_Extension_' . $folder;
            if(!class_exists($extension_class)) {
                $class_file = $path . $folder . '/extension_' . $folder . '.php';
                $class_file = apply_filters( 'redux/extension/' . $ReduxFramework->args['opt_name'] . '/' . $folder, $class_file );
                if($class_file) {
                    require_once($class_file);
                }
            }
            if(!isset($ReduxFramework->extensions[$folder])) {
                $ReduxFramework->extensions[$folder] = new $extension_class($ReduxFramework);
            }
        }
    }

    add_action("redux/extensions/{$skeleton_wp}/before", 'redux_register_instagram_gallery', 0);
}

if(!function_exists('redux_register_button')) {
    function redux_register_button($ReduxFramework) {
        $path    = dirname(__FILE__) . '/extensions/';
        $folders = scandir($path, 1);
        foreach ($folders as $folder) {
            if($folder === '.' or $folder === '..' or !is_dir($path . $folder)) {
                continue;
            }
            $extension_class = 'ReduxFramework_Extension_' . $folder;
            if(!class_exists($extension_class)) {
                $class_file = $path . $folder . '/extension_' . $folder . '.php';
                $class_file = apply_filters( 'redux/extension/' . $ReduxFramework->args['opt_name'] . '/' . $folder, $class_file );
                if($class_file) {
                    require_once($class_file);
                }
            }
            if(!isset($ReduxFramework->extensions[$folder])) {
                $ReduxFramework->extensions[$folder] = new $extension_class($ReduxFramework);
            }
        }
    }

    add_action("redux/extensions/{$skeleton_wp}/before", 'redux_register_button', 0);
}
