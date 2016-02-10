<?php

/*

	read CSV and remove subscribers from the BNC Authority list


*/

// need the BNC email functions
require( "bnc-functions.php" );

// should be a command line param but...
$csv_file = "6-10-2014.csv";

// get the rows as an array
$rows = csv_to_array( $csv_file );

// did we get the right number of rows? if not something went wrong
print "\n\n" . count( $rows ) . "\n\n";

// walk the rows
foreach ( $rows as $row )
{

    // email is the first column
	$email_address = $row[0];
	
    // check it actually is an email - this is too basic but works for this specific CSV
	if ( strstr( $email_address, "@") )
	{
	
        // formatting
		print( "-----------------------------------------\n");		
		print " --> $email_address \n";

        // unsubscribe and return result	
		$response = nimble_unsubscribe( $email_address, "authority", "CANCELLED" );
		print_r( $response );
		
        // formatting
		print " --> $email_address \n";	
		print( "-----------------------------------------\n");
	
	

	}

}



/** function to read CSV and convert to an array
 *
 * @param string $csv_file (default: "")
 */
function csv_to_array( $csv_file )
{

	$rows = array();

	if ( ( $handle = fopen( $csv_file, "r" ) ) !== FALSE ) 
	{
	    while ( ( $data = fgetcsv( $handle, 1000, "," ) ) !== FALSE ) 
	    {
	            $rows[] = $data;
	    }
	    fclose( $handle );
	}
	
	return $rows;
}




/**
 * nimble_list_id_for_friendly_name function.
 * 
 * return the list id for a given friendly string version of the name
 * just so we only have to change list id in one place and make case-insensitive
 *
 * @param string $list (default: "")
 * @return int
 */
function nimble_list_id_for_friendly_name( $list = "" )
{

	$list_id = false;

	switch ( strtolower( $list ) ) {

	    case "authority":
	        $list_id = 3;
	        break;

	    case "rainmaker authority":
	        $list_id = 3;
	        break;

	    case "mycopyblogger":
	        $list_id = 5;
	        break;

	    case "ts-pre-sales":
	        $list_id = 31;
	        break;

	    case "ts-customers":
	        $list_id = 29;
	        break;

	    case "intensive":
	        $list_id = 35;
	        break;
	        
	    case "certification":
	        $list_id = 49;
	        break;
	        

	        
	        
    }

	return $list_id;
}




?>
