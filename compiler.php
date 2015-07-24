<?php
chdir(__DIR__);

/**
 * Created by PhpStorm.
 * User: alekseyyp
 * Date: 24.07.15
 * Time: 12:32
 */
if ( isset( $_POST['val'] ) ) {

    class Variables {
        public static $data;
    }

    register_shutdown_function(function(){

        $response = [
            'content'   => ob_get_contents()
        ];
        $variables = [];
        foreach ( Variables::$data as $k=>$v ) {

            if ( in_array($k, ['_SERVER', '_POST', '_FILES', '_ENV', '_GET', '_COOKIE', '_REQUEST']) === false ) {


                ob_clean();
                var_dump( $v );
                $variables[] = "<b>" . $k . "</b>" . ob_get_contents();

            }

        }
        ob_clean();
        $response['variables'] = implode( "<br>", $variables );
        echo json_encode( $response );

    });

    ob_start();
    eval( $_POST['val'] );
    Variables::$data = get_defined_vars();
    $fr = fopen( getcwd() . '/code.log', 'a+');
    fwrite($fr, date('Y-m-d H:i:s') . "\n" . $_POST['val'] . "\n ------------ \n");
    fclose($fr);

} else {

    throw new Exception('Welcome in WebAIS laboratory');

}