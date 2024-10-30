<?php

defined( 'ABSPATH' ) or die( 'Silence is Golden.' );


function mcpup_checkbox_validation($value){
    if( $value == 1 ){
        return $value;
    }else{
        return '';
    }
}


function mcpup_number_validation($value){
    if( is_numeric($value) ){
        return $value;
    }else{
        return 168;
    }
}


function mcpup_radio_validation($value){
    if( $value == 'r' or $value == 'o' or $value == 'h' ){
        return $value;
    }else{
        return 'o';
    }
}