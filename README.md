# single-page-photography-portfolio
Single Page PHP Photography Portfolio

This is a single page application using php + bootstrap + jquery. 

It does not use any database for the content. 

The menu and bootstrap carousel are dynamically generated from the folder structure containing the image files. 

Title and description for each photo is read from the photos IPTC Title and Caption fields respectively ( I use Lightroom to set these fields )
$iptc['2#005']['0'] & $iptc['2#120']['0'] from php's iptcparse() function : https://www.php.net/manual/en/function.iptcparse.php

Create a directory corresponding to $photos_dir="photodir/";  and create sub dirs that correspond to each Menu item that you want to display. 
Place your tagged images in the above dir's as needed. 

This has been tested on PHP 7.3.20 but should work with any version >PHP 5.0 

See a live demo at https://www.sylvesterdsouza.com/ 
