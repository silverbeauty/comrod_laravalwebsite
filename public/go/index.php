<?php
session_start();
$id = strtolower(isset( $_GET['id'] ) ? rtrim( trim( $_GET['id'] ), '/' ) : 'default');
$f	= fopen( 'redirects.txt', 'r' );
$urls	= array();
// The file didn't open correctly.
if ( !$f ) {
echo 'Make sure you create your redirects.txt file and that it\'s readable by the redirect script.';
die;
}
// Read the input file and parse it into an array
while( $data = fgetcsv( $f ) ) {
if ( !isset( $data[0] ) || !isset( $data[1] ) )
continue;
$key = trim( strtolower($data[0] ));
$val = trim( $data[1] );
$urls[ $key ] = $val;
}

$id = str_replace("$"," ",$id);
$idarray =preg_split("/[\s]+/",$id);

// Check if the given ID is set, if it is, set the URL to that, if not, default
if (isset($urls[$idarray[0]]))
{
    
    $url = $urls[$idarray[0]];
  
}
else
{
   $url = $urls['default'];
}

switch ($id)
{
case 'wr1-ebay':
     $url = $url;

}
//$url = ( isset( $urls[ $idarray[0] ] ) ) ? $urls[ $id ] : ( isset( $urls[ 'default' ] ) ? $urls[ 'default' ] : false );
 
if ( $url ) {
header( "X-Robots-Tag: noindex, nofollow", true );
header( "Location: " . $url, 302 );
die;	
} else {
header( "X-Robots-Tag: noindex, nofollow", true );
header( "Location: " . "/", 302 );
}
?>