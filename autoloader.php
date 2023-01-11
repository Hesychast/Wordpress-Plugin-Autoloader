<?php
function yv_autoloader( $class )
{
    // Transform a received class name string to the array divided by namespace separators.
    $class_array = explode( '\\', $class );

    // Remove parent namespace because it is only prefix not a directory and actually doesn't exists in path
    array_shift( $class_array );

    // Extract the name of the class from the received class name string,
    // transform it to lowercase, convert all underscores to hyphens containing in it,
    // and add the 'class-' prefix and '.php' postfix to the extracted class name.
    $class_name =  'class-' . str_replace( '_', '-', strtolower( array_pop( $class_array ) ) ) . '.php';

    // Array for transformed elements of real path to the class file.
    $path_array = [];

    // Convert all remaining array elements to lowercase and fill up a new array with them.
    foreach( $class_array as $element) {
        array_push( $path_array, strtolower($element) );
    }

    // Add the transformed name of the class file.
    array_push( $path_array, $class_name);

    // Convert array elements to the real path string
    $class_path = realpath( implode( DIRECTORY_SEPARATOR, $path_array ) );

    // Check file exists
    if ( ! is_file( $class_path ) ) {
        return;
    }

    require_once $class_path;
}

spl_autoload_register( 'yv_autoloader' );