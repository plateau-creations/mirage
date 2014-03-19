<?php
namespace Plateau\Mirage;
use File;
use App;
use Str;
use Config;

// Mirage Simple temporary folder provider that are destroyed 
// at the end of the request lifecycle using App::after Event
class Mirage {
	
	public $path;

	public function request()
	{
		$tempLocation = Config::get('mirage::temp_folder_path');
		
		// Check if temp folder exists, create it otherwise
		if (! File::isDirectory($tempLocation))
		{
			File::makeDirectory($tempLocation);
		}

		// Request a subfolder name and check it doesn't exists
		do
		{
			$subFolder = Str::random(32);
			$fullTempPath = $tempLocation. '/'. $subFolder;
		}
		while (File::exists($fullTempPath));

		// Create it
		File::makeDirectory($fullTempPath);
		
		App::after(function($request, $response) use ($fullTempPath)
		{
		    // Delete $tempFolder
		    File::deleteDirectory($fullTempPath);
		});

		// Return full path
		return $fullTempPath;
	}


}
