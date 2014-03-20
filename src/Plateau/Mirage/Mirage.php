<?php
namespace Plateau\Mirage;
use File;
use App;
use Str;
use Config;

// Mirage Simple temporary folder provider that are destroyed 
// at the end of the request lifecycle using App::after Event
class Mirage {
	

	public function request($basePath = null)
	{
		if (! $basePath)
		{
			$basePath = $this->getConfigBasePath();
		}

		// Request a subfolder name and check it doesn't exists
		$fullTempPath = $this->createRandomFolder($basePath);
		
		// Return full path
		return $fullTempPath;
	}


	/**
	 * Get the base path from config
	 * @return [string] Temporary Folder Path 
	 */
	protected function getConfigBasePath()
	{
		$tempLocation = Config::get('mirage::temp_folder_path');
		
		// Check if temp folder exists, create it otherwise
		if (! File::isDirectory($tempLocation))
		{
			File::makeDirectory($tempLocation);
		}
		return $tempLocation;
	}

	/**
	 * Create A random folder in the $basefolder
	 * @param  [type] $baseFolder [description]
	 * @return String : Absolute path to created folder
	 */
	protected function createRandomFolder($baseFolder)
	{
		do
		{
			$subFolder = Str::random(32);
			$fullPath = $baseFolder. '/'. $subFolder;
		}
		while (File::exists($fullPath));

		// Create it
		File::makeDirectory($fullPath);
		
		return $fullPath;
	}

	/**
	 * Will fire event at end of laravel application lifecycle
	 * @param  Folder To Delete
	 * @return void
	 */
	protected function markForDeletion($folder)
	{
		App::after(function($request, $response) use ($folder)
		{
			File::deleteDirectory($folder);
		});
	}
}
